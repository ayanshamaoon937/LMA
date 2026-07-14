/**
 * form-validator.js
 * ─────────────────────────────────────────────────────────────────────────────
 * Pure validation layer. No AJAX logic here.
 * Reads required/type/name attributes automatically from the DOM.
 * Calls submitForm() (from ajax-handler.js) only when validation passes.
 *
 * CDN required in layout:
 *   <script src="https://cdn.jsdelivr.net/npm/just-validate@4/dist/just-validate.production.min.js"></script>
 *
 * How to use:
 *   1. Add class="ajax-form" to any <form>
 *   2. Add data-redirect="/url" on the form if you want a redirect after success
 *   3. Add data-success-title / data-success-text on the form to customise the alert
 *   4. That's it — everything else is automatic
 *
 * For extra per-form rules, call addExtraRules(validator, form) below.
 */

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('form.ajax-form').forEach(form => {
        initValidator(form);
    });

    // ── Password toggle (for all forms) ───────────────────────────────────────
    document.querySelectorAll('.js-password-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.closest('.relative')?.querySelector('input');
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.querySelector('.icon-eye-off')?.classList.toggle('hidden', isPassword);
            btn.querySelector('.icon-eye')?.classList.toggle('hidden', !isPassword);
        });
    });

});

// ─────────────────────────────────────────────────────────────────────────────
// Core: initialise just-validate for a single form
// ─────────────────────────────────────────────────────────────────────────────

