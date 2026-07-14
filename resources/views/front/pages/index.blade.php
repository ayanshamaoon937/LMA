@extends('front.newLayout.protected')
@use(Illuminate\Support\Str)
@section('content')
<main class="home-page">
<!-- Top Bar (Outside hero but at very top) -->
<div class="top-bar bg-custom-color-1 text-white fw-medium ff-gill-sans">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="mb-2 mb-md-0 text-lg-start text-center d-none d-lg-block">
            <svg class="me-2 mb-1" width="16" height="16" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 8C5.00555 8 4.5222 7.85338 4.11108 7.57868C3.69995 7.30397 3.37952 6.91353 3.1903 6.45671C3.00108 5.99989 2.95157 5.49723 3.04804 5.01228C3.1445 4.52732 3.3826 4.08187 3.73223 3.73223C4.08187 3.3826 4.52732 3.1445 5.01228 3.04804C5.49723 2.95157 5.9999 3.00108 6.45671 3.1903C6.91353 3.37952 7.30397 3.69995 7.57868 4.11108C7.85338 4.5222 8 5.00555 8 5.5C7.99921 6.1628 7.73556 6.79822 7.26689 7.26689C6.79822 7.73556 6.1628 7.99921 5.5 8ZM5.5 4C5.20333 4 4.91332 4.08797 4.66665 4.2528C4.41997 4.41762 4.22771 4.65189 4.11418 4.92598C4.00065 5.20007 3.97095 5.50167 4.02882 5.79264C4.0867 6.08361 4.22956 6.35088 4.43934 6.56066C4.64912 6.77044 4.91639 6.9133 5.20737 6.97118C5.49834 7.02906 5.79994 6.99935 6.07403 6.88582C6.34812 6.77229 6.58238 6.58003 6.74721 6.33336C6.91203 6.08668 7 5.79667 7 5.5C6.9996 5.1023 6.84144 4.721 6.56022 4.43978C6.279 4.15856 5.8977 4.0004 5.5 4Z" fill="currentColor"/><path d="M5.5 14L1.282 9.0255C1.22339 8.95081 1.16539 8.87564 1.108 8.8C0.387857 7.8507 -0.00133722 6.69155 3.45209e-06 5.5C3.45209e-06 4.04131 0.579466 2.64236 1.61092 1.61091C2.64237 0.579463 4.04131 0 5.5 0C6.95869 0 8.35764 0.579463 9.38909 1.61091C10.4205 2.64236 11 4.04131 11 5.5C11.0012 6.69098 10.6122 7.84954 9.8925 8.7985L9.892 8.8C9.892 8.8 9.742 8.997 9.7195 9.0235L5.5 14ZM1.9065 8.1975C1.9065 8.1975 2.023 8.3515 2.0495 8.3845L5.5 12.454L8.955 8.379C8.977 8.3515 9.0945 8.196 9.0945 8.196C9.68311 7.42057 10.0012 6.47352 10 5.5C10 4.30653 9.5259 3.16193 8.68198 2.31802C7.83807 1.47411 6.69348 1 5.5 1C4.30653 1 3.16194 1.47411 2.31802 2.31802C1.47411 3.16193 1 4.30653 1 5.5C0.99877 6.47415 1.31723 7.42179 1.9065 8.1975Z" fill="currentColor"/></svg>
            <span class="pt-1">{{ $cms['top_bar']['address'] ?? '6th Floor, International House, 223 Regent Street, London W1B 2QD' }}</span>
        </div>
        <div class="d-flex gap-4 align-items-center">
            <a class="text-white text-decoration-none d-flex align-items-center" href="tel:{{ preg_replace('/\s+/', '', $cms['top_bar']['phone'] ?? '0207 323 5758') }}">
                <svg class="me-2 mt-1" width="16" height="16" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.4445 1C1.32681 1.00066 1.21413 1.0477 1.13092 1.13092C1.0477 1.21413 1.00066 1.32681 1 1.4445C1 10.0365 7.9635 17 16.5555 17C16.6732 16.9993 16.7859 16.9523 16.8691 16.8691C16.9523 16.7859 16.9993 16.6732 17 16.5555V13.26C16.9993 13.1423 16.9523 13.0296 16.8691 12.9464C16.7859 12.8632 16.6732 12.8162 16.5555 12.8155C15.331 12.8155 14.1355 12.618 13.027 12.252L13.022 12.25C12.9447 12.2248 12.8619 12.2215 12.7828 12.2404C12.7037 12.2594 12.6314 12.2999 12.574 12.3575L10.239 14.6925L9.915 14.5265C7.1495 13.1095 4.8815 10.8525 3.4735 8.0845L3.3085 7.761L5.6435 5.426C5.7026 5.36773 5.74444 5.29425 5.76438 5.21369C5.78432 5.13312 5.78159 5.04861 5.7565 4.9695C5.38276 3.8319 5.19304 2.64192 5.1945 1.4445C5.19384 1.32681 5.1468 1.21413 5.06358 1.13092C4.98037 1.0477 4.86769 1.00066 4.75 1H1.4445ZM0 1.4445C0.000660975 1.0616 0.153061 0.694567 0.423814 0.423814C0.694567 0.153061 1.0616 0.000660975 1.4445 0H4.75C5.1329 0.000660975 5.49993 0.153061 5.77069 0.423814C6.04144 0.694567 6.19384 1.0616 6.1945 1.4445C6.1945 2.5715 6.3745 3.652 6.7075 4.6595L6.7085 4.6625L6.7095 4.666C6.79015 4.91995 6.79926 5.19121 6.73584 5.45C6.67243 5.7088 6.53893 5.94511 6.35 6.133L4.533 7.9505C5.80318 10.2815 7.71874 12.1967 10.05 13.4665L11.8665 11.65C12.056 11.4605 12.2945 11.3277 12.5554 11.2664C12.8162 11.205 13.089 11.2177 13.343 11.303C14.3798 11.6427 15.464 11.8155 16.555 11.815C16.938 11.8155 17.3051 11.9679 17.576 12.2386C17.8469 12.5094 17.9993 12.8765 18 13.2595V16.5555C17.9993 16.9384 17.8469 17.3054 17.5762 17.5762C17.3054 17.8469 16.9384 17.9993 16.5555 18C7.411 18 0 10.589 0 1.4445Z" fill="currentColor"/></svg>
                <span class="">{{ $cms['top_bar']['phone'] ?? '0207 323 5758' }}</span>
            </a>
            <a class="text-white text-decoration-none d-flex align-items-center" href="mailto:{{ $cms['top_bar']['email'] ?? 'info@fcmltd.co.uk' }}">
                <svg class="me-2 mt-1" width="16" height="16" viewBox="0 0 26 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.679 20.1915H22.546C24.656 20.1915 25.8745 18.973 25.8745 16.559V3.621C25.8745 1.2185 24.6445 0 22.1945 0H3.328C1.2305 0 0 1.207 0 3.621V16.5585C0 18.984 1.242 20.191 3.68 20.191M11.5435 10.6875L2.695 1.9575C2.9525 1.852 3.257 1.7935 3.6205 1.7935H22.2655C22.6285 1.7935 22.945 1.852 23.2145 1.981L14.3785 10.688C13.8745 11.1915 13.429 11.4145 12.9605 11.4145C12.4915 11.4145 12.0465 11.1915 11.5425 10.688M1.792 16.559V3.504L8.53 10.114L1.804 16.7575C1.7925 16.699 1.7925 16.6285 1.7925 16.5585M24.0815 3.6325V16.7225L17.39 10.1135L24.082 3.5395L24.0815 3.6325ZM3.6205 18.399C3.2805 18.399 2.9995 18.352 2.7535 18.2465L9.761 11.3205L10.523 12.0705C11.343 12.879 12.128 13.219 12.9605 13.219C13.7805 13.219 14.5775 12.879 15.398 12.0705L16.1595 11.3205L23.156 18.2345C22.9095 18.352 22.605 18.3985 22.265 18.3985L3.6205 18.399Z" fill="currentColor"/></svg>
                <span class="">{{ $cms['top_bar']['email'] ?? 'info@fcmltd.co.uk' }}</span>
            </a>
        </div>
    </div>
