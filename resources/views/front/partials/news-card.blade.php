<div class="col-lg-6 mb-4">
    <a href="{{ route('page.news-detail', ['slug' => $article->slug]) }}" class="text-decoration-none d-block blog-thumb h-100">
        <div class="card border-0 h-100 bg-transparent">
            <div class="overflow-hidden news-card-img-wrapper">
                <img src="{{ !empty($article->image) ? asset('storage/' . $article->image) : asset('assets/images/news/news-1.webp') }}" class="w-100 h-100 news-card-img" alt="{{ $article->title }}">
            </div>
            <div class="card-body pt-4">
                <p class="ff-gill-sans-light text-muted mb-2 news-card-date">{{ $article->published_at ? $article->published_at->format('F d, Y') : $article->created_at->format('F d, Y') }}</p>
                <h3 class="card-title ff-baskervville text-custom-color-2 mb-0 news-card-title">{{ $article->title }}</h3>
            </div>
        </div>
    </a>
</div>
