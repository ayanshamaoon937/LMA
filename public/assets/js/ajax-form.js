/**
 * ajax-handler.js
 * ─────────────────────────────────────────────────────────────────────────────
 * Pure AJAX layer. No validation logic here.
 * Call submitForm() from your validator's onSuccess callback.
 *
 * CDN required in layout:
 *   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 *
 * Usage:
 *   submitForm(form, validator, options)
 *
 * Options:
 *   @param {string}   successTitle       - SweetAlert title on success
 *   @param {string}   successText        - SweetAlert body on success (fallback if no data.message)
 *   @param {string}   successIcon        - 'success' | 'info' | 'warning'
 *   @param {string}   redirectOnSuccess  - URL to redirect after alert is dismissed
 *   @param {boolean}  resetOnSuccess     - Reset the form after success (default: true)
 *   @param {function} onSuccess          - Callback(data, form) after success
 *   @param {function} onError            - Callback(errors, form) after 422
 */

async function submitForm(form, validator, options = {},isDraft = false) {

    const opts = Object.assign({
        successTitle: 'Success!',
        successText: 'Operation completed successfully.',
        successIcon: 'success',
        redirectOnSuccess: form.dataset.redirect || null,
        resetOnSuccess: true,
        onSuccess: null,
        onError: null,
    }, options);

    let submitBtn = form.querySelector('button[type="submit"]');
    
    // Allow forms to specify a different button for the loading state (e.g. Save as Draft)
    if (form.dataset.activeSubmitId) {
        const customBtn = document.getElementById(form.dataset.activeSubmitId);
        if (customBtn) submitBtn = customBtn;
    }

    const originalHTML = submitBtn ? submitBtn.innerHTML : null;

    if(isDraft === false){
        
    // ── Loading state ──────────────────────────────────────────────────────────
    if (submitBtn) {
        submitBtn.disabled = true;
        const onlyLoader = submitBtn.dataset.onlyLoader === 'true' || submitBtn.classList.contains('js-only-loader');
        if (onlyLoader) {
            submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>`;
        } else {
            submitBtn.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    Processing...
                </span>`;
        }
    }
   // <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    //     <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    //     <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    // </svg>

    }
    const csrfToken = await refreshCSRFToken(form.id); // pass form ID here

    try {
        const response = await fetch(form.action, {
            method: form.method || 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken || document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
        });

        const data = await response.json();

        // ── 2xx Success ────────────────────────────────────────────────────────
        if (response.ok) {
            form.dispatchEvent(new CustomEvent('ajax-form:success', {
                bubbles: true,
                detail: { data, form, validator }
            }));

            const confirmOnSuccess = form.dataset.confirmOnSuccess === 'true' || opts.confirmOnSuccess;

            if (!confirmOnSuccess) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: opts.successIcon || 'success',
                    title: data.message || opts.successText
                });

                const redirectUrl = data.redirect || opts.redirectOnSuccess;
                if (redirectUrl) {
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 1000);
                } else if (opts.resetOnSuccess) {
                    form.reset();
                    validator?.refresh();
                }
            } else {
                Swal.fire({
                    icon: opts.successIcon,
                    title: opts.successTitle,
                    text: data.message || opts.successText,
                    confirmButtonColor: '#53635A',
                }).then(() => {
                    const redirectUrl = data.redirect || opts.redirectOnSuccess;
                    if (redirectUrl) {
                        window.location.href = redirectUrl;
                    } else if (opts.resetOnSuccess) {
                        form.reset();
                        validator?.refresh();
                    }
                });
            }

            if (typeof opts.onSuccess === 'function') opts.onSuccess(data, form);
        }

        // ── 422 Laravel Validation ─────────────────────────────────────────────
        else if (response.status === 422) {
            form.dispatchEvent(new CustomEvent('ajax-form:error', {
                bubbles: true,
                detail: { errors: data.errors || data, form, validator }
            }));

            handleServerErrors(validator, data.errors || data);

            if (typeof opts.onError === 'function') opts.onError(data.errors || data, form);
        }

        // ── Other HTTP errors ──────────────────────────────────────────────────
        else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Something went wrong!',
            });
        }

    } catch (err) {
        // ── Network / parse error ──────────────────────────────────────────────
        console.error('AjaxHandler error:', err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong!',
        });
    } finally {
        // ── Always restore button ──────────────────────────────────────────────
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    }
}



async function refreshCSRFToken(formId = null) {
    const response = await $.get('/refresh-csrf');
    const token = response.csrf_token;


    // Update the meta tag
    $('meta[name="csrf-token"]').attr('content', token);

    // Optional: update global ajax header
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': token }
    });

    // Also update the hidden input in the form if available
    if (formId) {
        const form = document.getElementById(formId);
        const tokenInput = form.querySelector('input[name="_token"]');
        if (tokenInput) {
            tokenInput.value = token;
        }
    }

    return token;
}


/**
 * Push Laravel 422 errors into just-validate so they render inline under fields.
 *
 * @param {JustValidate} validator
 * @param {object}       errors    - { fieldName: ['message', ...], ... }
 */
function handleServerErrors(validator, errors) {
    if (!validator || !errors) return;

    const errorMap = {};
    Object.keys(errors).forEach(field => {
        const raw = errors[field];
        const message = Array.isArray(raw) ? raw[0] : raw;

        // Ensure we never pass `undefined` into JustValidate
        const safeMessage = (typeof message === 'string' && message.trim().length > 0) ? message : null;
        if (!safeMessage) {
            // If there's no usable message, skip adding it to the error map
            // but still mark the field as invalid internally to trigger styling.
            // Use a fallback short message to avoid rendering 'undefined'.
            // (JustValidate will render whatever string we pass, so prefer a safe fallback.)
            errorMap[`[name="${field}"]`] = 'Invalid value.';
        } else {
            errorMap[`[name="${field}"]`] = safeMessage;
        }

        // Also populate the validator's internal field errorMessage when possible
        try {
            const selector = `[name="${field}"]`;
            const key = typeof validator.getKeyByFieldSelector === 'function' ? validator.getKeyByFieldSelector(selector) : null;
            if (key && validator.fields && validator.fields[key]) {
                validator.fields[key].errorMessage = safeMessage || 'Invalid value.';
                validator.fields[key].isValid = false;
            }
        } catch (e) {
            // ignore
        }
    });

    validator.showErrors(errorMap);

    // Auto-scroll smoothly to the first error label after rendering
    setTimeout(() => {
        const firstError = document.querySelector('.error-label');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }, 100);
}