  <!-- font awesome cdns -->
  <script src="https://kit.fontawesome.com/d3696a146f.js" crossorigin="anonymous"></script>



   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Baskervville:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-icons.css?v='.time())}}">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css?v='.time())}}">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!-- Custom Styles (SCSS compiled to CSS, includes Bootstrap) -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css?v='.time())}}">
    <!--  Favicon Icons -->
    {{-- <link rel="icon" type="image/png" href="{{ get_setting('favicon') ? asset('storage/' . get_setting('favicon')) : asset('assets/images/favicon/favicon-96x96.png') }}" sizes="96x96" /> --}}
    {{-- <link rel="icon" type="image/svg+xml" href="{{ get_setting('favicon_svg') ? asset('storage/' . get_setting('favicon_svg')) : asset('assets/images/favicon/favicon.svg') }}" /> --}}
    {{-- <link rel="shortcut icon" href="{{ get_setting('favicon_ico') ? asset('storage/' . get_setting('favicon_ico')) : asset('assets/images/favicon/favicon.ico') }}" /> --}}
    {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ get_setting('apple_touch_icon') ? asset('storage/' . get_setting('apple_touch_icon')) : asset('assets/images/favicon/apple-touch-icon.png') }}" /> --}}
    {{-- <meta name="apple-mobile-web-app-title" content="FCM" /> --}}
    {{-- <link rel="manifest" href="{{ get_setting('site_webmanifest') ? asset('storage/' . get_setting('site_webmanifest')) : asset('assets/images/favicon/site.webmanifest') }}" /> --}}

@if(get_setting('google_tag_manager_link'))
    {!! get_setting('google_tag_manager_link') !!}
@endif

@yield('links')
