<script src="{{ asset('assets/js/jquery-3.7.1.js?v='.time()) }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/just-validate.js?v='.time()) }}"></script>
<script src="{{ asset('assets/js/ajax-form.js?v='.time()) }}"></script>

<script src="{{ asset('assets/js/form-validator.js?v='.time()) }}"></script>
<script src="{{ asset('assets/js/favorite-toggle.js?v='.time()) }}"></script>



    <!-- GSAP -->
    <script src="{{asset('assets/js/gsap.min.js?v='.time())}}"></script>

    <!-- Bootstrap and Popper JS -->
    <script src="{{asset('assets/js/popper.min.js?v='.time())}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js?v='.time())}}"></script>

    <!-- Swiper JS -->
    <script src="{{ asset('assets/js/swiper-bundle.min.js?v='.time()) }}"></script>
   
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Custom Script -->
    <script src="{{ asset('assets/js/script.js?v='.time()) }}"></script>


    
<!-- Search Modal -->
<!-- <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-custom-color-2 border-0 rounded-0" style="box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close text-custom-color-1 opacity-100" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 pb-5 px-4 px-md-5">
                <form action="#" method="GET" class="d-flex w-100 mt-2 align-items-center border-bottom pb-2" style="border-color: var(--custom-color-1) !important;">
                    <input type="text" class="form-control form-control-lg rounded-0 border-0 bg-transparent text-custom-color-1 shadow-none fs-4 ff-gill-sans-light px-0 search-input-focus" placeholder="What are you looking for?" autofocus>
                    <button type="submit" class="btn btn-link text-custom-color-1 fs-4 text-decoration-none px-0 ms-3"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div> -->

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-custom-color-2 border-0 rounded-0" style="box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close text-custom-color-1 opacity-100" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 pb-5 px-4 px-md-5">
             <form id="searchForm" action="{{ route('page.news') }}" method="GET" class="w-100 mt-2">
                <div class="d-flex align-items-center border-bottom pb-2" style="border-color: var(--custom-color-1) !important;">
                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        class="form-control form-control-lg rounded-0 border-0 bg-transparent text-custom-color-1 shadow-none fs-4 ff-gill-sans-light px-0 search-input-focus"
                        placeholder="What are you looking for?"
                        autofocus>
                    <button type="submit" class="btn btn-link text-custom-color-1 fs-4 text-decoration-none px-0 ms-3"><i class="bi bi-search"></i></button>
                </div>
                <div id="searchErrorContainer"></div>
            </form>
            </div>
        </div>
    </div>
</div>



<!-- Mobile Offcanvas Sidebar -->
<div class="offcanvas offcanvas-end bg-custom-color-2" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel" style="z-index: 99999;">
    <div class="offcanvas-header pb-4">
        <img src="assets/images/logo-white.webp" alt="FCM Logo" style="height: 40px; object-fit: contain;">
        <button type="button" class="btn-close btn-close-white opacity-100" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-4 pt-0">
        <nav class="d-flex flex-column gap-4 ff-gill-sans fw-bold text-uppercase fs-5 pt-4 border-top border-white">
            <a href="{{ route('page.about-us') }}" class="text-white text-decoration-none  fw-bold ff-gill-sans {{ request()->routeIs('page.about-us') ? 'active' : '' }}">About</a>
            <a href="{{ route('page.services') }}" class="text-white text-decoration-none  fw-bold ff-gill-sans {{ request()->routeIs('page.services*') ? 'active' : '' }}">Services</a>
            <a href="{{ route('page.projects') }}" class="text-white text-decoration-none  fw-bold ff-gill-sans {{ request()->routeIs('page.projects*') ? 'active' : '' }}">Projects</a>
            <a href="{{ route('page.careers') }}" class="text-white text-decoration-none  fw-bold ff-gill-sans {{ request()->routeIs('page.careers*') ? 'active' : '' }}">Careers</a>
            <a href="{{ route('page.news') }}" class="text-white text-decoration-none  fw-bold ff-gill-sans {{ request()->routeIs('page.news*') ? 'active' : '' }}">News</a>
            <a href="{{ route('page.contact') }}" class="text-white text-decoration-none  fw-bold ff-gill-sans {{ request()->routeIs('page.contact') ? 'active' : '' }}">Contact Us</a>
            
            <div class=" pt-4 border-top border-white">
                <a target="_blank" href="https://www.linkedin.com/company/fox-curtis-murray-limited/" class="text-white fs-4"><i class="bi bi-linkedin"></i></a>
            </div>
        </nav>
    </div>
</div>

<style>
/* Remove focus outline from search input */
.search-input-focus:focus {
    box-shadow: none !important;
    outline: none !important;
}
/* Ensure input placeholder color is subtle */
.search-input-focus::placeholder {
    color: var(--custom-color-1);
    opacity: 0.8;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('searchForm');

    if (!form || typeof JustValidate === 'undefined') {
        return;
    }

    const validator = new JustValidate('#searchForm', {
        errorFieldCssClass: 'is-invalid',
        errorLabelCssClass: 'text-danger mt-2 d-block',
        focusInvalidField: true,
    });

    validator
        .addField('#searchInput', [
            {
                validator: (value) => value.trim().length > 0,
                errorMessage: 'Please enter a search term',
            },
            {
                rule: 'minLength',
                value: 2,
                errorMessage: 'Search term must be at least 2 characters',
            },
            {
                rule: 'maxLength',
                value: 100,
                errorMessage: 'Search term cannot exceed 100 characters',
            },
        ], {
            errorsContainer: '#searchErrorContainer',
        })
        .onSuccess((event) => {
            event.target.querySelector('#searchInput').value =
                event.target.querySelector('#searchInput').value.trim();

            event.target.submit();
        });
});
</script>


@yield('c_scripts')
@stack('scripts')

<script>
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
        });
    @endif
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
        });
    @endif
    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: "{{ session('warning') }}",
        });
    @endif
    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: "{{ session('info') }}",
        });
    @endif
    
    @if(session('payment_error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('payment_error') }}",
        });
    @endif
    @if(session('payment'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('payment') }}",
        });
    @endif
    
    @if(session('payment_success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('payment_success') }}",
        });
    @endif
    
    @if(session('payment_warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: "{{ session('payment_warning') }}",
        });
    @endif
    
    @if(session('payment_info'))
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: "{{ session('payment_info') }}",
        });
    @endif    
            
</script>