function initValidator(form) {
    if (form.dataset.validatorInitialized) return;
    form.dataset.validatorInitialized = 'true';

    // Ensure the form has an ID (just-validate needs it)
    if (!form.id) form.id = `form-${Math.random().toString(36).substr(2, 9)}`;

    const validator = new JustValidate(`#${form.id}`, {
        errorFieldCssClass:   ['border-[#f11a21]', '!border-2'],
        // successFieldCssClass: ['border-green-500', '!border-2'],
        errorLabelCssClass:   ['text-[#f11a21]', 'text-xs', 'mt-1', 'block', 'error-label'],
        errorLabelStyle:      '',           // let Tailwind handle it
        focusInvalidField:    true,
        lockForm:             true,
    });
    
    // Store it on the form for external revalidation
    form.validatorInstance = validator;

    // ── Step 1: Auto-rules from HTML attributes ────────────────────────────────
    autoRegisterFields(validator, form);

    // ── Step 2: Extra custom rules per form ───────────────────────────────────
    addExtraRules(validator, form);

    // ── Step 3: On pass → hand off to AJAX layer ──────────────────────────────
    validator.onSuccess(() => {
        submitForm(form, validator, {
            successTitle:      form.dataset.successTitle  || 'Success!',
            successText:       form.dataset.successText   || 'Operation completed successfully.',
            successIcon:       form.dataset.successIcon   || 'success',
            redirectOnSuccess: form.dataset.redirect      || null,
            resetOnSuccess:    form.dataset.reset !== 'false',
        });
    });

    // ── Step 4: On fail → smoothly scroll to first error label ────────────────
    validator.onFail(() => {
        setTimeout(() => {
            const firstError = form.querySelector('.error-label');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 50);
    });

    return validator;
}

// ─────────────────────────────────────────────────────────────────────────────
// Auto-register rules based on HTML attributes (required, type, name)
// ─────────────────────────────────────────────────────────────────────────────

function autoRegisterFields(validator, form) {

    form.querySelectorAll('input, textarea, select').forEach(input => {
        const name = input.name;
        if (!name || input.type === 'hidden' || input.type === 'submit') return;

        const rules = [];
        const label = formatLabel(name);

        // required attribute
        if (input.required) {
            rules.push({
                rule: 'required',
                errorMessage: `${label} is required.`,
            });
        }

        // type="email"
        if (input.type === 'email' || name === 'email') {
            rules.push({
                rule: 'email',
                errorMessage: 'Please enter a valid email address.',
            });
        }

        // minlength attribute
        if (input.minLength > 0) {
            rules.push({
                rule: 'minLength',
                value: input.minLength,
                errorMessage: `${label} must be at least ${input.minLength} characters.`,
            });
        }

        // maxlength attribute
        if (input.maxLength > 0 && input.maxLength < 524288) {
            rules.push({
                rule: 'maxLength',
                value: input.maxLength,
                errorMessage: `${label} must be no more than ${input.maxLength} characters.`,
            });
        }

        if (rules.length > 0) {
            const config = {};
            if (input.dataset.errorsContainer) {
                config.errorsContainer = input.dataset.errorsContainer;
            }
            validator.addField(`[name="${name}"]`, rules, config);
        }
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// Extra custom rules — add form-specific logic here
// ─────────────────────────────────────────────────────────────────────────────

function addExtraRules(validator, form) {


  if (form.id === 'login-form' || form.id === 'host-login-form') {
    ['password'].forEach(fieldName => {
         const passwordField = form.querySelector(`[name="${fieldName}"]`);
        if (passwordField) {
            const rules = [
                { rule: 'required',  errorMessage: 'Password is required' },
            ];
            const config = {};
            if (passwordField.dataset.errorsContainer) {
                config.errorsContainer = passwordField.dataset.errorsContainer;
            }

            validator.addField(`[name="${fieldName}"]`, rules, config);
        }
    });
  }
   else{
     // ── Password field: min 8 chars + must contain a number ───────────────────
    ['password', 'new_password'].forEach(fieldName => {
        const passwordField = form.querySelector(`[name="${fieldName}"]`);
        if (passwordField) {
            const rules = [
                { rule: 'minLength', value: 8, errorMessage: 'Password must be at least 8 characters.' },
                {
                    validator: value => /\d/.test(value),
                    errorMessage: 'Password must contain at least one number.',
                },
            ];
            
            // Only add required rule if not already present from HTML attribute
            if (!passwordField.required) {
                rules.unshift({ rule: 'required', errorMessage: 'Password is required.' });
            }
            const config = {};
            if (passwordField.dataset.errorsContainer) {
                config.errorsContainer = passwordField.dataset.errorsContainer;
            }

            validator.addField(`[name="${fieldName}"]`, rules, config);
        }
    });
   }

    // ── Password confirmation: must match password ─────────────────────────────
    if (form.querySelector('[name="password_confirmation"]') && form.querySelector('[name="password"]')) {
        const confirmField = form.querySelector('[name="password_confirmation"]');
        const confirmConfig = {};
        if (confirmField.dataset.errorsContainer) {
            confirmConfig.errorsContainer = confirmField.dataset.errorsContainer;
        }
        validator.addField('[name="password_confirmation"]', [
            { rule: 'required', errorMessage: 'Please confirm your password.' },
            {
                validator: (value) => value === form.querySelector('[name="password"]')?.value,
                errorMessage: 'Passwords do not match.',
            },
        ], confirmConfig);
    }

    if (form.querySelector('[name="new_password_confirmation"]') && form.querySelector('[name="new_password"]')) {
        const newConfirmField = form.querySelector('[name="new_password_confirmation"]');
        const newConfirmConfig = {};
        if (newConfirmField.dataset.errorsContainer) {
            newConfirmConfig.errorsContainer = newConfirmField.dataset.errorsContainer;
        }
        validator.addField('[name="new_password_confirmation"]', [
            { rule: 'required', errorMessage: 'Please confirm your password.' },
            {
                validator: (value) => value === form.querySelector('[name="new_password"]')?.value,
                errorMessage: 'Passwords do not match.',
            },
        ], newConfirmConfig);
    }

    // ── Terms checkbox ─────────────────────────────────────────────────────────
    if (form.querySelector('[name="agree_terms"]')) {
        const termsField = form.querySelector('[name="agree_terms"]');
        const termsConfig = {};
        if (termsField.dataset.errorsContainer) {
            termsConfig.errorsContainer = termsField.dataset.errorsContainer;
        }
        validator.addField('[name="agree_terms"]', [
            {
                validator: () => form.querySelector('[name="agree_terms"]').checked,
                errorMessage: 'You must agree to the Terms of Use and Privacy Policy.',
            },
        ], termsConfig);
    }

    // ── Add more form-specific rules here as needed ────────────────────────────
    // Phone number format — respect the HTML required attribute; phone numbers
    // are NOT pure integers (+44, spaces, hyphens) so we skip the number rule.
    const phoneEl = form.querySelector('[name="phone"]');
    if (phoneEl && form.id !== 'job-application-form') {
        const phoneRules = [];
        if (phoneEl.required) {
            phoneRules.push({ rule: 'required', errorMessage: 'Phone number is required.' });
        }
        phoneRules.push({
            rule: 'maxLength',
            value: 20,
            errorMessage: 'The phone field must not be greater than 20 characters.',
        });
        validator.addField('[name="phone"]', phoneRules);
    }

    // Account Number format
    if (form.querySelector('[name="account_number"]')) {
        validator.addField('[name="account_number"]', [
             {
                rule: 'required',
                errorMessage: 'Account number is required.',
             },
             {
                rule: 'number',
                errorMessage: 'Account number must be a number.',
             },
            {
                rule: 'maxLength',
                value: 30,
                errorMessage: 'Account number must be no more than 30 characters.',
            }
        ]);
    }

    // Bank Number format
    if (form.querySelector('[name="bank_number"]')) {
        validator.addField('[name="bank_number"]', [
             {
                rule: 'required',
                errorMessage: 'Bank number is required.',
             },
             {
                rule: 'number',
                errorMessage: 'Bank number must be a number.',
             },
            {
                rule: 'maxLength',
                value: 30,
                errorMessage: 'Bank number must be no more than 30 characters.',
            }
        ]);
    }

    // IBAN format
    if (form.querySelector('[name="iban"]')) {
        validator.addField('[name="iban"]', [
             {
                rule: 'required',
                errorMessage: 'IBAN is required.',
             },
            {
                rule: 'maxLength',
                value: 50,
                errorMessage: 'IBAN must be no more than 50 characters.',
            }
        ]);
    }

    // ── Listing Form Dropdowns & Inputs ───────────────────────────────────────
    if (form.id === 'add-new-glamping-form') {
        const floatPriceRegex = /^\d{1,8}(\.\d{1,2})?$/;
        const integerRegex = /^[1-9]\d*$/;

        if (form.querySelector('[name="title"]')) {
            validator.addField('[name="title"]', [
                { rule: 'required', errorMessage: 'Stay Title is required.' },
                { rule: 'minLength', value: 3, errorMessage: 'Stay Title must be at least 3 characters.' },
                { rule: 'maxLength', value: 255, errorMessage: 'Stay Title must be no more than 255 characters.' }
            ]);
        }
        if (form.querySelector('[name="region_id"]')) {
            const _regionF = form.querySelector('[name="region_id"]');
            validator.addField('[name="region_id"]', [
                { rule: 'required', errorMessage: 'Please select a stay location.' }
            ], _regionF.dataset.errorsContainer ? { errorsContainer: _regionF.dataset.errorsContainer } : {});
        }
        if (form.querySelector('[name="region_district_id"]')) {
            const _districtF = form.querySelector('[name="region_district_id"]');
            validator.addField('[name="region_district_id"]', [
                { rule: 'required', errorMessage: 'Please select a locality.' }
            ], _districtF.dataset.errorsContainer ? { errorsContainer: _districtF.dataset.errorsContainer } : {});
        }
        if (form.querySelector('[name="stay_type_id"]')) {
            const _stayTypeF = form.querySelector('[name="stay_type_id"]');
            validator.addField('[name="stay_type_id"]', [
                { rule: 'required', errorMessage: 'Please select an accommodation type.' }
            ], _stayTypeF.dataset.errorsContainer ? { errorsContainer: _stayTypeF.dataset.errorsContainer } : {});
        }
        if (form.querySelector('[name="address"]')) {
            validator.addField('[name="address"]', [
                { rule: 'required', errorMessage: 'Address is required.' },
                { rule: 'maxLength', value: 255, errorMessage: 'Address must be no more than 255 characters.' }
            ]);
        }
        if (form.querySelector('[name="latitude"]')) {
            const _latF = form.querySelector('[name="latitude"]');
            validator.addField('[name="latitude"]', [
                {
                    validator: (val) => val !== '' && val !== null && val !== undefined,
                    errorMessage: 'Please select a location from the address suggestions.',
                }
            ], _latF.dataset.errorsContainer ? { errorsContainer: _latF.dataset.errorsContainer } : {});
        }
        if (form.querySelector('[name="zip_code"]')) {
            validator.addField('[name="zip_code"]', [
                { rule: 'required', errorMessage: 'Zipcode is required.' },
                { rule: 'maxLength', value: 20, errorMessage: 'Zipcode must be no more than 20 characters.' },
                //  {
                //     validator: (val) => integerRegex.test(val),
                //     errorMessage: 'Zipcode must be a valid positive integer.'
                // }
            ]);
        }
        if (form.querySelector('[name="vat_number"]')) {
            validator.addField('[name="vat_number"]', [
                { rule: 'required', errorMessage: 'VAT/Tax ID is required.' },
                { rule: 'maxLength', value: 50, errorMessage: 'VAT/Tax ID must be no more than 50 characters.' }
            ]);
        }
        if (form.querySelector('[name="price_per_month"]')) {
            validator.addField('[name="price_per_month"]', [
                { rule: 'required', errorMessage: 'Price Per Month is required.' },
                {
                    validator: (val) => floatPriceRegex.test(val),
                    errorMessage: 'Price must be a valid positive number (e.g., 4050 or 4050.50).'
                }
            ]);
        }
        if (form.querySelector('[name="price_per_night"]')) {
            validator.addField('[name="price_per_night"]', [
                { rule: 'required', errorMessage: 'Price Per Night is required.' },
                {
                    validator: (val) => floatPriceRegex.test(val),
                    errorMessage: 'Price must be a valid positive number (e.g., 4500 or 4500.50).'
                }
            ]);
        }
        if (form.querySelector('[name="max_guests"]')) {
            validator.addField('[name="max_guests"]', [
                { rule: 'required', errorMessage: 'Max Guests is required.' },
                {
                    validator: (val) => integerRegex.test(val),
                    errorMessage: 'Max Guests must be a valid positive integer.'
                },
                { rule: 'maxLength', value: 5, errorMessage: 'Max Guests must be no more than 5 digits.' }
            ]);
        }
        if (form.querySelector('[name="short_description"]')) {
            validator.addField('[name="short_description"]', [
                { rule: 'required', errorMessage: 'Short description is required.' },
                { rule: 'minLength', value: 10, errorMessage: 'Short description must be at least 10 characters.' }
            ]);
        }
        if (form.querySelector('[name="seasonal_prices"]')) {
            validator.addField('[name="seasonal_prices"]', [
                {
                    validator: (val) => {
                        try {
                            const rows = JSON.parse(val || '[]');
                            const nonDraft = rows.filter(r => !r.isDraft);
                            for (let row of nonDraft) {
                                if (!row.range || !row.price) return false;
                                if (!floatPriceRegex.test(row.price)) return false;
                            }
                            return true;
                        } catch(e) {
                            return false;
                        }
                    },
                    errorMessage: 'Please set a range and a valid positive price (e.g., 450 or 450.50) for each seasonal pricing.'
                }
            ]);
        }
        if (form.querySelector('[name="cover_image"]')) {
            validator.addField('[name="cover_image"]', [
                {
                    validator: (value) => {
                        const input = form.querySelector('[name="cover_image"]');
                        const files = input.files;
                        // Check if file is selected (for required validation)
                        if (!files || !files.length) {
                            return !input.hasAttribute('required');
                        }
                        
                        const file = files[0];
                        const ext = file.name.split('.').pop().toLowerCase();
                        const allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
                        
                        // Check extension
                        if (!allowedExts.includes(ext)) return false;
                        
                        // Check size (5 MB = 5242880 bytes)
                        if (file.size > 5242880) return false;
                        
                        return true;
                    },
                    errorMessage: 'Cover image must be PNG, JPG or WebP and no larger than 5 MB.'
                }
            ]);
        }
        if (form.querySelector('[name="gallery_images[]"]')) {
            validator.addField('[name="gallery_images[]"]', [
                {
                    validator: (value) => {
                        const input = form.querySelector('[name="gallery_images[]"]');
                        const files = input.files;
                        if (!files || !files.length) return true;
                        
                        // Check count limit
                        if (files.length > 8) return false;
                        
                        const allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
                        
                        for (let i = 0; i < files.length; i++) {
                            const file = files[i];
                            const ext = file.name.split('.').pop().toLowerCase();
                            
                            if (!allowedExts.includes(ext)) return false;
                            if (file.size > 5242880) return false;
                        }
                        
                        return true;
                    },
                    errorMessage: 'Gallery images must be PNG, JPG or WebP, no more than 8 files, and each under 5 MB.'
                }
            ]);
        }
    }

    // ── Extra Services Form ──────────────────────────────────────────────────
    if (form.id === 'service-form') {
        if (form.querySelector('[name="name"]')) {
            validator.addField('[name="name"]', [
                { rule: 'required', errorMessage: 'Please select a service type.' }
            ]);
        }
        if (form.querySelector('[name="stay_id"]')) {
            validator.addField('[name="stay_id"]', [
                { rule: 'required', errorMessage: 'Please select a stay.' }
            ]);
        }
        if (form.querySelector('[name="default_price"]')) {
            validator.addField('[name="default_price"]', [
                { rule: 'required', errorMessage: 'Price is required.' }
            ]);
        }
    }

    // ── Block Dates Form (Add & Edit) ────────────────────────────────────────
    if (form.id === 'add-block-date-form' || form.id === 'edit-block-date-form') {
        if (form.querySelector('[name="stay_id"]')) {
            validator.addField('[name="stay_id"]', [
                { rule: 'required', errorMessage: 'Please select a stay.' }
            ]);
        }
        if (form.querySelector('[name="block_type"]')) {
            validator.addField('[name="block_type"]', [
                { rule: 'required', errorMessage: 'Please select a block reason.' }
            ]);
        }
        if (form.querySelector('[name="start_date"]')) {
            validator.addField('[name="start_date"]', [
                { rule: 'required', errorMessage: 'From Date is required.' }
            ]);
        }
        if (form.querySelector('[name="end_date"]')) {
            validator.addField('[name="end_date"]', [
                { rule: 'required', errorMessage: 'To Date is required.' },
                {
                    validator: (val) => {
                        const start = form.querySelector('[name="start_date"]')?.value;
                        if (!start || !val) return true;
                        return new Date(val) >= new Date(start);
                    },
                    errorMessage: 'To Date must be after or equal to From Date.'
                }
            ]);
        }
    }

    // ── Help Form (customer & host backend) ──────────────────────────────────
    if (form.id === 'help-form') {
        if (form.querySelector('[name="subject"]')) {
            validator.addField('[name="subject"]', [
                { rule: 'required',  errorMessage: 'Subject is required.' },
                { rule: 'minLength', value: 2,   errorMessage: 'Subject must be at least 2 characters.' },
                { rule: 'maxLength', value: 255,  errorMessage: 'Subject must be no more than 255 characters.' },
            ]);
        }
        if (form.querySelector('[name="message"]')) {
            validator.addField('[name="message"]', [
                { rule: 'required',  errorMessage: 'Message is required.' },
                { rule: 'minLength', value: 10,   errorMessage: 'Message must be at least 10 characters.' },
                { rule: 'maxLength', value: 5000, errorMessage: 'Message must not exceed 5000 characters.' },
            ]);
        }
    }

    // ── Contact Us Form ──────────────────────────────────────────────────────
    if (form.id === 'contact-form') {
        if (form.querySelector('[name="name"]')) {
            validator.addField('[name="name"]', [
                { rule: 'required',  errorMessage: 'Your name is required.' },
                { rule: 'minLength', value: 2,   errorMessage: 'Name must be at least 2 characters.' },
                { rule: 'maxLength', value: 255,  errorMessage: 'Name must be no more than 255 characters.' },
            ]);
        }
        if (form.querySelector('[name="email"]')) {
            validator.addField('[name="email"]', [
                { rule: 'required', errorMessage: 'Email address is required.' },
                { rule: 'email',    errorMessage: 'Please enter a valid email address.' },
            ]);
        }
        if (form.querySelector('[name="message"]')) {
            validator.addField('[name="message"]', [
                { rule: 'required',  errorMessage: 'Message is required.' },
                { rule: 'minLength', value: 10,   errorMessage: 'Message must be at least 10 characters.' },
                { rule: 'maxLength', value: 5000, errorMessage: 'Message must not exceed 5000 characters.' },
            ]);
        }
        // reCAPTCHA v2 — flag input set by data-callback when user completes captcha
        if (form.querySelector('[name="recaptcha_flag"]')) {
            validator.addField('[name="recaptcha_flag"]', [{
                validator: () => !!document.querySelector('[name="recaptcha_flag"]')?.value,
                errorMessage: 'Please complete the reCAPTCHA verification.',
            }], { errorsContainer: '#recaptcha-error' });
        }
    }

    // ── Job Application Form ─────────────────────────────────────────────────
    if (form.id === 'job-application-form') {
        // Phone is optional on the careers form — only validate maxLength.
        const jobPhoneEl = form.querySelector('[name="phone"]');
        if (jobPhoneEl) {
            validator.addField('[name="phone"]', [
                { rule: 'maxLength', value: 20, errorMessage: 'Phone must be no more than 20 characters.' }
            ]);
        }
        // Position dropdown
        const positionEl = form.querySelector('[name="position"]');
        if (positionEl) {
            validator.addField('[name="position"]', [
                { rule: 'required', errorMessage: 'Please select a position.' }
            ]);
        }
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Helpers
// ─────────────────────────────────────────────────────────────────────────────

function formatLabel(name) {
    return name.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
}

function checkImageDimensions(file, minWidth, minHeight) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                if (img.width >= minWidth && img.height >= minHeight) {
                    resolve(true);
                } else {
                    resolve(false);
                }
            };
            img.onerror = () => resolve(false);
            img.src = e.target.result;
        };
        reader.onerror = () => resolve(false);
        reader.readAsDataURL(file);
    });
}