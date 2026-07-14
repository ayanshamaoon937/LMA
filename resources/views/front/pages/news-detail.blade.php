@extends('front.newLayout.protected')

@section('meta')
@php
    // Set SEO values from article data with fallbacks
    $seoTitle = isset($article) && $article && !empty($article->meta_title)
        ? $article->meta_title
        : (!empty($article->title)
            ? $article->title . ' - News | ' . config('app.name')
            : config('app.name') . ' - News');

    $seoDescription = isset($article) && $article && !empty($article->meta_description)
        ? $article->meta_description
        : (!empty($article->excerpt)
            ? $article->excerpt
            : (!empty($article->title)
                ? 'Read our article: ' . $article->title
                : 'Read the latest news from ' . config('app.name')));

    $seoKeywords = isset($article) && $article && !empty($article->meta_keywords)
        ? (is_array($article->meta_keywords) ? $article->meta_keywords : (json_decode($article->meta_keywords, true) ?? []))
        : ['News', 'FCM', config('app.name')];

    // Open Graph settings
    $ogTitle = isset($article) && $article && !empty($article->og_title)
        ? $article->og_title
        : $seoTitle;

    $ogDescription = isset($article) && $article && !empty($article->og_description)
        ? $article->og_description
        : $seoDescription;

    $ogType = isset($article) && $article && !empty($article->og_type)
        ? $article->og_type
        : 'article';

    $ogImage = isset($article) && $article && !empty($article->og_image)
        ? asset('storage/' . $article->og_image)
        : (isset($article) && $article && !empty($article->image)
            ? asset('storage/' . $article->image)
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

<main class="news-detail-main">
    <!-- Hero Section -->
    <section class="position-relative d-flex align-items-end news-detail-hero">
        <img src="{{ isset($article) && !empty($article->image) ? asset('storage/' . $article->image) : (!empty($cms['hero']['image']) ? asset('storage/' . $cms['hero']['image']) : asset('assets/images/news/news-5.webp')) }}" class="position-absolute top-0 start-0 w-100 h-100 news-detail-hero-img" alt="{{ $article->title ?? ($cms['hero']['title'] ?? 'News Article') }}">
        <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 news-detail-hero-overlay"></div>
        <div class="container position-relative z-1 mb-5">
            <h1 class="text-white ff-baskervville mb-0 news-detail-title hero-title">{{ $article->title ?? ($cms['hero']['title'] ?? 'Why a Property Assessment') }}</h1>
        </div>
    </section>

    <!-- Main Content Article -->
    <section class="py-5 news-detail-content-section">
        <div class="container py-4 news-detail-content-container">
            <div class="article-content">
                @if(isset($article) && $article)
                    @if(!empty($article->content))
                        <div class="ff-gill-sans-light news-detail-paragraph">
                            {!! $article->content !!}
                        </div>
                    @endif
                @else
                    <h2 class="ff-baskervville mb-4 news-detail-heading">Why a Property Assessment Is One of the Smartest Steps a Buyer Can Take</h2>
                    <p class="ff-gill-sans-light mb-4 news-detail-paragraph">Buying a property is often an emotional decision. A sense of light, generous proportions, period charm or the promise of potential can be enough to sway even experienced buyers. Yet what is often less visible during a viewing are the practical limitations, hidden costs or missed opportunities that may only emerge after purchase.</p>
                    <p class="ff-gill-sans-light mb-4 news-detail-paragraph">At FCM, we believe a property should be assessed not only for what it is today, but for what it can become and whether it can truly support the way a client wants to live. This is where a property assessment can offer significant value.</p>
                    <p class="ff-gill-sans-light mb-5 news-detail-paragraph">Increasingly, buyers are seeking professional design advice before committing to a property, using an interior designer's expertise not simply for decoration or renovation planning, but as part of the decision-making process itself.</p>
                    <h3 class="ff-baskervville mb-3 news-detail-subheading">Looking Beyond First Impressions</h3>
                    <p class="ff-gill-sans-light mb-4 news-detail-paragraph">At FCM, we look beyond finishes, square footage and cosmetic details to assess how a property functions, how spaces connect, where opportunities lie and whether the property has the potential to be transformed in meaningful ways.</p>
                    <h3 class="ff-baskervville mb-3 mt-5 news-detail-subheading">Identifying Challenges Before They Become Costly</h3>
                    <p class="ff-gill-sans-light mb-4 news-detail-paragraph">One of the greatest benefits of a property assessment is the ability to uncover design challenges early, before they evolve into expensive problems.</p>
                    <h3 class="ff-baskervville mb-3 mt-5 news-detail-subheading">A Strategic Layer of Confidence</h3>
                    <p class="ff-gill-sans-light mb-5 news-detail-paragraph">Property purchase carries significant financial and emotional weight. Having a professional assess a property introduces an additional layer of clarity and objectivity at a moment when decisions are often made under pressure.</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Related News Section -->
    <section class="py-5 news-detail-related-news-section">
        <div class="container-fluid px-md-4">
            <h2 class="ff-baskervville mb-5 text-center text-md-start news-detail-section-title">Latest News</h2>
        </div>
        <div class="container-fluid px-0">
            <div class="row mx-0">
                @if(isset($related) && $related->count() > 0)
                    @foreach($related as $index => $item)
                        @php
                            $colClass = $loop->first ? 'pe-lg-3 ps-lg-0' : ($loop->last ? 'ps-lg-3 pe-lg-0' : 'px-lg-3');
                        @endphp
                        <div class="col-md-4 mb-4 {{ $colClass }}">
                            <a href="{{ route('page.news-detail', ['slug' => $item->slug]) }}" class="text-decoration-none d-block blog-thumb h-100">
                                <div class="card border-0 h-100 bg-transparent">
                                    <div class="overflow-hidden news-card-img-wrapper">
                                        <img src="{{ !empty($item->image) ? asset('storage/' . $item->image) : (!empty($cms['hero']['image']) ? asset('storage/' . $cms['hero']['image']) : asset('assets/images/news/news-6.webp')) }}" class="w-100 h-100 news-card-img" alt="{{ $item->title }}">
                                    </div>
                                    <div class="card-body pt-4 px-3">
                                        <p class="ff-gill-sans-light text-muted mb-2 news-card-date">{{ $item->created_at->format('F j, Y') }}</p>
                                        <h3 class="card-title ff-baskervville text-custom-color-2 mb-0 news-card-title">{{ $item->title }}</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <p class="ff-gill-sans-light text-muted">No related articles found.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</main>

@endsection