</div>

@php
    $heroVideo = !empty($cms['hero']['video']) ? asset('storage/' . $cms['hero']['video']) : asset('assets/images/videos/top.mp4');
    $heroImage = !empty($cms['hero']['image']) ? asset('storage/' . $cms['hero']['image']) : null;
@endphp
<!-- Hero Section -->
<section class="hero-section position-relative" style="overflow: hidden; background: none;">
    <!-- Background Video -->
    <video autoplay loop muted playsinline class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 0;">
        <source src="{{ $heroVideo ? $heroVideo : asset('assets/images/videos/top.mp4') }}#t=0.001" type="video/mp4">
    </video>
    <!-- Dark overlay for text readability -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,0.4); z-index: 0;"></div>

    <div class="position-relative d-flex flex-column flex-grow-1 w-100" style="z-index: 1;">
        <!-- Header Inside Hero -->
        @include('front.newLayout.header')
        <!-- Hero Content -->
        <div class="container flex-grow-1 d-flex flex-column">
            <div class="row mx-0 flex-grow-1">
                <div class="col-lg-6 px-0 d-flex flex-column">
                    <div class="hero-content px-md-0">
                       <h1 class="hero-title display-5 mb-3 fw-light text-white ff-baskervville text-uppercase">{{ $cms['hero']['title'] ?? 'Clerks of Works Services and Site Inspections' }}</h1>
                        {{-- <h1 class="hero-title display-5 mb-3 fw-semibold text-white ff-baskervville text-uppercase">Clerks of Works Services and Site Inspections</h1> --}}
                        
                        @if($cms['hero']['content'])
                          <div class="hero-text ff-gill-sans-light fw-light text-white mb-3">
                            {!! $cms['hero']['content'] !!}
                          </div>
                        @else
                        <p class="hero-text ff-gill-sans-light fw-light text-white mb-3">Most construction professionals are concerned about quality and safety in their building projects.</p>
                        <p class="hero-text ff-gill-sans-light fw-light text-white mb-3">
                            We will act as your eyes and ears on site and help your contractors to get it right first time, giving you peace of mind that you are protected from defects and deficiencies.
                        </p>
                        @endif
                        <div class="btn-wrapper">
                            <a href="{{ route('page.contact') }}" class="btn btn-primary text-decoration-none text-white ff-gill-sans text-uppercase"><span> {{ $cms['hero']['button_text'] ?? 'Get in touch' }}</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Who We Are Section -->
