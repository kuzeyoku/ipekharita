@extends('frontend.layouts.master')

@section('title', __('common.projects'))

@section('content')

<!-- Header Banner -->
<section class="subpage-header-banner">
    <div class="container text-center">
        <nav class="breadcrumb-enterprise mb-3" aria-label="breadcrumb">
            <a href="{{ route('home') }}">{!! render_svg_icon('house', 'me-1') !!} {{ __('common.home') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <span class="breadcrumb-active">{{ __('common.projects') }}</span>
        </nav>
        <h1 class="subpage-title mb-3">{{ __('projects.hero_title') }}</h1>
        <p class="lead text-secondary max-w-600 mx-auto mb-0" style="font-size:1.1rem;">{{ __('projects.hero_subtitle') }}</p>
    </div>
</section>

<!-- Projects Portfolio Section -->
<div class="py-5 mb-5">
    <div class="container">
        
        <!-- Category Filters -->
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-5" data-reveal="up">
            <a href="{{ route('projects') }}" class="btn btn-sm {{ !$selectedCatSlug ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }} rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-1">
                {!! render_svg_icon('layer-group', 'me-1') !!} {{ __('projects.all_categories') }}
            </a>
            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $catItem)
                    <a href="{{ route('projects', ['category' => $catItem->slug]) }}" class="btn btn-sm {{ $selectedCatSlug == $catItem->slug ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }} rounded-pill px-4 py-2 fw-semibold">
                        {{ $catItem->title }}
                    </a>
                @endforeach
            @endif
        </div>

        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-md-6 col-lg-4" data-reveal="up">
                    <div class="card-enterprise h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="position-relative overflow-hidden p-2 bg-light border-bottom" style="height:240px;">
                                @if(data_get($project, 'image'))
                                    <img src="{{ asset('storage/' . data_get($project, 'image')) }}" alt="{{ data_get($project, 'title') }}" class="w-100 h-100 object-fit-contain">
                                @else
                                    <img src="{{ asset('assets/img/vector/clean-cadastre.png') }}" alt="{{ data_get($project, 'title') }}" class="w-100 h-100 object-fit-contain">
                                @endif
                                <span class="badge bg-primary text-white position-absolute top-0 start-0 m-3 px-3 py-2 font-mono">
                                    {{ strtoupper(data_get($project, 'categoryRel.title') ?: (data_get($project, 'category') ?: 'KAMU PROJESİ')) }}
                                </span>
                            </div>
                            <div class="p-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="tech-badge-enterprise">{!! render_svg_icon('shield-halved', 'me-1') !!} {{ data_get($project, 'client') ?: 'Kamu İdaresi' }}</span>
                                    <span class="badge-pulse-green"><span class="pulse-dot-green"></span> {{ data_get($project, 'is_completed') ? 'TESLİM EDİLDİ' : 'SAHA ÇALIŞMASI' }}</span>
                                </div>
                                <h4 class="h5 mb-2 text-dark fw-bold">{{ data_get($project, 'title') }}</h4>
                                <p class="small text-muted mb-3">{!! render_svg_icon('location-dot', 'me-1 text-primary') !!} {{ data_get($project, 'location') ?: 'Türkiye' }}</p>
                                <p class="text-secondary small mb-3">{{ Str::limit(data_get($project, 'summary'), 100) }}</p>
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <a href="{{ route('projects.detail', data_get($project, 'slug')) }}" class="btn-detail-enterprise w-100 justify-content-center">{{ __('projects.project_details') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <div class="mb-3 opacity-50">{!! render_svg_icon('route', 'fs-1 text-secondary') !!}</div>
                    {{ __('projects.no_projects_in_category') ?? 'Bu kategoride henüz kayıtlı bir proje bulunmuyor.' }}
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- ── REFERENCES SHOWCASE ───────────────────────────── -->
@include('frontend.partials.references_showcase')

@endsection
