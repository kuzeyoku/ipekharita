<title>@hasSection('title')@yield('title') — @endif{{ setting('site_title', 'İpek Harita Mühendislik A.Ş.') }}</title>
<meta name="description" content="@yield('meta_description', setting('site_description', 'Büyük ölçekli 22/a kadastro yenileme, fotogrametrik haritalama, 3D CBS ve LiDAR mühendislik çözümleri.'))">
<meta name="keywords" content="@yield('meta_keywords', setting('site_keywords', 'kadastro yenileme, 22a kadastro, oblik fotogrametri, lidar harita, 3d cbs, ipek harita'))">
<meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
<link rel="canonical" href="{{ url()->current() }}">
<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/hero/icon.png') }}">

@php
    $hreflangTags = app(\App\Services\SeoService::class)->generateHreflangTags();
@endphp
@foreach($hreflangTags as $locale => $href)
<link rel="alternate" hreflang="{{ $locale }}" href="{{ $href }}" />
@endforeach

<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="{{ setting('company_name', setting('site_title', 'İpek Harita')) }}">
<meta property="og:title" content="@hasSection('title')@yield('title') — @endif{{ setting('site_title', 'İpek Harita') }}">
<meta property="og:description" content="@yield('meta_description', setting('site_description', 'Büyük ölçekli 22/a kadastro yenileme, fotogrametri ve LiDAR çözümleri.'))">
<meta property="og:image" content="@yield('meta_image', asset('assets/img/hero/slide-2.png'))">
<meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@hasSection('title')@yield('title') — @endif{{ setting('site_title', 'İpek Harita') }}">
<meta name="twitter:description" content="@yield('meta_description', setting('site_description', 'Büyük ölçekli 22/a kadastro yenileme, fotogrametri ve LiDAR çözümleri.'))">
<meta name="twitter:image" content="@yield('meta_image', asset('assets/img/hero/slide-2.png'))">

<script type="application/ld+json">
{!! json_encode(app(\App\Services\SeoService::class)->generateOrganizationSchema(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@stack('schema')
