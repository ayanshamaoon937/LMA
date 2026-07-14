<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="canonical" href="{{ url()->current() }}" />
    @include('front.newLayout.headLinks')

    @yield('header')

    @if (trim(View::yieldContent('meta')))
        @yield('meta')
    @else
    @include('front.components.seo-meta')
    @endif



    {{-- BreadcrumbList Schema --}}
    @if (View::hasSection('breadcrumb'))
        @yield('breadcrumb')
    @endif



</head>

<body>

    @if(get_setting('google_no_script_tag_manager_link'))
        {!! get_setting('google_no_script_tag_manager_link') !!}
    @endif

    @if(Route::is('page.index'))
    @else
        @include('front.newLayout.header')
    @endif


    @yield('content')
    @include('front.newLayout.footer')
    @include('front.newLayout.scripts')

</body>

</html>