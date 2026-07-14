@php
    // Get SEO data from CMS if available
    $seoTitle = '';
    $seoDescription = '';
    $seoKeywords = [];
    $ogTitle = '';
    $ogDescription = '';
    $ogType = 'website';
    $ogImage = '';
    $twitterCard = 'summary_large_image';
    $twitterTitle = '';
    $twitterDescription = '';
    $twitterImage = '';

    // Try to get SEO data from $cms if it's available (passed to views)
    if (isset($cms) && is_array($cms)) {
        // Try to get from meta section
        if (isset($cms['meta'])) {
            $meta = $cms['meta'];
            $seoTitle = $meta['meta_title'] ?? '';
            $seoDescription = $meta['meta_description'] ?? '';
            $seoKeywords = $meta['meta_keywords'] ?? [];
        }

        // Try to get from hero section for OG image
        if (isset($cms['hero']) && !empty($cms['hero']['image'])) {
            $ogImage = asset('storage/' . $cms['hero']['image']);
        }
    }

    // Fallback defaults if no CMS data
    if (empty($seoTitle)) {
        $seoTitle = config('app.name') . ' - FOX | CURTIS | MURRAY';
    }
    if (empty($seoDescription)) {
        $seoDescription = 'FOX |FOX | CURTIS | MURRAY | Kurtis Curtis">';
    }
    if (empty($seoKeywords)) {
        $seoKeywords = ['FCM', 'FOX', 'CURTIS', 'MURRAY'];
    }
    if (empty($ogTitle)) {
        $ogTitle = $seoTitle;
    }
    if (empty($ogDescription)) {
        $ogDescription = $seoDescription;
    }
    if (empty($ogImage)) {
        $ogImage = asset('assets/images/og-image.jpg'); // Default OG image
    }
    if (empty($twitterTitle)) {
        $twitterTitle = $seoTitle;
    }
    if (empty($twitterDescription)) {
        $twitterDescription = $seoDescription;
    }
    if (empty($twitterImage)) {
        $twitterImage = $ogImage;
    }
@endphp

<!-- Primary Meta Tags -->
<title>{{ $seoTitle }}</title>
<meta name="title" content="{{ $seoTitle }}">
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ implode(', ', $seoKeywords) }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:locale" content="en_US">

<!-- Twitter -->
<meta property="twitter:card" content="{{ $twitterCard }}">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $twitterTitle }}">
<meta property="twitter:description" content="{{ $twitterDescription }}">
<meta property="twitter:image" content="{{ $twitterImage }}">

<!-- Favicon Icons -->
<link rel="icon" type="image/png" href="{{ get_setting('favicon') ? asset('storage/' . get_setting('favicon')) : asset('assets/images/favicon/favicon-96x96.png') }}" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="{{ get_setting('favicon_svg') ? asset('storage/' . get_setting('favicon_svg')) : asset('assets/images/favicon/favicon.svg') }}" />
<link rel="shortcut icon" href="{{ get_setting('favicon_ico') ? asset('storage/' . get_setting('favicon_ico')) : asset('assets/images/favicon/favicon.ico') }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ get_setting('apple_touch_icon') ? asset('storage/' . get_setting('apple_touch_icon')) : asset('assets/images/favicon/apple-touch-icon.png') }}" />
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}" />
<link rel="manifest" href="{{ get_setting('site_webmanifest') ? asset('storage/' . get_setting('site_webmanifest')) : asset('assets/images/favicon/site.webmanifest') }}" />