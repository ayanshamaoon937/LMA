<!-- jQuery -->
    <script src="assets/js/jquery-3.7.1.js"></script>

    <!-- GSAP -->
    <script src="assets/js/gsap.min.js"></script>

    <!-- Bootstrap and Popper JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Swiper JS -->
    <script src="assets/js/swiper-bundle.min.js"></script>

    <!-- Custom Script -->
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Custom Script -->
    <script src="assets/js/script.js"></script>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true" style="z-index: 99999;">
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
</div>

<!-- Mobile Offcanvas Sidebar -->
<div class="offcanvas offcanvas-end bg-custom-color-2" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel" style="z-index: 99999;">
    <div class="offcanvas-header border-bottom pb-3" style="border-color: rgba(255,255,255,0.1) !important;">
        <img src="assets/images/logo-white.webp" alt="FCM Logo" style="height: 40px; object-fit: contain;">
        <button type="button" class="btn-close btn-close-white opacity-100" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-4 pt-4">
        <nav class="d-flex flex-column gap-4 ff-gill-sans fw-bold text-uppercase fs-5">
            <a href="about-us.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">About</a>
            <a href="services.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">Services</a>
            <a href="projects.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">Projects</a>
            <a href="careers.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">Careers</a>
            <a href="news.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">News</a>
            <a href="contact.php" class="text-white text-decoration-none fw-semibold ff-gill-sans-medium">Contact Us</a>
            
            <div class="mt-4 pt-4 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
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

</body>
</html>