<section class="who-we-are py-5 text-center my-4">
    <div class="container">
        <div class="row mx-0"> 
            <div class="col-lg-4 px-0 mx-auto"> 
                <h6 class="sub-title text-custom-color-1 text-uppercase ff-gill-sans-medium">{{ $cms['who_we_are']['title'] ?? 'Who We Are' }}</h6>
                <h2 class="section-title text-custom-color-2 text-uppercase ff-baskervville mt-3 mb-4">{{ $cms['who_we_are']['subtitle'] ?? 'Established for over 30 years' }}</h2>
                <div class="title-divider bg-custom-color-1 mx-auto mb-4"></div>
            </div>
        </div>
        <p class="description text-custom-color-1 mx-auto ff-gill-sans-light mb-4">
           @if($cms['who_we_are']['content'])
             <span class="description text-custom-color-1 mx-auto ff-gill-sans-light mb-4">
               {!! $cms['who_we_are']['content'] !!}
             </span>
           @else
           FCM provides leading Clerks of Works and construction inspection services throughout London and the home counties. The business was founded in 1986 by Francis Murray to offer clients the best professional service and value. As a collective, FCM offers a breadth and depth of experience and expertise across many sectors, without passing on the overheads of extremely large consulting and recruitment companies
           @endif
        </p>
        <div class="btn-wrapper">
        <a href="{{ route('page.contact') }}" class="btn btn-primary text-white text-decoration-none ff-gill-sans text-uppercase"><span>{{ $cms['who_we_are']['button_text'] ?? 'Enquire Today' }}</span></a>
        </div>
    </div>
</section>

<!-- Video Section -->
<section class="video-section position-relative">
    @php $videoSrc = !empty($cms['video']['video']) ? asset('storage/' . $cms['video']['video']) : asset('assets/images/videos/bottom.mp4'); @endphp
    <video id="fcmVideo" class="fcm-video w-100 h-100 object-fit-cover opacity-75" src="{{ $videoSrc }}#t=0.001" preload="metadata" playsinline></video>
    
    <div id="videoOverlay" class="video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">
        <button id="playPauseBtn" class="play-pause-btn btn rounded-circle d-flex justify-content-center align-items-center shadow-none">
            <i class="bi bi-play-fill text-white"></i>
        </button>
    </div>


