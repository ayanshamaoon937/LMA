@extends('front.newLayout.protected')

@section('content')
<main>
    <!-- Hero Banner: dynamic per category -->
    <section class="d-flex w-100 flex-wrap flex-md-nowrap projects-hero-section">
        @foreach ($categories->take(2) as $category)
            <div class="position-relative overflow-hidden hero-banner-wrapper projects-hero-col">
                <img src="{{ $category->hero_image ? asset('storage/'.$category->hero_image) : asset('assets/images/residential-hero.webp') }}"
                     class="hero-banner-img" alt="{{ $category->name }} Hero">
                <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 hero-overlay"></div>
                <div class="position-absolute bottom-0 start-0 p-4 text-white">
                    <h3 class="ff-baskervville mb-0 hero-banner-title">{{ $category->name }}</h3>
                    <p class="ff-gill-sans-light mb-0 hero-banner-subtitle">View Projects</p>
                </div>
                <a href="#" class="stretched-link hero-filter-trigger" data-filter="{{ $category->slug }}"></a>
            </div>
        @endforeach
    </section>

    <!-- Filters -->
    <section id="filters-section" class="py-4 text-center">
        <div class="container">
            <div class="fw-semibold d-flex ff-gill-sans-medium justify-content-center align-items-center gap-4 flex-wrap">
                @foreach ($categories as $category)
                    <a href="#"
                       class="filter-btn text-decoration-none ff-gill-sans-medium fw-semibold h5 pt-1 mb-0 {{ $activeCategory === $category->slug ? 'active' : '' }}"
                       data-filter="{{ $category->slug }}">
                        {{ strtoupper($category->name) }}
                    </a>
                    @if (! $loop->last)
                        <div class="vr" style="background-color: var(--custom-color-1); width: 2px; height: 1.5rem;"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Title / Description -->
    <section class="py-5 projects-title-section">
        <div class="container px-md-5">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h1 class="ff-baskervville mb-3 projects-main-title text-custom-color-2" id="section-title">
                        {{ $selectedCategory ? strtoupper($selectedCategory->name) : 'ALL PROJECTS' }}
                    </h1>
                    <p class="ff-gill-sans-medium fw-semibold text-custom-color-1 projects-main-subtitle" id="section-subtitle">
                        {!! $selectedCategory?->hero_subtitle ??  $intro['title'] !!}
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="ff-gill-sans-light text-start text-md-end mb-4 projects-description text-custom-color-1" id="section-desc">
                        {!! $selectedCategory?->hero_description ?? $intro['content'] !!}
                    </p>
                    <div class="btn-wrapper d-inline-block" id="all-projects-wrapper" style="{{ $activeCategory ? '' : 'display:none;' }}">
                        <a href="#" id="reset-filter-btn" class="btn-primary btn text-white text-decoration-none ff-gill-sans">
                            {{ $intro['button_text'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Grid -->
    <section class="pb-5 projects-grid-section">
        <div class="container-fluid px-0 overflow-hidden">

            <div id="no-records" class="text-center py-5" style="{{ $totalCount > 0 ? 'display:none;' : '' }}">
                <p class="ff-gill-sans-medium fw-semibold h5 mb-0">{{ $listing['no_records_text'] }}</p>
            </div>

            <div class="row g-3" id="projects-grid">
                @include('front.pages.partials.project-cards', ['projects' => $projects, 'projectCard' => $projectCard])
            </div>

            <!-- <div class="text-center mt-4" id="load-more-wrapper" style="{{ $hasMore ? '' : 'display:none;' }}">
                <button type="button" id="load-more-btn" class="btn-primary btn text-white text-decoration-none ff-gill-sans">
                    <span id="load-more-label">{{ $listing['load_more_text'] }}</span>
                </button>
            </div> -->

              <div class="text-center mt-5 pb-5 pt-3" id="load-more-wrapper"
                 style="{{ $hasMore ? '' : 'display:none;' }}">
                <button type="button" id="load-more-btn"
                        class="btn btn-outline-primary">
                    Load More
                </button>
            </div>
            <!-- <span id="load-more-label">{{ $listing['load_more_text'] }}</span> -->

            <!-- <div id="grid-loading" class="text-center py-4" style="display:none;">
                <span class="ff-gill-sans-light">Loading...</span>
            </div> -->
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const grid          = document.getElementById('projects-grid');
    const noRecords      = document.getElementById('no-records');
    const loadMoreWrap    = document.getElementById('load-more-wrapper');
    const loadMoreBtn     = document.getElementById('load-more-btn');
    const gridLoading     = document.getElementById('grid-loading');
    const allProjectsWrap = document.getElementById('all-projects-wrapper');
    const sectionTitle    = document.getElementById('section-title');
    const sectionSubtitle = document.getElementById('section-subtitle');
    const sectionDesc     = document.getElementById('section-desc');

    const filterUrl = @json(route('ajax.projects.filter'));
    const pageUrl   = @json(route('page.projects'));

    let currentCategory = @json($activeCategory);
    let currentOffset   = {{ $projects->count() }};
    let isLoading       = false;

    function setActiveButton(slug) {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.filter === slug);
        });
    }

    function toggleLoading(show) {
        isLoading = show;
        // gridLoading.style.display = show ? '' : 'none';
        loadMoreBtn.disabled = show;

        const originalText = loadMoreBtn.textContent;
        if(show){
            loadMoreBtn.textContent = 'Loading...';
        }   
        else{
            loadMoreBtn.textContent = 'Load More';
        }



    }

    async function fetchProjects(category, offset, append = false) {
        toggleLoading(true);

        try {
            const params = new URLSearchParams();
            if (category) params.set('category', category);
            params.set('offset', offset);

            const res = await fetch(`${filterUrl}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            });

            if (!res.ok) throw new Error('Request failed');
            const data = await res.json();

            if (append) {
                grid.insertAdjacentHTML('beforeend', data.html);
            } else {
                grid.innerHTML = data.html;
            }

            noRecords.style.display = data.isEmpty ? '' : 'none';
            grid.style.display = data.isEmpty ? 'none' : '';
            loadMoreWrap.style.display = data.hasMore ? '' : 'none';

            currentOffset = data.nextOffset;

            if (!append) {
                sectionTitle.textContent = data.title;
                if (data.subtitle) sectionSubtitle.innerHTML = data.subtitle;
                if (data.description) sectionDesc.innerHTML = data.description;
                allProjectsWrap.style.display = category ? '' : 'none';

                // keep the URL shareable/bookmarkable without reloading
                const url = new URL(pageUrl);
                if (category) url.searchParams.set('category', category);
                window.history.replaceState({}, '', url);
            }
        } catch (e) {
            console.error(e);
        } finally {
            toggleLoading(false);
             loadMoreBtn.textContent = 'Load More';
        }
    }

    function applyFilter(slug) {
        currentCategory = currentCategory === slug ? null : slug;
        currentOffset = 0;
        setActiveButton(currentCategory);
        fetchProjects(currentCategory, 0, false);
        document.getElementById('filters-section').scrollIntoView({ behavior: 'smooth' });
    }

    document.querySelectorAll('.filter-btn, .hero-filter-trigger').forEach(el => {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            if (isLoading) return;
            applyFilter(this.dataset.filter);
        });
    });

    document.getElementById('reset-filter-btn').addEventListener('click', function (e) {
        e.preventDefault();
        if (isLoading) return;
        currentCategory = null;
        currentOffset = 0;
        setActiveButton(null);
        fetchProjects(null, 0, false);
    });

    loadMoreBtn.addEventListener('click', function () {
        if (isLoading) return;
        fetchProjects(currentCategory, currentOffset, true);
    });
});
</script>
@endpush