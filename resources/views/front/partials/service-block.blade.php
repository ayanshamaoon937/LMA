@php $isReverse = $index % 2 !== 0; @endphp
<div class="row align-items-center mb-5 pb-5 {{ $isReverse ? 'flex-md-row-reverse' : '' }} service-block-row">
    <div class="col-md-6 mb-4 mb-md-0">
        <img src="{{ !empty($service->image) ? asset('storage/' . $service->image) : asset('assets/images/clerks-works.webp') }}" class="w-100 shadow-sm service-block-img" alt="{{ $service->title }}">
    </div>
    <div class="col-md-6 text-center px-md-5">
        <h2 class="ff-baskervville mb-3 text-custom-color-2 service-block-title">{{ $service->title }}</h2>
        @if(!empty($service->content))
            <div class="ff-gill-sans-light mb-5 text-start service-block-text">
               {!! Str::words(strip_tags($service->content), 50, '...') !!}
            </div>
        @endif
        <div class="btn-wrapper d-inline-block">
            <a href="{{ route('page.service-detail', ['slug' => $service->slug]) }}" class="btn btn-primary d-inline-block text-white text-decoration-none ff-gill-sans btn-service-more">{{ $cms['hero']['button_text'] ?? 'SEE MORE' }}</a>
        </div>
    </div>
</div>
