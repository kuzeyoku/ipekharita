<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')@yield('title') — @endif @setting('site_title')</title>
    <meta name="description" content="@yield('meta_description', setting('site_description'))">
    <meta name="keywords" content="@yield('meta_keywords', setting('site_keywords'))">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/hero/icon.png') }}">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="@setting('site_title')">
    <meta property="og:title" content="@hasSection('title')@yield('title') — @endif @setting('site_title')">
    <meta property="og:description" content="@yield('meta_description', setting('site_description'))">
    <meta property="og:image" content="@yield('meta_image', asset('assets/img/hero/slide-2.png'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@hasSection('title')@yield('title') — @endif @setting('site_title')">
    <meta name="twitter:description" content="@yield('meta_description', setting('site_description'))">
    <meta name="twitter:image" content="@yield('meta_image', asset('assets/img/hero/slide-2.png'))">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- FontAwesome 6 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    <!-- Custom Enterprise CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/home.css') }}">

    @stack('styles')
</head>
<body>

    <!-- Header Partial -->
    @include('frontend.partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')

        @hasSection('hide_cta')
        @else
            @include('frontend.partials.cta')
        @endif
    </main>

    <!-- Footer Partial -->
    @include('frontend.partials.footer')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom Theme JS Scripts -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/animations.js') }}"></script>
    <script src="{{ asset('assets/js/tin-mesh.js') }}"></script>

    @stack('scripts')
</body>
</html>
