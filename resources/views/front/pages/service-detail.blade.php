@extends('front.newLayout.protected')

@section('meta')
@php
    // Set SEO values from service data with fallbacks
    $seoTitle = isset($service) && $service && !empty($service->meta_title)
        ? $service->meta_title
        : (!empty($cms['hero']['title'])
            ? $cms['hero']['title'] . ' - Services'
            : config('app.name') . ' - Services');

    $seoDescription = isset($service) && $service && !empty($service->meta_description)
        ? $service->meta_description
        : (!empty($cms['hero']['subtitle'])
            ? $cms['hero']['subtitle']
            : 'Professional Clerks of Works and construction inspection services');

  $seoKeywords = isset($service) && $service && !empty($service->meta_keywords)
    ? (is_array($service->meta_keywords) ? $service->meta_keywords : (json_decode($service->meta_keywords, true) ?? []))
    : ['Clerks of Works', 'Construction Inspection', 'Project Management', 'Quality Control'];

    // Open Graph settings
    $ogTitle = isset($service) && $service && !empty($service->og_title)
        ? $service->og_title
        : $seoTitle;

    $ogDescription = isset($service) && $service && !empty($service->og_description)
        ? $service->og_description
        : $seoDescription;

    $ogType = isset($service) && $service && !empty($service->og_type)
        ? $service->og_type
        : 'website';

    $ogImage = isset($service) && $service && !empty($service->og_image)
        ? asset('storage/' . $service->og_image)
        : (isset($service) && $service && !empty($service->image)
            ? asset('storage/' . $service->image)
            : (!empty($cms['hero']['image'])
                ? asset('storage/' . $cms['hero']['image'])
                : asset('assets/images/og-image.jpg')));

    $twitterCard = 'summary_large_image';
    $twitterTitle = $ogTitle;
    $twitterDescription = $ogDescription;
    $twitterImage = $ogImage;
    $canonicalUrl = url()->current();
@endphp

<!-- Primary Meta Tags -->
<title>{{ $seoTitle }}</title>
<meta name="title" content="{{ $seoTitle }}">
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ implode(', ', $seoKeywords) }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:locale" content="en_US">

<!-- Twitter -->
<meta property="twitter:card" content="{{ $twitterCard }}">
<meta property="twitter:url" content="{{ $canonicalUrl }}">
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
@endsection

@section('content')
<main style="background-color: #F8F7F3;">
    <!-- Hero Section -->
    <section class="position-relative d-flex align-items-end" style="height: 60vh; min-height: 400px;">
        <!-- Use service image if available, otherwise fall back to CMS hero image, then static -->
        <img src="{{
            isset($service) && !empty($service->image)
                ? asset('storage/' . $service->image)
                : (!empty($cms['hero']['image'])
                    ? asset('storage/' . $cms['hero']['image'])
                    : asset('assets/images/clerks-works.webp'))
        }}"
             class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover;" alt="{{
            isset($service) && $service
                ? $service->title
                : (!empty($cms['hero']['title'])
                    ? $cms['hero']['title']
                    : 'Service Details')
        }}">
        <div class="project-overlay position-absolute top-0 start-0 w-100 h-100"
             style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%); pointer-events: none;"></div>
        <div class="container position-relative z-1 mb-5">
            <h1 class="text-white ff-baskervville mb-2 hero-title" style="font-size: 3.5rem;">{{
            isset($service) && $service
                ? $service->title
                : (!empty($cms['hero']['title'])
                    ? $cms['hero']['title']
                    : 'Service Details')
        }}</h1>
            @if(isset($service) && $service && !empty($service->subtitle))
            <p class="text-white ff-gill-sans-light mb-0 hero-subtitle" style="font-size: 1.1rem; max-width: 600px; opacity: 0.9;">
                {{ $service->subtitle }}
            </p>
            @endif
        </div>
    </section>

    <!-- Content Container -->
    <section class="py-5 service-detail-content-section">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <a href="{{ route('page.services') }}" class="text-decoration-none d-inline-block mb-4 ff-gill-sans text-custom-color-2" style="letter-spacing: 1px; font-size: 0.9rem;">
                        &larr; BACK TO SERVICES
                    </a>

                    <div class="service-detail-content">
                        @if(isset($service) && $service && !empty($service->content))
                            @php
                                // Handle both string and array content for flexibility
                                $contentItems = is_array($service->content)
                                    ? $service->content
                                    : (!empty($service->content) ? [$service->content] : []);
                            @endphp
                            @forelse($contentItems as $paragraph)
                                <div class="ff-gill-sans-light mb-4" style="font-size: 1.05rem; line-height: 1.9; color: #444;">{!! $paragraph !!}</div>
                            @empty
                            <p class="ff-gill-sans-light text-muted">Service content not available.</p>
                            @endforelse
                        @else
                            <p class="ff-gill-sans-light text-muted">Service content not available.</p>
                        @endif
                    </div>

                    <div class="mt-5 pt-4 border-top text-center">
                        <h3 class="ff-baskervville mb-3 text-custom-color-1">Interested in this service?</h3>
                        <div class="btn-wrapper d-inline-block mt-2">
                            <a href="{{ route('page.contact') }}" class="btn btn-primary text-white text-decoration-none ff-gill-sans" style="background-color: var(--custom-color-2); padding: 0.8rem 2.5rem; letter-spacing: 2px; font-size: 0.85rem; border-radius: 0;">CONTACT US</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Selected Projects Section -->
    @if(isset($relatedProjects) && $relatedProjects->count() > 0)
    <section class="py-5 project-detail-selected-projects-section">
        <div class="container-fluid px-md-4">
            <h2 class="ff-baskervville mb-5 text-center text-md-start project-detail-section-title">Selected Projects</h2>
        </div>
        <div class="container-fluid px-0">
            <div class="row mx-0">
                @foreach($relatedProjects as $item)
                    @php $colClass = $loop->first ? 'pe-lg-3 ps-lg-0' : ($loop->last ? 'ps-lg-3 pe-lg-0' : 'px-lg-3'); @endphp
                    <div class="col-md-4 mb-4 {{ $colClass }}">
                        <a href="{{ route('page.project-detail', ['slug' => $item->slug]) }}" class="text-decoration-none text-dark d-block project-thumb">
                            <div class="overflow-hidden mb-3 project-detail-thumb-wrapper">
                                <img src="{{ !empty($item->image) ? asset('storage/' . $item->image) : asset('assets/images/projects/project-1.webp') }}"
                                     class="w-100 h-100 project-detail-thumb-img" alt="{{ $item->title }}">
                            </div>
                            <h4 class="ff-baskervville project-detail-thumb-title px-3">{{ $item->title }}</h4>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</main>
@endsection