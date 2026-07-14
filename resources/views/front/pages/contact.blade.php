@extends('front.newLayout.protected')

@section('content')

<main style="background-color: #F8F7F3;">
<!-- Map Section -->
<section class="map-section border-top">
    <div id="londonMap"></div>
</section>

@push('scripts')
@if(isset($cms['map']))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapContainer = document.getElementById('londonMap');
        if (mapContainer && typeof window.L !== 'undefined') {
            var mapConfig = @json($cms['map']);
            var map = L.map('londonMap', {
                scrollWheelZoom: false
            }).setView([mapConfig.center_lat, mapConfig.center_lng], mapConfig.zoom);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);

            var customIcon = L.divIcon({
                className: 'custom-pin',
                iconAnchor: [15, 30],
                html: '<div class="pin bg-custom-color-2"></div>'
            });

            (mapConfig.locations || []).forEach(function(loc) {
                L.marker([loc.lat, loc.lng], {icon: customIcon}).addTo(map);
            });

            setTimeout(function() {
                map.invalidateSize();
            }, 200);
        }
    });
</script>
@endif
@endpush

<!-- Get In Touch Section -->
<section class="get-in-touch-section py-5 bg-custom-color-4">
    <div class="container py-5">
        <div class="row mx-0">
            <!-- Left Column: Contact Info -->
            <div class="col-md-6 pe-md-5 mb-5 mb-md-0">
                <h6 class="sub-title text-custom-color-1 text-uppercase ff-gill-sans-medium mb-3">{{ $cms['contact']['subtitle'] ?? 'Contact' }}</h6>
                <h2 class="section-title text-custom-color-2 text-uppercase ff-baskervville mb-4 mx-0">{{ $cms['contact']['title'] ?? 'Get In Touch' }}</h2>
                
                    <div class="contact-intro text-custom-color-1 ff-gill-sans mb-5">
                        {!! $cms['contact']['content'] ?? 'We are waiting for you at out London office or in other way, you can contact us via the contact form below to discuss your project, your idea' !!}
                    </div>
                
                <div class="row mb-5 mx-0">
                    <div class="col-6 ps-lg-0 mb-3">
                        <h6 class="contact-label text-custom-color-2 text-uppercase fw-semibold ff-gill-sans-medium mb-2">Email:</h6>
                        <a href="mailto:{{ $cms['contact']['email'] ?? 'info@fcmltd.co.uk' }}" class="contact-link text-custom-color-1 text-decoration-none fw-semibold ff-gill-sans-medium">{{ $cms['contact']['email'] ?? 'info@fcmltd.co.uk' }}</a>
                    </div>
                    <div class="col-6 pe-lg-0">
                        <h6 class="contact-label text-custom-color-2 text-uppercase fw-semibold ff-gill-sans-medium mb-2">Phone:</h6>
                        <a href="tel:{{ preg_replace('/\s+/', '', $cms['contact']['phone'] ?? '+020 323 5758') }}" class="contact-link text-custom-color-1 text-decoration-none fw-semibold ff-gill-sans-medium">{{ $cms['contact']['phone'] ?? '+020 323 5758' }}</a>
                    </div>
                </div>
                
                <div class="social-icons d-flex gap-4">
                    <a href="{{ get_setting('instagram') ?? '#' }}" class="social-link text-custom-color-2 text-decoration-none"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.001 7C9.20535 7 8.44229 7.31607 7.87968 7.87868C7.31707 8.44129 7.001 9.20435 7.001 10C7.001 10.7956 7.31707 11.5587 7.87968 12.1213C8.44229 12.6839 9.20535 13 10.001 13C10.7966 13 11.5597 12.6839 12.1223 12.1213C12.6849 11.5587 13.001 10.7956 13.001 10C13.001 9.20435 12.6849 8.44129 12.1223 7.87868C11.5597 7.31607 10.7966 7 10.001 7ZM10.001 5C11.3271 5 12.5989 5.52678 13.5365 6.46447C14.4742 7.40215 15.001 8.67392 15.001 10C15.001 11.3261 14.4742 12.5979 13.5365 13.5355C12.5989 14.4732 11.3271 15 10.001 15C8.67492 15 7.40315 14.4732 6.46547 13.5355C5.52778 12.5979 5.001 11.3261 5.001 10C5.001 8.67392 5.52778 7.40215 6.46547 6.46447C7.40315 5.52678 8.67492 5 10.001 5ZM16.501 4.75C16.501 5.08152 16.3693 5.39946 16.1349 5.63388C15.9005 5.8683 15.5825 6 15.251 6C14.9195 6 14.6015 5.8683 14.3671 5.63388C14.1327 5.39946 14.001 5.08152 14.001 4.75C14.001 4.41848 14.1327 4.10054 14.3671 3.86612C14.6015 3.6317 14.9195 3.5 15.251 3.5C15.5825 3.5 15.9005 3.6317 16.1349 3.86612C16.3693 4.10054 16.501 4.41848 16.501 4.75ZM10.001 2C7.527 2 7.123 2.007 5.972 2.058C5.188 2.095 4.662 2.2 4.174 2.39C3.76583 2.54037 3.39672 2.78063 3.094 3.093C2.78127 3.39562 2.54066 3.76474 2.39 4.173C2.2 4.663 2.095 5.188 2.059 5.971C2.007 7.075 2 7.461 2 10C2 12.475 2.007 12.878 2.058 14.029C2.095 14.812 2.2 15.339 2.389 15.826C2.559 16.261 2.759 16.574 3.091 16.906C3.428 17.242 3.741 17.443 4.171 17.609C4.665 17.8 5.191 17.906 5.971 17.942C7.075 17.994 7.461 18 10 18C12.475 18 12.878 17.993 14.029 17.942C14.811 17.905 15.337 17.8 15.826 17.611C16.2342 17.4606 16.6033 17.2204 16.906 16.908C17.243 16.572 17.444 16.259 17.61 15.828C17.8 15.336 17.906 14.81 17.942 14.028C17.994 12.925 18 12.538 18 10C18 7.526 17.993 7.122 17.942 5.971C17.905 5.189 17.799 4.661 17.61 4.173C17.4596 3.76483 17.2194 3.39572 16.907 3.093C16.6044 2.78027 16.2353 2.53966 15.827 2.389C15.337 2.199 14.811 2.094 14.029 2.058C12.926 2.006 12.54 2 10 2M10 0C12.717 0 13.056 0.00999994 14.123 0.0599999C15.187 0.11 15.913 0.277 16.55 0.525C17.21 0.779 17.766 1.123 18.322 1.678C18.8307 2.17773 19.2242 2.78247 19.475 3.45C19.722 4.087 19.89 4.813 19.94 5.878C19.987 6.944 20 7.283 20 10C20 12.717 19.99 13.056 19.94 14.122C19.89 15.188 19.722 15.912 19.475 16.55C19.2242 17.2175 18.8307 17.8223 18.322 18.322C17.8223 18.8307 17.2175 19.2242 16.55 19.475C15.913 19.722 15.187 19.89 14.123 19.94C13.056 19.987 12.717 20 10 20C7.283 20 6.944 19.99 5.877 19.94C4.813 19.89 4.088 19.722 3.45 19.475C2.78247 19.2242 2.17773 18.8307 1.678 18.322C1.16931 17.8223 0.775816 17.2175 0.525 16.55C0.277 15.913 0.11 15.187 0.0599999 14.122C0.0119999 13.056 0 12.717 0 10C0 7.283 0.00999994 6.944 0.0599999 5.878C0.11 4.812 0.277 4.088 0.525 3.45C0.775816 2.78247 1.16931 2.17773 1.678 1.678C2.17773 1.16931 2.78247 0.775816 3.45 0.525C4.087 0.277 4.812 0.11 5.877 0.0599999C6.945 0.0129999 7.284 0 10.001 0" fill="rgb(var(--bs-custom-color-2-rgb))"/></svg></a>
                    <a href="{{ get_setting('twitter') ?? '#' }}" class="social-link text-custom-color-2 text-decoration-none"><svg width="20" height="20" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.025 0H13.172L8.482 5.374L14 12.688H9.68L6.294 8.253L2.424 12.688H0.275L5.291 6.938L0 0.000999987H4.43L7.486 4.054L11.025 0ZM10.27 11.4H11.46L3.78 1.221H2.504L10.27 11.4Z" fill="rgb(var(--bs-custom-color-2-rgb))"/></svg></a>
                    <a href="{{ get_setting('facebook') ?? '#' }}" class="social-link text-custom-color-2 text-decoration-none"><svg width="20" height="20" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 11.5H9.5L10.5 7.5H7V5.5C7 4.47 7 3.5 9 3.5H10.5V0.14C10.174 0.0970001 8.943 0 7.643 0C4.928 0 3 1.657 3 4.7V7.5H0V11.5H3V20H7V11.5Z" fill="rgb(var(--bs-custom-color-2-rgb))"/></svg></a>
                    <a href="{{ get_setting('linkedin') ?? '#' }}" class="social-link text-custom-color-2 text-decoration-none"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.429 6.969H11.143V8.819C11.678 7.755 13.05 6.799 15.111 6.799C19.062 6.799 20 8.917 20 12.803V20H16V13.688C16 11.475 15.465 10.227 14.103 10.227C12.214 10.227 11.429 11.572 11.429 13.687V20H7.429V6.969ZM0.57 19.83H4.57V13.3145V6.799H0.57V19.83ZM5.143 2.55C5.14315 2.88528 5.07666 3.21724 4.94739 3.52659C4.81812 3.83594 4.62865 4.11651 4.39 4.352C4.15064 4.59012 3.86671 4.77874 3.55442 4.90708C3.24214 5.03543 2.90763 5.10098 2.57 5.1C1.8896 5.09847 1.23691 4.83029 0.752 4.353C0.5143 4.11665 0.325532 3.83575 0.196496 3.52637C0.0674603 3.21699 0.000688218 2.88521 0 2.55C0 1.873 0.27 1.225 0.753 0.747001C1.2367 0.267882 1.89018 -0.000624124 2.571 1.0894e-06C3.253 1.0894e-06 3.907 0.269001 4.39 0.747001C4.873 1.225 5.143 1.873 5.143 2.55Z" fill="rgb(var(--bs-custom-color-2-rgb))"/></svg></a>
                </div>
            </div>
            
            <!-- Right Column: Form -->
            <div class="col-md-6 ps-md-5 d-flex flex-column justify-content-center">
                <form id="contact-form"
                action="{{ route('contact.store') }}"
                method="POST"
                class="grid gap-6 ajax-form"
                data-success-title="{{ __('lang.contact.form.success_title') }}"
                novalidate>
                @csrf
                    <div class="mb-4">
                        <label for="contactName" class="form-label-custom text-custom-color-1 form-label ff-gill-sans">Name</label>
                        <input type="text" name="name" class="form-input-custom form-control shadow-none rounded-0 px-0" id="contactName" required>
                    </div>
                    <div class="mb-4">
                        <label for="contactEmail" class="form-label-custom text-custom-color-1 form-label ff-gill-sans">Email</label>
                        <input type="email" name="email" class="form-input-custom form-control shadow-none rounded-0 px-0" id="contactEmail" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="contactMessage" class="form-label-custom text-custom-color-1 form-label ff-gill-sans">Message</label>
                        <textarea class="form-textarea-custom form-control shadow-none rounded-0" id="contactMessage" name="message" rows="5"></textarea>
                    </div>

                    @if(isset($recaptcha) && $recaptcha && $recaptcha->enable)
                        @if($recaptcha->version === 'v3')
                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-token">
                        @else
                            <div class="mb-4">
                                <div class="g-recaptcha" data-sitekey="{{ $recaptcha->site_key }}" data-callback="onRecaptchaComplete" data-expired-callback="onRecaptchaExpired"></div>
                                <input type="hidden" name="recaptcha_flag" id="recaptcha-flag">
                                <div id="recaptcha-error" class="mt-1"></div>
                            </div>
                        @endif
                    @endif

                    <div class="btn-wrapper">
                        <button type="submit" class="btn btn-primary text-white text-decoration-none ff-gill-sans text-uppercase"><span>Send</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

