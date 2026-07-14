@php
    $headerClass = Route::is('page.index') ? '' : 'header-solid';
@endphp


<header class="header {{ $headerClass }}">
    <div class="container py-2 d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <div class="logo">
            <a href="{{ route('page.index') }}" class="logo-link">
                @php $whiteLogo = get_setting('white_logo'); $darkLogo = get_setting('dark_logo'); @endphp
                <img class="logo-white" src="{{ $whiteLogo ? asset('storage/' . $whiteLogo) : asset('assets/images/logo-white.webp') }}" alt="FCM Logo">
                <img class="logo-dark" src="{{ $darkLogo ? asset('storage/' . $darkLogo) : asset('assets/images/logo.webp') }}" alt="FCM Logo">
            </a>
        </div>
        
        <!-- Desktop Navigation -->
        <nav class="nav-links d-none d-lg-flex gap-md-4 gap-lg-4 gap-xl-5 align-items-center text-white text-uppercase">
            <a href="{{ route('page.about-us') }}" class="text-white text-decoration-none fw-bold ff-gill-sans link {{ request()->routeIs('page.about-us') ? 'active' : '' }}">About</a>
            <a href="{{ route('page.services') }}" class="text-white text-decoration-none fw-bold ff-gill-sans link {{ request()->routeIs('page.services*') ? 'active' : '' }}">Services</a>
            <a href="{{ route('page.projects') }}" class="text-white text-decoration-none fw-bold ff-gill-sans link {{ request()->routeIs('page.projects*') ? 'active' : '' }}">Projects</a>
            <a href="{{ route('page.careers') }}" class="text-white text-decoration-none fw-bold ff-gill-sans link {{ request()->routeIs('page.careers*') ? 'active' : '' }}">Careers</a>
            <a href="{{ route('page.news') }}" class="text-white text-decoration-none fw-bold ff-gill-sans link {{ request()->routeIs('page.news*') ? 'active' : '' }}">News</a>
            <a href="{{ route('page.contact') }}" class="text-white text-decoration-none fw-bold ff-gill-sans link {{ request()->routeIs('page.contact') ? 'active' : '' }}">Contact Us</a>
            <div class="d-flex align-items-center gap-3 lh-0">
                <a target="_blank" href="https://www.linkedin.com/company/fox-curtis-murray-limited/" class="text-white fs-5 lh-0"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.429 6.969H11.143V8.819C11.678 7.755 13.05 6.799 15.111 6.799C19.062 6.799 20 8.917 20 12.803V20H16V13.688C16 11.475 15.465 10.227 14.103 10.227C12.214 10.227 11.429 11.572 11.429 13.687V20H7.429V6.969ZM0.57 19.83H4.57V13.3145V6.799H0.57V19.83ZM5.143 2.55C5.14315 2.88528 5.07666 3.21724 4.94739 3.52659C4.81812 3.83594 4.62865 4.11651 4.39 4.352C4.15064 4.59012 3.86671 4.77874 3.55442 4.90708C3.24214 5.03543 2.90763 5.10098 2.57 5.1C1.8896 5.09847 1.23691 4.83029 0.752 4.353C0.5143 4.11665 0.325532 3.83575 0.196496 3.52637C0.0674603 3.21699 0.000688218 2.88521 0 2.55C0 1.873 0.27 1.225 0.753 0.747001C1.2367 0.267882 1.89018 -0.000624124 2.571 1.0894e-06C3.253 1.0894e-06 3.907 0.269001 4.39 0.747001C4.873 1.225 5.143 1.873 5.143 2.55Z" fill="#fff"/></svg></a>
                <a href="#" class="text-white fs-5 mt-2" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="bi bi-search"></i></a>
            </div>
        </nav>

        <!-- Mobile Controls (Search + Hamburger) -->
        <div class="d-flex d-lg-none align-items-center gap-4">
            <a href="#" class="text-white fs-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="bi bi-search"></i></a>
            <button class="navbar-toggler text-white border-0 bg-transparent fs-1 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>
</header>
