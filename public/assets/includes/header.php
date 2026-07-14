<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$headerClass = ($currentPage == 'index.php') ? '' : 'header-solid';
?>
<header class="header <?php echo $headerClass; ?>">
    <div class="container py-2 d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <div class="logo">
            <a href="index.php">
                <img src="assets/images/logo-white.webp" alt="FCM Logo" style="height: 65px; object-fit: contain;">
            </a>
        </div>
        
        <!-- Desktop Navigation -->
        <nav class="nav-links d-none d-lg-flex gap-4 align-items-center ff-gill-sans fw-bold text-white text-uppercase">
            <a href="about-us.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">About</a>
            <a href="services.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">Services</a>
            <a href="projects.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">Projects</a>
            <a href="careers.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">Careers</a>
            <a href="news.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">News</a>
            <a href="contact.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">Contact Us</a>
            <a target="_blank" href="https://www.linkedin.com/company/fox-curtis-murray-limited/" class="text-white fs-5 ms-2"><i class="bi bi-linkedin"></i></a>
            <a href="#" class="text-white fs-5 mt-2" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="bi bi-search"></i></a>
        </nav>

        <!-- Mobile Controls (Search + Hamburger) -->
        <div class="d-flex d-lg-none align-items-center gap-4">
            <a href="#" class="text-white fs-4 mt-2" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="bi bi-search"></i></a>
            <button class="navbar-toggler text-white border-0 bg-transparent fs-1 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>
</header>
