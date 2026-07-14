<div class="col-lg-12">
    @if ($blogs->count() > 0)
        <div class="parent">
            @forelse ($blogs as $blog)
                <div class="div{{ $loop->iteration }}">
                    <a href="{{ route('front.blog.show', ['slug' => $blog->slug]) }}">
                        <div class="blog-card position-relative">
                            <div class="position-absolute top-0 rounded-3 bottom-0 end-0 start-0 overlay">
                            </div>
                            {{-- <div class="position-absolute coming-soon bg-dark-100 rounded-end-2 py-1 px-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <img class="rounded-1"
                                            src="{{ asset('assets/images/icons/color-watch.svg') }}" alt="color-watch">
                                        <span class="small  l-1 ff-mont text-white">Coming Soon</span>
                                    </div>
                                </div> --}}

                            <img src="{{ Storage::url($blog->featured_image) }}"
                                class="rounded-3 object-fit-cover img-fluid w-100 main-img" alt="{{ $blog->title ?? 'blog-image' }}">
                            <div class="content position-absolute pb-3">
                                <span
                                    class="d-inline-block bg-secondary text-white fw-medium small ff-mont l-1 rounded-1 px-2 py-1">{{ optional($blog->published_at ?? $blog->created_at)?->format('F d, Y') ?? '-' }}</span>
                                <h6 class="fw-medium ff-mont text-white l-1 mt-2">{{ $blog->title }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
            @endforelse
        </div>
    @else
        <div class="col-md-12 col-lg-12 mb-3 alert-style">
            {{-- <div class="alert-style text-center"> --}}
            No Blogs Found
            {{-- <h5 class="ff-mont fw-semibold l-1 alert-style"></h5> --}}
        </div>
    @endif
</div>
