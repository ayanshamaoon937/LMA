<!-- <div> -->

@php
    use App\Helper\Helper;
@endphp

<title>{!! Str::limit(strip_tags(trim(Helper::getCleanText($title))), 70) !!}</title>
<meta name="description" content="{!! Str::limit(strip_tags(trim(Helper::getCleanText($description))), 160) !!}" />
<meta name="keywords" content="{!! is_array($keywords) ? implode(', ', Helper::getCleanText($keywords)) : Helper::getCleanText($keywords) !!}" />
<meta name="author" content="{{ $author }}" />

<!-- Open Graph / Facebook -->
<meta property="og:title" content="{!! Str::limit(strip_tags(trim(Helper::getCleanText($ogTitle ?? $title))), 70) !!}" />
<meta property="og:description" content="{!! Str::limit(strip_tags(trim(Helper::getCleanText($ogDescription ?? $description))), 160) !!}" />
<meta property="og:image" content="{{ $image }}" />
<meta property="og:url" content="{{ $url }}" />
<meta property="og:type" content="website" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{!! Str::limit(strip_tags(trim(Helper::getCleanText($ogTitle ?? Helper::getCleanText($title)))), 70) !!}" />
<meta name="twitter:description" content="{!! Str::limit(
    strip_tags(trim(Helper::getCleanText($ogDescription ?? Helper::getCleanText($description)))),
    160,
) !!}" />
<meta name="twitter:image" content="{{ $image }}" />


@if ($canonical_url)
   <link rel="canonical" href="{{ $canonical_url }}" />
@endif


@if ($meta_robot)
    <meta name="robots" content="{{ $meta_robot }}" />
@endif


<!-- </div> -->
