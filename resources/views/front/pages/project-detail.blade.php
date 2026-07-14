@extends('front.newLayout.protected')

@section('meta')
@php
    // Set SEO values from project data with fallbacks
    $seoTitle = isset($project) && $project && !empty($project->meta_title)
        ? $project->meta_title
        : (!empty($project->title)
            ? $project->title . ' - Projects | ' . config('app.name')
            : config('app.name') . ' - Projects');

    $seoDescription = isset($project) && $project && !empty($project->meta_description)
        ? $project->meta_description
        : (!empty($project->excerpt)
            ? $project->excerpt
            : (!empty($project->title)
                ? 'Explore our project: ' . $project->title
                : 'Explore our latest projects at ' . config('app.name')));

    $seoKeywords = isset($project) && $project && !empty($project->meta_keywords)
        ? (is_array($project->meta_keywords) ? $project->meta_keywords : (json_decode($project->meta_keywords, true) ?? []))
        : ['Projects', 'FCM', config('app.name')];

    // Open Graph settings
    $ogTitle = isset($project) && $project && !empty($project->og_title)
        ? $project->og_title
        : $seoTitle;

    $ogDescription = isset($project) && $project && !empty($project->og_description)
        ? $project->og_description
        : $seoDescription;

    $ogType = isset($project) && $project && !empty($project->og_type)
        ? $project->og_type
        : 'article';

    $ogImage = isset($project) && $project && !empty($project->og_image)
        ? asset('storage/' . $project->og_image)
        : (isset($project) && $project && !empty($project->image)
            ? asset('storage/' . $project->image)
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
<main class="project-detail-main">
    <!-- Hero Section -->
    <section class="position-relative d-flex align-items-end project-detail-hero">
        <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('assets/images/projects/project-1.webp') }}"
             class="position-absolute top-0 start-0 w-100 h-100 project-detail-hero-img"
             alt="{{ $project->title }}">
        <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 project-detail-hero-overlay"></div>
        <div class="container position-relative z-1 mb-5">
            <h1 class="text-white ff-baskervville mb-0 project-detail-title hero-title">{{ $project->title }}</h1>
            @if ($project->category)
                <p class="text-white ff-gill-sans-light mb-0 hero-subtitle opacity-75">{{ $project->category->name }}</p>
            @endif
        </div>
    </section>

    <!-- Main Content Article -->
    <section class="py-5 project-detail-content-section">
        <div class="container py-4 project-detail-content-container">
            <div class="article-content">
                @if (! empty($project->content))
                    <div class="ff-gill-sans-light project-detail-paragraph">
                        {!! $project->content !!}
                    </div>
                @else
                    <p class="ff-gill-sans-light mb-4 project-detail-paragraph text-muted">
                        No content has been added for this project yet.
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Selected Projects Section -->
    <section class="py-5 project-detail-selected-projects-section">
        <div class="container-fluid px-md-4">
            <h2 class="ff-baskervville mb-5 text-center text-md-start project-detail-section-title">Selected Projects</h2>
        </div>
        <div class="container-fluid px-0">
            <div class="row mx-0">
                @forelse ($related as $item)
                    @php $colClass = $loop->first ? 'pe-lg-3 ps-lg-0' : ($loop->last ? 'ps-lg-3 pe-lg-0' : 'px-lg-3'); @endphp
                    <div class="col-md-4 mb-4 {{ $colClass }}">
                        <a href="{{ route('page.project-detail', ['slug' => $item->slug]) }}" class="text-decoration-none text-dark d-block project-thumb">
                            <div class="overflow-hidden mb-3 project-detail-thumb-wrapper">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('assets/images/projects/project-1.webp') }}"
                                     class="w-100 h-100 project-detail-thumb-img" alt="{{ $item->title }}">
                            </div>
                            <h4 class="ff-baskervville project-detail-thumb-title px-3">{{ $item->title }}</h4>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="ff-gill-sans-light text-muted">No related projects found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</main>
@endsection