</section>

<!-- Services Section -->
<section class="services-section pt-5 bg-custom-color-4">
    <div class="container text-center pb-4">
        <h6 class="sub-title text-custom-color-1 text-uppercase ff-gill-sans-medium">{{ $cms['what_we_do_services']['title'] ?? 'What We Do' }}</h6>
        <h2 class="section-title text-custom-color-2 text-uppercase ff-baskervville mt-3 mb-4">{{ $cms['what_we_do_services']['subtitle'] ?? 'Our Services' }}</h2>
        
        <div class="title-divider bg-custom-color-1 mx-auto mb-4"></div>
        
        <p class="description text-custom-color-1 mx-auto ff-gill-sans-light mb-5">
            @if($cms['what_we_do_services']['content'])
              <span class="description text-custom-color-1 mx-auto ff-gill-sans-light mb-5">
                {!! $cms['what_we_do_services']['content'] !!}
              </span>
            @else
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper
            @endif
        </p>
    </div>
    
    <div class="container-fluid p-0">
        <div class="swiper services-swiper">
            <div class="swiper-wrapper">
                @foreach($services as $service)
                <a href="{{ route('page.service-detail', ['slug' => $service->slug]) }}" class="swiper-slide service-item position-relative overflow-hidden text-decoration-none"
                style="background-image: url('{{ $service->image ? asset('storage/'.$service->image) : asset('assets/images/services/service-1.webp') }}');">
                
                    <div class="service-overlay position-absolute bottom-0 start-0 w-100 p-4">
                        <h5 class="service-title text-white ff-baskervville m-0 text-uppercase">
                            {!! nl2br(e($service->title)) !!}
                        </h5>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>



