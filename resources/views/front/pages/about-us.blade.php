@extends('front.newLayout.protected')

@section('content')

<main>
    <!-- Hero Section -->
    <section class="about-hero d-flex align-items-end position-relative" style="background-image: url('{{ !empty($cms['hero']['image']) ? asset('storage/' . $cms['hero']['image']) : asset('assets/images/about-2.webp') }}');">
        <div class="overlay"></div>
        <div class="container position-relative z-1">
            <h1 class="hero-title text-white ff-baskervville fw-normal mb-0">{{ $cms['hero']['title'] ?? 'About Us' }}</h1>
        </div>
    </section>
    
    <!-- Who We Are -->
    <section class="py-5 text-center bg-custom-color-4 about-who-we-are-section">
        <div class="container py-5">
             <div class="row mx-0">
                <div class="col-lg-8 mx-auto px-0">
                    <p class="about-section-subtitle text-uppercase mb-2 text-custom-color-1 fw-semibold ff-gill-sans-medium">{{ $cms['established']['title'] ?? 'Who We Are' }}</p>
                    <h2 class="about-section-title ff-baskervville mb-4 text-custom-color-2">
                        {{ $cms['established']['subtitle'] ?? 'Established for over 30 years' }}
                    </h2>
                    @if(!empty($cms['established']['content']))
                        <div class="about-text ff-gill-sans-light text-custom-color-1 mb-3">
                            {!! $cms['established']['content'] !!}
                        </div>
                    @else
                    <p class="about-text ff-gill-sans-light text-custom-color-1 mb-3">
                        Established for over 30 years, FCM provides leading Clerks of Works and construction inspection services throughout London and the home counties. The business was founded in 1986 by Francis Murray to offer clients the best professional service and value. As a collective, FCM offers a breadth and depth of experience and expertise across many sectors, without passing on the overheads of extremely large consulting and recruitment companies.
                    </p>
                    <p class="about-text ff-gill-sans-light text-custom-color-1 mb-3">
                        All our Clerks of Works are either Members of the Institute of Clerks of Works and Construction Inspectorate (MICWCI) or are qualified in their own specialist fields.
                    </p>
                    <p class="about-text ff-gill-sans-light text-custom-color-1 mb-3">
                        All our work is fully insured with our five-million-pound professional indemnity insurance and ten-million-pound public liability insurance for your peace of mind.
                    </p>
                    <p class="about-text ff-gill-sans-light text-custom-color-1 mb-3">
                        We are an ISO 9001:2015 registered firm.
                    </p>
                    <p class="about-text ff-gill-sans-light text-custom-color-1 fw-bold mb-0">
                        FCM’s quality audit certificate
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Image Full Width -->
    <div class="about-full-img-container w-100">
        <img src="{{ !empty($cms['middle_break']['image']) ? asset('storage/' . $cms['middle_break']['image']) : asset('assets/images/about-1.webp') }}" class="w-100 h-100 object-fit-cover" alt="How We Work">
    </div>

    <!-- What We Do -->
    <section class="py-5 text-center bg-custom-color-4 about-what-we-do-section">
        <div class="container py-5">
            <div class="row mx-0">
                <div class="col-lg-8 mx-auto px-0">
                    <p class="about-section-subtitle text-uppercase mb-2 text-custom-color-1 fw-semibold ff-gill-sans-medium">{{ $cms['what_we_do']['title'] ?? 'What We Do' }}</p>
                    <h2 class="about-section-title ff-baskervville mb-4 text-custom-color-2">
                        {{ $cms['what_we_do']['subtitle'] ?? 'Let us be your eyes and ears' }}
                    </h2>
                    @if(!empty($cms['what_we_do']['content']))
                        <div class="about-text ff-gill-sans-light text-custom-color-1 mb-3">
                            {!! $cms['what_we_do']['content'] !!}
                        </div>
                    @else
                    <p class="about-text ff-gill-sans-light text-custom-color-1 mb-3">
                        What could be more frustrating than expecting to accept a completed project, clearly specified & designed only to find that it is riddled with hidden defects and problems that can sometimes take years to rectify?
                    </p>
                    <p class="about-text ff-gill-sans-light text-custom-color-1 mb-3">
                        Correcting hidden defects in a working building is expensive, disruptive and a major cause of dissatisfaction and complaints from the end user. Manufacturing production lines have hundreds of checks and quality control inspections during the manufacturing process in order to produce a “finished product” – doesn’t your investment deserve the same?
                    </p>
                    <p class="about-text ff-gill-sans-light text-custom-color-1 mb-3">
                        FCM’s Clerks of Works' role on site is to help you achieve an on-time and value for money, high-quality building that will be as free of defects as possible in order to keep future maintenance and downtime to a minimum.
                    </p>
                    <p class="about-text ff-gill-sans-light text-custom-color-1 mb-3 fw-bold">
                        Let us be your eyes and ears on site and get the building you deserve.
                    </p>
                    @endif

                    @if(!empty($cms['what_we_do']['items']) && count($cms['what_we_do']['items']) > 0)
                    <ul class="about-text list-unstyled text-start mx-auto text-custom-color-1" style="max-width: 650px;">
                        @foreach($cms['what_we_do']['items'] as $item)
                        <li class="mb-2 d-flex align-items-start"><i class="bi bi-check2-circle me-3 fs-4"></i> <span class="ff-gill-sans-light text-custom-color-1 pt-1">{{ $item['list_string'] ?? '' }}</span></li>
                        @endforeach
                    </ul>
                    @else
                    <ul class="about-text list-unstyled text-start mx-auto text-custom-color-1" style="max-width: 650px;">
                        <li class="mb-2 d-flex align-items-start"><i class="bi bi-check2-circle me-3 fs-4"></i> <span class="ff-gill-sans-light text-custom-color-1 pt-1">We ensure your works are installed to the highest possible standards</span></li>
                        <li class="mb-2 d-flex align-items-start"><i class="bi bi-check2-circle me-3 fs-4"></i> <span class="ff-gill-sans-light text-custom-color-1 pt-1">We have an experienced team of reliable effective professionals</span></li>
                        <li class="mb-2 d-flex align-items-start"><i class="bi bi-check2-circle me-3 fs-4"></i> <span class="ff-gill-sans-light text-custom-color-1 pt-1">Our Consultancy services are based on decades of experience</span></li>
                        <li class="mb-2 d-flex align-items-start"><i class="bi bi-check2-circle me-3 fs-4"></i> <span class="ff-gill-sans-light text-custom-color-1 pt-1">We have a working knowledge of health and safety legislation</span></li>
                        <li class="mb-2 d-flex align-items-start"><i class="bi bi-check2-circle me-3 fs-4"></i> <span class="ff-gill-sans-light text-custom-color-1 pt-1">We are familiar with legal requirements and make sure all work complies with them</span></li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Image Full Width -->
    <div class="about-full-img-container w-100">
        <img src="{{ !empty($cms['lower_break']['image']) ? asset('storage/' . $cms['lower_break']['image']) : asset('assets/images/about-3.webp') }}" class="w-100 h-100 object-fit-cover" alt="Services Design">
    </div>

    <!-- We Are Here To Help -->
    <section class="pt-5 bg-custom-color-4 about-help-section">
        <div class="container py-5 text-center" style="max-width: 900px;">
            <h2 class="about-section-title ff-baskervville mb-4 text-custom-color-2">{{ $cms['help_banner']['title'] ?? 'We Are Here to Help' }}</h2>
            @if(!empty($cms['help_banner']['content']))
                <div class="about-text ff-gill-sans-light text-custom-color-1 mb-0">
                    {!! $cms['help_banner']['content'] !!}
                </div>
            @else
            <p class="about-text ff-gill-sans-light text-custom-color-1 mb-0">
                FCM offers a breadth and depth of experience and expertise across many sectors, without passing on the overheads of extremely large consulting and recruitment companies. All our Clerks of Works are either Members of the Institute of Clerks of Works and Construction Inspectorate, MICWCI, or are qualified in their own specialist fields. To discuss how a Clerk of Works could benefit your project, call us on <strong>0207 323 5758</strong>, email us at <a href="mailto:info@fcmltd.co.uk" class="text-custom-color-1 text-decoration-none fw-bold">info@fcmltd.co.uk</a> or complete our enquiry form.
            </p>
            @endif
        </div>
    </section>

    <!-- Instagram Section -->
