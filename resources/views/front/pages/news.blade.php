@extends('front.newLayout.protected')

@section('content')
<main class="news-main-bg">
    <section class="position-relative d-flex align-items-end news-hero-section">
        <img src="{{ !empty($cms['hero']['image']) ? asset('storage/' . $cms['hero']['image']) : asset('assets/images/blog-hero.webp') }}"
             class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="{{ $cms['hero']['title'] ?? 'News' }}">
        <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 news-hero-overlay"></div>
        <div class="container position-relative z-1 mb-4">
            <h1 class="text-white ff-baskervville mb-1 news-hero-title hero-title">{{ $cms['hero']['title'] ?? 'News' }}</h1>
            <p class="text-white ff-gill-sans-light mb-0 news-hero-subtitle hero-subtitle">{{ $cms['hero']['subtitle'] ?? 'An inside look at our world' }}</p>
        </div>
    </section>

    <section class="pt-5 news-grid-section">
        <div class="container-fluid px-0">
            <div class="row g-4 justify-content-center" id="news-grid">
                @forelse($articles as $article)
                    @include('front.partials.news-card')
                @empty
                    <div class="col-12 text-center py-5" id="news-empty">
                        <p class="ff-gill-sans-light text-muted">
                            @if($search)
                                No news articles found for "{{ $search }}".
                            @else
                                No news articles available yet.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-5 pb-5 pt-3" id="news-load-more-container"
                 style="{{ $articles->hasMorePages() ? '' : 'display:none;' }}">
                <button type="button" id="news-load-more"
                        class="btn btn-outline-primary"
                        data-next-page="{{ $articles->currentPage() + 1 }}"
                         data-search="{{ $search }}"
                        data-endpoint="{{ route('page.news.load-more') }}">
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
            buttonId: 'news-load-more',
            containerId: 'news-grid',
            wrapperId: 'news-load-more-container',
        });
    });
</script>
@endpush