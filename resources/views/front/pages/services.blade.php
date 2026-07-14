@extends('front.newLayout.protected')

@section('content')
<main class="services-main-bg">
    <section class="position-relative d-flex align-items-end services-hero-section">
        <img src="{{ !empty($cms['hero']['image']) ? asset('storage/' . $cms['hero']['image']) : asset('assets/images/services-hero.webp') }}"
             class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Our Services">
        <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 services-hero-overlay"></div>
        <div class="container position-relative z-1 mb-5">
            <h1 class="text-white ff-baskervville mb-0 services-hero-title hero-title">{{ $cms['hero']['title'] ?? 'Our Services' }}</h1>
        </div>
    </section>

    <section class="py-5 bg-custom-color-4 services-container-section">
        <div class="container py-5">

            {{-- ONLY service blocks live in here — this is what gets appended to --}}
            <div id="services-list">
                @forelse($services as $index => $service)
                    @include('front.partials.service-block')
                @empty
                    <div class="text-center py-5" id="services-empty">
                        <p class="ff-gill-sans-light text-muted">No services available yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- Button lives OUTSIDE the list, as a separate sibling --}}
            <div class="text-center mt-5" id="services-load-more-container"
                 style="{{ $services->hasMorePages() ? '' : 'display:none;' }}">
                <button type="button" id="services-load-more"
                        class="btn btn-outline-primary"
                        data-next-page="{{ $services->currentPage() + 1 }}"
                        data-endpoint="{{ route('page.services.load-more') }}">
                    Load More
                </button>
            </div>

        </div>
    </section>
</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/load-more.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        initLoadMore({
            buttonId: 'services-load-more',
            containerId: 'services-list', // <-- points at the list only, not the button wrapper
            wrapperId: 'services-load-more-container',
            onAppend: function () {
                if (typeof AOS !== 'undefined') AOS.refresh();
            },
        });
    });
</script>
@endpush