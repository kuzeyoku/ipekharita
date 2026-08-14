@extends('frontend.layouts.master')

@section('title', $service->title)
@section('meta_description', $service->meta_description)

@section('content')

<!-- Header Banner -->
<section class="subpage-header-banner">
    <div class="container text-center">
        <nav class="breadcrumb-enterprise mb-3" aria-label="breadcrumb">
            <a href="{{ route('home') }}">{!! render_svg_icon('house', 'me-1') !!} {{ __('common.home') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <a href="{{ route('services') }}">{{ __('common.services') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <span class="breadcrumb-active">{{ $service->title }}</span>
        </nav>
        <h1 class="subpage-title mb-3">{{ $service->title }}</h1>
        <p class="lead text-secondary max-w-600 mx-auto mb-0" style="font-size:1.1rem;">{{ $service->summary }}</p>
    </div>
</section>

<!-- Detail Content -->
<div class="py-5 mb-5">
    <div class="container">
        <div class="row g-5">
            <!-- Main Body -->
            <div class="col-lg-8" data-reveal="left">
                @if($service->image)
                    <div class="card-enterprise p-3 mb-4 bg-light border text-center">
                        <img src="{{ asset(str_starts_with($service->image, 'storage/') || str_starts_with($service->image, 'assets/') ? $service->image : 'storage/' . $service->image) }}" alt="{{ $service->title }}" class="img-fluid rounded-4" style="max-height: 420px; object-fit: contain;">
                    </div>
                @endif

                <div class="content-body text-secondary lead mb-4">
                    {!! $service->content !!}
                </div>

                <h3 class="h4 mt-5 mb-3">{{ __('services.application_areas') }}</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light border rounded-3 d-flex align-items-center gap-3">
                            {!! render_svg_icon('building', 'text-primary fs-3') !!}
                            <div>
                                <h6 class="mb-0">{{ __('services.app_area_1_title') }}</h6>
                                <small class="text-muted">{{ __('services.app_area_1_sub') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light border rounded-3 d-flex align-items-center gap-3">
                            {!! render_svg_icon('layer-group', 'text-primary fs-3') !!}
                            <div>
                                <h6 class="mb-0">{{ __('services.app_area_2_title') }}</h6>
                                <small class="text-muted">{{ __('services.app_area_2_sub') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light border rounded-3 d-flex align-items-center gap-3">
                            {!! render_svg_icon('route', 'text-primary fs-3') !!}
                            <div>
                                <h6 class="mb-0">{{ __('services.app_area_3_title') }}</h6>
                                <small class="text-muted">{{ __('services.app_area_3_sub') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light border rounded-3 d-flex align-items-center gap-3">
                            {!! render_svg_icon('shield-halved', 'text-primary fs-3') !!}
                            <div>
                                <h6 class="mb-0">{{ __('services.app_area_4_title') }}</h6>
                                <small class="text-muted">{{ __('services.app_area_4_sub') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                @if(isset($faqs) && count($faqs) > 0)
                <h3 class="h4 mt-5 mb-3">{{ __('services.faq_title') }}</h3>
                <div class="accordion" id="faqAccordion">
                    @foreach($faqs as $faq)
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="faq{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-secondary">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4" data-reveal="right">
                <div class="card-enterprise p-4 mb-4">
                    <h4 class="h5 mb-3">{{ __('common.other_services') }}</h4>
                    <ul class="list-unstyled mb-0">
                        @if(isset($otherServices))
                            @foreach($otherServices as $otherService)
                                @php
                                    $oId = is_object($otherService) ? $otherService->id : ($otherService['id'] ?? null);
                                    $oSlug = is_object($otherService) ? $otherService->slug : ($otherService['slug'] ?? '');
                                    $oTitle = is_object($otherService) ? $otherService->title : ($otherService['title'] ?? '');
                                @endphp
                                @if($oSlug)
                                    <li class="mb-2">
                                        <a href="{{ route('services.detail', $oSlug) }}" class="d-flex justify-content-between align-items-center p-2 rounded text-decoration-none {{ $oId === $service->id ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                                            <span class="fw-semibold">{{ $oTitle }}</span>
                                            {!! render_svg_icon('chevron-right', $oId === $service->id ? 'text-warning' : 'text-muted') !!}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="bg-primary text-white p-4 rounded-4 text-center" style="background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 100%);">
                    <div class="mb-3">{!! render_svg_icon('phone', 'text-warning fs-1') !!}</div>
                    <h4>{{ __('services.consult_title') }}</h4>
                    <p class="small text-white-50 mb-4">{{ __('services.consult_desc') }}</p>
                    <a href="{{ route('contact') }}" class="btn-enterprise btn-enterprise-primary bg-warning text-dark border-0 w-100 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                        {!! render_svg_icon('phone', 'me-1') !!} {{ __('services.call_now') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