<!-- Our Sectors Section -->
<div class="sectors-scroll-container position-relative" style="--items-count: {{ max(1, count($cms['our_sectors']['items'] ?? [])) }};">
    <section class="our-sectors-section container-fluid p-0 position-sticky">
        <div class="row g-0 h-100 flex-column flex-lg-row">
            <!-- Left Image Half (Top on mobile) -->
            <div class="col-lg-6 position-relative sectors-half sectors-image-container">
                @if(!empty($cms['our_sectors']['items']))
                    @foreach($cms['our_sectors']['items'] as $index => $item)
                        @php
                            $itemImg = !empty($item['image']) ? asset('storage/' . $item['image']) : asset('assets/images/our-sectors.webp');
                        @endphp
                        <img src="{{ $itemImg }}" alt="{{ $item['title'] ?? 'Sector' }}" 
                             class="w-100 h-100 object-fit-cover position-absolute top-0 start-0 sectors-bg-img {{ $index === 0 ? 'active' : '' }}" 
                             data-index="{{ $index }}">
                    @endforeach
                @else
                    <img src="{{ asset('assets/images/our-sectors.webp') }}" alt="Our Sectors" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0">
                @endif
            </div>

            <!-- Right Content Half (Bottom on mobile) -->
            <div class="col-lg-6 text-white bg-custom-color-1 d-flex align-items-center justify-content-center px-4 px-md-5 sectors-half">
                <div class="sectors-content-wrapper w-100 text-center py-4">
                    <h2 class="section-title text-uppercase ff-baskervville my-3 mt-lg-0">{{ $cms['our_sectors']['title'] ?? 'Our Sectors' }}</h2>
                    {{-- <div class="sector-desc ff-gill-sans-light text-white mx-auto my-3 mt-lg-0 mb-lg-5">
                                {!! $cms['our_sectors']['content'] ?? '' !!}
                        </div> --}}
                    <div class="description text-white mx-auto ff-gill-sans-light my-3 mt-lg-0 mb-lg-5 d-none d-lg-block">
                        {!! $cms['our_sectors']['content'] ?? '' !!}
                    </div>
                    
                    <div class="sectors-list-container text-start ps-2 position-relative sectors-timeline">
                        @if(!empty($cms['our_sectors']['items']))
                            @foreach($cms['our_sectors']['items'] as $index => $item)
                            <div class="sector-text-item d-flex {{ $index === 0 ? 'active' : '' }} position-relative z-1 mb-3 mb-lg-5" data-index="{{ $index }}">
                                @if(!$loop->last)
                                    <div class="timeline-line bg-white position-absolute" style="left: 0px; top: 0px; width: 1px; z-index: 0;"></div>
                                @else
                                    <div class="timeline-line bg-white position-absolute" style="left: 0px; top: 0px; width: 1px; height: 48px; z-index: 0;"></div>
                                @endif
                                <div class="sector-icon bg-custom-color-2 text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle ms-4">
                                    <i class="{{ $item['icons'] ?? 'bi bi-mortarboard' }} fs-4"></i>
                                </div>
                                <div class="ms-4 pt-1 w-100 text-start">
                                    <h3 class="sector-title ff-baskervville mb-2 fw-bold text-uppercase">{{ $item['title'] ?? '' }}</h3>
                                    <div class="sector-desc ff-gill-sans-light text-white m-0">
                                        {!! $item['description'] ?? '' !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="sector-text-item d-flex active position-relative z-1 mb-3 mb-lg-5" data-index="0">
                                <div class="sector-icon bg-custom-color-2 text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle ms-4">
                                    <i class="bi bi-mortarboard fs-4"></i>
                                </div>
                                <div class="ms-4 pt-1 w-100 text-start">
                                    <h3 class="sector-title ff-baskervville mb-2 fw-bold text-uppercase">Sale Regain & Connected Systems</h3>
                                    <div class="sector-desc ff-gill-sans-light text-white m-0">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Exercitationem quas nobis totam dolore, officiis architecto eveniet.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector('.sectors-scroll-container');
    const bgImages = document.querySelectorAll('.sectors-bg-img');
    const textItems = document.querySelectorAll('.sector-text-item');
    
    if(!scrollContainer || bgImages.length === 0) return;

    window.addEventListener('scroll', function() {
        const rect = scrollContainer.getBoundingClientRect();
        
        // Calculate progress inside the container
        let scrollProgress = -rect.top / (rect.height - window.innerHeight);
        scrollProgress = Math.max(0, Math.min(1, scrollProgress));
        
        // Find active index based on progress
        let activeIndex = Math.floor(scrollProgress * textItems.length);
        if (activeIndex >= textItems.length) activeIndex = textItems.length - 1;

        // Update active classes
        bgImages.forEach((img, i) => {
            if (i === activeIndex) {
                img.classList.add('active');
            } else {
                img.classList.remove('active');
            }
        });

        textItems.forEach((item, i) => {
            if (i === activeIndex) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    });
});
</script>

<!-- Latest News Section -->
<section class="latest-news-section py-5 my-5">
    <div class="container text-center mb-5">
        <h6 class="sub-title text-custom-color-1 text-uppercase ff-gill-sans-medium">{{ $cms['upto_date_news']['title'] ?? 'Keep Up To Date' }}</h6>
        <h2 class="section-title text-custom-color-2 text-uppercase ff-baskervville mt-3 mb-4">{{ $cms['upto_date_news']['subtitle'] ?? 'Latest News' }}</h2>
        <div class="title-divider bg-custom-color-1 mx-auto"></div>
    </div>
    
    <div class="container-fluid px-0">
        <div class="row mx-0">
            <!-- News Item 1 -->
            @foreach($news as $loop_index => $article)
             @php
                $newsImg = !empty($article->image) ? asset('storage/' . $article->image) : asset('assets/images/news/news-1.webp');
                $colClass = match($loop_index) { 0 => 'col-md-4 ps-lg-0 px-0 pe-lg-3', 1 => 'col-md-4  px-0 px-lg-3', default => 'col-md-4 pe-lg-0 px-0 ps-lg-3' };
            @endphp
            <div class="{{ $colClass }}">
                <a href="{{ route('page.news-detail', ['slug' => $article->slug]) }}" class="card border-0 rounded-0 h-100 bg-custom-color-5 text-decoration-none">
                    <div class="position-relative">
                        <img src="{{ $newsImg }}" class="news-image card-img-top rounded-0 object-fit-cover" alt="{{ $article->title }}">
                        <div class="news-date-tag position-absolute top-0 start-0 text-white text-center pt-2 pb-2 ff-gill-sans fw-bold">
                            <span class="news-date-day d-block">{{ $article->published_at?->format('d') ?? $article->created_at->format('d') }}</span>
                            <span class="news-date-month d-block">{{ strtoupper(($article->published_at ?? $article->created_at)->format('M')) }}</span>
                        </div>
                    </div>
                    <div class="news-card-body card-body text-center p-4 d-flex flex-column justify-content-center">
                        <h5 class="news-title card-title text-uppercase text-custom-color-2 ff-baskervville fw-bold mb-3">{!! nl2br(e($article->title)) !!}</h5>
                        <p class="news-description card-text text-custom-color-1 ff-gill-sans-light mb-0 mx-auto">
                            {{ Str::limit(strip_tags($article->content ?? ''), 100) ?: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao' }}
                        </p>
                    </div>
                </a>
            </div>
            @endforeach
            
            <!-- News Item 2 -->
            {{-- <div class="col-md-4  px-0 px-lg-3">
                <a href="{{ route('page.news-detail') }}" class="card border-0 rounded-0 h-100 bg-custom-color-5 text-decoration-none">
                    <div class="position-relative">
                        <img src="{{ asset('assets/images/news/news-2.webp') }}" class="news-image card-img-top rounded-0 object-fit-cover" alt="News 2">
                        <div class="news-date-tag position-absolute top-0 start-0 text-white text-center pt-2 pb-2 ff-gill-sans fw-bold">
                            <span class="news-date-day d-block">21</span>
                            <span class="news-date-month d-block">MAY</span>
                        </div>
                    </div>
                    <div class="news-card-body card-body text-center p-4 d-flex flex-column justify-content-center">
                        <h5 class="news-title card-title text-custom-color-2 text-uppercase ff-baskervville fw-bold mb-3">CORRECT INSTALLATION<br>OF FIRE DOORS</h5>
                        <p class="news-description card-text text-custom-color-1 ff-gill-sans-light mb-0 mx-auto">
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao
                        </p>
                    </div>
                </a>
            </div> --}}
            
            <!-- News Item 3 -->
            {{-- <div class="col-md-4 pe-lg-0 px-0 ps-lg-3">
                <a href="{{ route('page.news-detail') }}" class="card border-0 rounded-0 h-100 bg-custom-color-5 text-decoration-none">
                    <div class="position-relative">
                        <img src="{{ asset('assets/images/news/news-3.webp') }}" class="news-image card-img-top rounded-0 object-fit-cover" alt="News 3">
                        <div class="news-date-tag position-absolute top-0 start-0 text-white text-center pt-2 pb-2 ff-gill-sans fw-bold">
                            <span class="news-date-day d-block">30</span>
                            <span class="news-date-month d-block">MAY</span>
                        </div>
                    </div>
                    <div class="news-card-body card-body text-center p-4 d-flex flex-column justify-content-center">
                        <h5 class="news-title card-title text-uppercase ff-baskervville text-custom-color-2 fw-bold mb-3">CORRECT INSTALLATION OF<br>EXTRACT DUCTS</h5>
                        <p class="news-description card-text text-custom-color-1 ff-gill-sans-light mb-0 mx-auto">
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam esnonummy nibh euismod tincidunt lao
                        </p>
                    </div>
                </a>
            </div> --}}
        </div>
    </div>
</section>

<!-- Latest Projects Section -->
<section class="latest-projects-section pt-5 bg-custom-color-1">
    <div class="container text-center text-white mb-5 pt-3">
        <h6 class="sub-title text-uppercase ff-gill-sans-medium text-white">{{ $cms['what_we_do_projects']['title'] ?? 'What We Do' }}</h6>
        <h2 class="section-title text-uppercase ff-baskervville mt-3 mb-4 text-white">{{ $cms['what_we_do_projects']['subtitle'] ?? 'Latest Projects' }}</h2>
        <div class="title-divider bg-custom-color-2 mx-auto"></div>
    </div>
    
    <div class="container-fluid p-0">
        <div class="row g-0 mx-0">
              @foreach($projects as $project)
               @php 
                $projImg = !empty($project->image) ? asset('storage/' . $project->image) : asset($project->static_image ?? 'assets/images/projects/project-1.webp'); 
            @endphp
            <a href="{{ route('page.project-detail', ['slug' => $project->slug ?? '#']) }}" class="col-md-6 position-relative project-item text-decoration-none d-block">
                <img src="{{ $projImg }}" class="w-100 h-100 object-fit-cover" alt="{{ $project->title }}">
                <div class="project-overlay position-absolute bottom-0 start-0 w-100 p-4 ps-md-5">
                    <h5 class="project-title text-white ff-baskervville m-0 text-uppercase mb-1">{{ $project->title ?? '400 Longwater Avenue' }}</h5>
                    <p class="project-category text-white ff-gill-sans fw-bold m-0 text-uppercase">{{ $project->category?->name ?? 'Construction' }}</p>
                </div>
            </a>
            @endforeach
            
            {{-- <!-- Project 2 -->
            <a href="{{ route('page.project-detail') }}" class="col-md-6 position-relative project-item text-decoration-none d-block">
                <img src="{{ asset('assets/images/projects/project-2.webp') }}" class="w-100 h-100 object-fit-cover" alt="DELANEY TWO">
                <div class="project-overlay position-absolute bottom-0 start-0 w-100 p-4 ps-md-5">
                    <h5 class="project-title text-white ff-baskervville m-0 text-uppercase mb-1">Delaney Two</h5>
                    <p class="project-category text-white ff-gill-sans fw-bold m-0 text-uppercase">Cladding Works</p>
                </div>
            </a>
            
            <!-- Project 3 -->
            <a href="{{ route('page.project-detail') }}" class="col-md-6 position-relative project-item text-decoration-none d-block">
                <img src="{{ asset('assets/images/projects/project-3.webp') }}" class="w-100 h-100 object-fit-cover" alt="APEX HOUSE">
                <div class="project-overlay position-absolute bottom-0 start-0 w-100 p-4 ps-md-5">
                    <h5 class="project-title text-white ff-baskervville m-0 text-uppercase mb-1">Apex House</h5>
                    <p class="project-category text-white ff-gill-sans fw-bold m-0 text-uppercase">Construction</p>
                </div>
            </a>
            
            <!-- Project 4 -->
            <a href="{{ route('page.project-detail') }}" class="col-md-6 position-relative project-item text-decoration-none d-block">
                <img src="{{ asset('assets/images/projects/project-4.webp') }}" class="w-100 h-100 object-fit-cover" alt="GREENWICH MILLENNIUM VILLAGE">
                <div class="project-overlay position-absolute bottom-0 start-0 w-100 p-4 ps-md-5">
                    <h5 class="project-title text-white ff-baskervville m-0 text-uppercase mb-1">Greenwich Millennium Village</h5>
                    <p class="project-category text-white ff-gill-sans fw-bold m-0 text-uppercase">Construction</p>
                </div>
            </a> --}}
        </div>
    </div>
    
  
    <div class="text-center py-5">
        <a href="{{ route('page.projects') }}" class="btn btn-primary light-animation text-white text-decoration-none ff-gill-sans text-uppercase"><span>{{ $cms['what_we_do_projects']['button_text'] ?? 'View More' }}</span></a>
    </div>
  
</section>

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

            // Ensure map sizes correctly after render
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
                <h6 class="sub-title text-custom-color-1 text-uppercase ff-gill-sans-medium mb-3">{{ $cms['contact']['title'] ?? 'Contact' }}</h6>
                <h2 class="section-title text-custom-color-2 text-uppercase ff-baskervville mb-4 mx-0">{{ $cms['contact']['subtitle'] ?? 'Get In Touch' }}</h2>
                
                <div class="contact-intro text-custom-color-1 ff-gill-sans mb-5">
                    {!! $cms['contact']['content'] ?? 'We are waiting for you at out London office or in other way, you can contact us via the contact form below to discuss your project, your idea' !!}
                </div>
                
                <div class="row mb-5 mx-0">
                    <div class="col-6 ps-0 mb-3">
                        <h6 class="contact-label text-custom-color-2 text-uppercase fw-semibold ff-gill-sans-medium mb-2">Email:</h6>
                        <a href="mailto:{{ get_setting('email') ?? 'info@fcmltd.co.uk' }}" class="contact-link text-custom-color-1 text-decoration-none fw-semibold ff-gill-sans-medium">
                            {{ get_setting('email') ?? 'info@fcmltd.co.uk' }}
                        </a>
                    </div>
                    <div class="col-6 pe-0">
                        <h6 class="contact-label text-custom-color-2 text-uppercase fw-semibold ff-gill-sans-medium mb-2">Phone:</h6>
                        <a href="tel:{{ preg_replace('/\s+/', '', get_setting('phone') ?? '+020 323 5758') }}" class="contact-link text-custom-color-1 text-decoration-none fw-semibold ff-gill-sans-medium">
                            {{ get_setting('phone') ?? '+020 323 5758' }}
                        </a>
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
                        <input type="email"  name="email" class="form-input-custom form-control shadow-none rounded-0 px-0" id="contactEmail">
                    </div>
                    
                    <!-- <div class="mb-4">
                        <label for="contactMessage" class="form-label-custom text-custom-color-1 form-label ff-gill-sans">Message</label>
                        <textarea class="form-textarea-custom form-control shadow-none rounded-0" id="contactMessage" rows="5"></textarea>
                    </div> -->
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


<!-- Certifications Section -->
 @if($accreditations->count() > 0)
<section class="certifications-section py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center text-center mx-0">
            <!-- Cert 1 -->

            @forelse($accreditations as $company)
            <div class="col-md-4 mb-5 mb-md-0 d-flex flex-column align-items-center">
                <img src="{{ $company->logo ? asset('storage/' . $company->logo) : asset('') }}" alt="{{ $company->name }}" class="cert-image">
                <p class="cert-description text-custom-color-1 text-uppercase fw-semibold ff-gill-sans-medium mx-auto">
                    {{ $company->title ?? '' }}
                </p>
            </div>
            @empty
    
            @endforelse


            {{-- <div class="col-md-4 mb-5 mb-md-0 d-flex flex-column align-items-center">
                <img src="assets/images/qas-international.webp" alt="QAS International" class="cert-image">
                <p class="cert-description text-custom-color-1 text-uppercase fw-semibold ff-gill-sans-medium mx-auto">
                    ISO 9001:2015 Registered Firm
                </p>
            </div>
            <div class="col-md-4 d-flex flex-column align-items-center">
                <img src="assets/images/london-chamber.webp" alt="London Chamber of Commerce" class="cert-image">
                <p class="cert-description text-custom-color-1 text-uppercase fw-semibold ff-gill-sans-medium mx-auto">
                    Proud member of the London Chamber of Commerce and Industry
                </p>
            </div> --}}
        </div>
    </div>
</section>

@endif

<!-- Instagram Section -->
<section class="instagram-section pt-5 pb-0 bg-white text-center">
    <div class="container mb-5">
        <h6 class="sub-title text-uppercase text-custom-color-1 ff-gill-sans-medium mb-2">Follow Us</h6>
        <h2 class="section-title text-uppercase text-custom-color-2 ff-baskervville">Instagram</h2>
    </div>
    
    <div class="container-fluid p-0 overflow-hidden">
        <div class="marquee-wrapper">
            <div class="marquee-content">
                <div class="insta-item">
                    <img src="assets/images/projects/project-1.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 1">
                </div>
                <div class="insta-item">
                    <img src="assets/images/news/news-1.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 2">
                </div>
                <div class="insta-item">
                    <img src="assets/images/projects/project-3.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 3">
                </div>
                <div class="insta-item">
                    <img src="assets/images/news/news-2.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 4">
                </div>
                <div class="insta-item">
                    <img src="assets/images/projects/project-4.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 5">
                </div>
            </div>
            <!-- Duplicate content for seamless loop -->
            <div class="marquee-content" aria-hidden="true">
                <div class="insta-item">
                    <img src="assets/images/projects/project-1.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 1">
                </div>
                <div class="insta-item">
                    <img src="assets/images/news/news-1.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 2">
                </div>
                <div class="insta-item">
                    <img src="assets/images/projects/project-3.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 3">
                </div>
                <div class="insta-item">
                    <img src="assets/images/news/news-2.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 4">
                </div>
                <div class="insta-item">
                    <img src="assets/images/projects/project-4.webp" class="w-100 h-100 object-fit-cover" alt="Instagram 5">
                </div>
            </div>
        </div>
    </div>
</section>

</main>

@endsection


@section('c_scripts')
   {{-- CSS classes are handled by the service defaults and container wrappers --}}
   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const pElements = document.querySelectorAll('.who-we-are p');

        pElements.forEach(function (p) {
            p.className = 'description text-custom-color-1 mx-auto ff-gill-sans-light mb-4';
        });

        const ServicePElements = document.querySelectorAll('.services-section p');

        ServicePElements.forEach(function (p) {
            p.className = 'description text-custom-color-1 mx-auto ff-gill-sans-light mb-5';
        });
    });
   </script>
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