</main>


@endsection

@once
@push('scripts')
<script src="{{ asset('assets/js/ajax-form.js?v=1.1') }}"></script>
<script src="{{ asset('assets/js/form-validator.js?v=1.1') }}"></script>
@if(isset($recaptcha) && $recaptcha && $recaptcha->enable)
  @if($recaptcha->version === 'v3')
    <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptcha->site_key }}" async defer></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var contactForm = document.getElementById('contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', function () {
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.execute('{{ $recaptcha->site_key }}', { action: 'contact' })
                        .then(function (token) {
                            document.getElementById('g-recaptcha-token').value = token;
                        });
                }
            }, true);
        }
    });
    </script>
  @else
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
    function onRecaptchaComplete() {
        document.getElementById('recaptcha-flag').value = '1';
        // Clear any existing reCAPTCHA error when user completes it
        var errDiv = document.getElementById('recaptcha-error');
        if (errDiv) errDiv.innerHTML = '';
    }
    function onRecaptchaExpired() {
        document.getElementById('recaptcha-flag').value = '';
    }
    document.addEventListener('DOMContentLoaded', function () {
        var contactForm = document.getElementById('contact-form');
        if (!contactForm) return;

        // Show server-side g-recaptcha-response error in the visible error container
        contactForm.addEventListener('ajax-form:error', function (e) {
            var errors = (e.detail && e.detail.errors) ? e.detail.errors : {};
            var errDiv = document.getElementById('recaptcha-error');
            if (errDiv && errors['g-recaptcha-response']) {
                var raw = errors['g-recaptcha-response'];
                var msg = Array.isArray(raw) ? raw[0] : raw;
                errDiv.innerHTML = '<span class="text-[#f11a21] text-xs mt-1 block">' + msg + '</span>';
            }
            // Reset the widget and flag so the user can retry
            if (typeof grecaptcha !== 'undefined') grecaptcha.reset();
            var flag = document.getElementById('recaptcha-flag');
            if (flag) flag.value = '';
        });

        // Reset widget after successful submission too
        contactForm.addEventListener('ajax-form:success', function () {
            if (typeof grecaptcha !== 'undefined') grecaptcha.reset();
            var flag = document.getElementById('recaptcha-flag');
            if (flag) flag.value = '';
            var errDiv = document.getElementById('recaptcha-error');
            if (errDiv) errDiv.innerHTML = '';
        });
    });
    </script>
  @endif
@endif
@endpush
@endonce

