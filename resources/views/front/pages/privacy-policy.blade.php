@extends('front.newLayout.protected')

@section('content')

<main>
    <!-- Hero Section -->
    <section class="about-hero d-flex align-items-end position-relative" @if(!empty($cms['hero']['image'])) style="background-image: url('{{ asset('storage/' . $cms['hero']['image']) }}');" @else style="background-image: url('assets/images/about-2.webp');" @endif>
        <div class="overlay"></div>
        <div class="container position-relative z-1">
            <h1 class="hero-title text-white ff-baskervville fw-normal mb-0">{{ $cms['hero']['title'] ?? 'Privacy Policy' }}</h1>
        </div>
    </section>
    
    <!-- Privacy Policy Content -->
    <section class="py-5 bg-custom-color-4">
        <div class="container py-5">
             <div class="row mx-0">
                <div class="col-lg-10 mx-auto px-0">
                    <div class="content ff-gill-sans-light text-custom-color-1">
                        @if(!empty($cms['content']['content']))
                            <h2 class="ff-baskervville mb-4 text-custom-color-2">{{ $cms['content']['title'] ?? 'Privacy Policy' }}</h2>
                            {!! $cms['content']['content'] !!}
                        @else
                        <h2 class="ff-baskervville mb-4 text-custom-color-2">Privacy Policy</h2>
                        <p class="mb-4">FCM has created this privacy statement in order to demonstrate our commitment to the privacy or our customers.</p>

                        <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">Collection of data and use of your personal information</h3>
                        <p class="mb-4">We use your data for the following: On the booking form, registration form, order forms and contact forms, we ask you to give us contact information, for example your name, personal details and e-mail address. With your permission, contact information may be used to supply information about our company and to send you occasional promotional material, such as information about special offers which we think you might find valuable. You may opt out of receiving future mailings; see the opt out section of this policy.</p>

                        <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">Non-disclosure to third parties</h3>
                        <p class="mb-4">Unless we have your express consent, we will not disclose your personal data to third parties. We will not sell, rent or trade your personal information to others for marketing purposes without your express consent. We may also provide aggregate statistics about our customers, sales, traffic patterns and related site information to reputable third parties but these statistics will include no personally identifying information.</p>

                        <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">Cookies</h3>
                        <p class="mb-4">Our site uses cookies to keep track of your visits to our website. A cookie is a small file that can be stored by your browser on your computer's hard drive. Cookies may be used to compile anonymous statistics related to the use of services or patterns of browsing. When used in this manner you are not individually identified and data collected in this manner is only used in aggregate. You can usually change your browser's settings so that it will not accept cookies, although this may restrict some website functionality.</p>

                        <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">Security of your information</h3>
                        <p class="mb-4">We follow strict security procedures in the storage and disclosure of information which you have given us. This is to prevent unauthorised access or unlawful processing of your personal information.</p>

                        <h3 class="ff-baskervville h5 mb-3 text-custom-color-2">Your consent</h3>
                        <p class="mb-0">By using our website you consent to the collection, storage and processing of your personal information by us in the manner set out in this privacy policy. Should we change our privacy policy, we will post the changes on this website so that you are always aware of what information we collect, how we use and under what circumstances we disclose it.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
