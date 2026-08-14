@extends('frontend.layouts.master')

@section('title', __('common.services'))

@section('content')

<section class="subpage-header-banner">
    <div class="container text-center">
        <nav class="breadcrumb-enterprise mb-3" aria-label="breadcrumb">
            <a href="{{ route('home') }}">{!! render_svg_icon('house', 'me-1') !!} {{ __('common.home') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <span class="breadcrumb-active">{{ __('common.services') }}</span>
        </nav>
        <h1 class="subpage-title mb-3">{{ __('services.hero_title') }}</h1>
        <p class="lead text-secondary max-w-600 mx-auto mb-0" style="font-size:1.1rem;">{{ __('services.hero_subtitle') }}</p>
    </div>
</section>

<div class="py-5 mb-5">
    <div class="container">
        <div class="bento-grid">
            @foreach($services as $service)
                @if($loop->first)
                    
                    <div class="bento-col-8" data-reveal="up">
                        <div class="bento-card-light bento-card-hero-light h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="bento-icon-light mb-0">{!! render_svg_icon(data_get($service, 'icon') ?: 'layer-group', 'fs-2') !!}</div>
                                    <span class="agency-tag agency-tag-tkgm">{!! render_svg_icon('shield-halved', 'me-1') !!} TKGM 3402/22-a</span>
                                </div>
                                <h3 class="mb-3 text-dark">{{ data_get($service, 'title') }}</h3>
                                <p class="lead text-secondary mb-4">{{ data_get($service, 'summary') }}</p>
                            </div>
                            <div class="pt-4 border-top border-slate-200 d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <div>
                                    <small class="text-muted d-block">{{ __('services.scope_badge') }}</small>
                                    <span class="fw-bold text-primary">{{ __('services.scope_val') }}</span>
                                </div>
                                <a href="{{ route('services.detail', data_get($service, 'slug')) }}" class="btn-enterprise btn-enterprise-primary py-2 px-4 fs-6">
                                    {{ __('common.explore') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    
                    <div class="bento-col-4" data-reveal="up" data-delay="{{ $loop->iteration * 100 }}">
                        <div class="bento-card-light h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="bento-icon-light mb-0">{!! render_svg_icon(data_get($service, 'icon') ?: 'layer-group', 'fs-3') !!}</div>
                                    <span class="agency-tag agency-tag-nvi">{{ __('services.public_engineering') }}</span>
                                </div>
                                <h3 class="h4 mb-3 text-dark">{{ data_get($service, 'title') }}</h3>
                                <p class="text-secondary small mb-4">{{ data_get($service, 'summary') }}</p>
                            </div>
                            <a href="{{ route('services.detail', data_get($service, 'slug')) }}" class="btn-detail-enterprise">
                                {{ __('common.explore') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    @if(isset($faqs) && count($faqs) > 0)
    <section class="py-5 mb-0 bg-section-slate border-top mt-5">
        <div class="container max-w-900 mx-auto">
            <div class="text-center mb-5" data-reveal="up">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill font-mono mb-2">{{ __('services.faq_badge') }}</span>
                <h2 class="h2 font-heading fw-bold">{{ __('services.faq_title') }}</h2>
                <p class="text-secondary">{{ __('services.faq_subtitle') }}</p>
            </div>

            <div class="accordion-enterprise" data-reveal="up">
                @foreach($faqs as $faq)
                    <div class="accordion-item-enterprise {{ $loop->first ? 'active' : '' }}">
                        <div class="accordion-header-enterprise">
                            <span>{{ $faq->question }}</span>
                            <div class="accordion-icon-enterprise">{!! render_svg_icon('chevron-down') !!}</div>
                        </div>
                        <div class="accordion-body-enterprise" @if($loop->first) style="max-height: 250px;" @endif>
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>

@endsection
