@extends('front.newLayout.protected')

@section('content')

<main>
    <!-- Hero Section -->
    <section class="about-hero d-flex align-items-end position-relative" @if(!empty($cms['hero']['image'])) style="background-image: url('{{ asset('storage/' . $cms['hero']['image']) }}');" @else style="background-image: url('assets/images/about-2.webp');" @endif>
        <div class="overlay"></div>
        <div class="container position-relative z-1">
            <h1 class="hero-title text-white ff-baskervville fw-normal mb-0">{{ $cms['hero']['title'] ?? 'Terms of Use' }}</h1>
        </div>
    </section>
    
    <!-- Terms of Use Content -->
    <section class="py-5 bg-custom-color-4">
        <div class="container py-5">
             <div class="row mx-0">
                <div class="col-lg-10 mx-auto px-0">
                    <div class="content ff-gill-sans-light text-custom-color-1">
                        @if(!empty($cms['content']['content']))
                            <h2 class="ff-baskervville mb-4 text-custom-color-2">{{ $cms['content']['title'] ?? 'Terms and Conditions' }}</h2>
                            {!! $cms['content']['content'] !!}
                        @else
                            <h2 class="ff-baskervville mb-4 text-custom-color-2">Terms and Conditions</h2>
                            <p class="mb-4">Welcome to FCM. These terms and conditions outline the rules and regulations for the use of our website and services.</p>

                            <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">1. Acceptance of Terms</h3>
                            <p class="mb-4">By accessing this website we assume you accept these terms and conditions. Do not continue to use FCM if you do not agree to take all of the terms and conditions stated on this page.</p>

                            <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">2. License</h3>
                            <p class="mb-4">Unless otherwise stated, FCM and/or its licensors own the intellectual property rights for all material on FCM. All intellectual property rights are reserved. You may access this from FCM for your own personal use subjected to restrictions set in these terms and conditions.</p>

                            <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">3. User Responsibilities</h3>
                            <p class="mb-4">You must not republish material from FCM, sell, rent or sub-license material from FCM, reproduce, duplicate or copy material from FCM, or redistribute content from FCM without written consent.</p>

                            <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">4. Disclaimer</h3>
                            <p class="mb-4">To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website. Nothing in this disclaimer will limit or exclude our or your liability for death or personal injury, limit or exclude our or your liability for fraud or fraudulent misrepresentation, or limit any of our or your liabilities in any way that is not permitted under applicable law.</p>

                            <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">5. Changes to Terms</h3>
                            <p class="mb-0">We reserve the right to revise these terms and conditions at any time. By using this website you are expected to review these terms on a regular basis.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