<section class="instagram-section pt-5 pb-0 bg-custom-color-4 text-center">
    <div class="container mb-5">
        <h6 class="sub-title text-uppercase text-custom-color-1 ff-gill-sans-medium mb-2">Follow Us</h6>
        <h2 class="section-title text-uppercase text-custom-color-2 ff-baskervville">Instagram</h2>
    </div>
    
    <div class="container-fluid p-0 overflow-hidden">
        <div class="marquee-wrapper">
            <div class="marquee-content">
                <div class="insta-item">
                    <img src="{{ asset('assets/images/projects/project-1.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 1">
                </div>
                <div class="insta-item">
                    <img src="{{ asset('assets/images/news/news-1.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 2">
                </div>
                <div class="insta-item">
                    <img src="{{ asset('assets/images/projects/project-3.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 3">
                </div>
                <div class="insta-item">
                    <img src="{{ asset('assets/images/news/news-2.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 4">
                </div>
                <div class="insta-item">
                    <img src="{{ asset('assets/images/projects/project-4.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 5">
                </div>
            </div>
            <!-- Duplicate content for seamless loop -->
            <div class="marquee-content" aria-hidden="true">
                <div class="insta-item">
                    <img src="{{ asset('assets/images/projects/project-1.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 1">
                </div>
                <div class="insta-item">
                    <img src="{{ asset('assets/images/news/news-1.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 2">
                </div>
                <div class="insta-item">
                    <img src="{{ asset('assets/images/projects/project-3.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 3">
                </div>
                <div class="insta-item">
                    <img src="{{ asset('assets/images/news/news-2.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 4">
                </div>
                <div class="insta-item">
                    <img src="{{ asset('assets/images/projects/project-4.webp') }}" class="w-100 h-100 object-fit-cover" alt="Instagram 5">
                </div>
            </div>
        </div>
    </div>
</section>
</main>

@endsection