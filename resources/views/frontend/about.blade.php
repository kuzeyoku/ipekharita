@extends('frontend.layouts.master')

@section('title', __('common.corporate'))

@section('content')

<!-- Header Banner -->
<section class="subpage-header-banner">
    <div class="container text-center">
        <nav class="breadcrumb-enterprise mb-3" aria-label="breadcrumb">
            <a href="{{ route('home') }}">{!! render_svg_icon('house', 'me-1') !!} {{ __('common.home') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <span class="breadcrumb-active">{{ __('common.corporate') }}</span>
        </nav>
        <h1 class="subpage-title mb-3">{{ __('about.hero_title') }}</h1>
        <p class="lead text-secondary max-w-600 mx-auto mb-0" style="font-size:1.1rem;">{{ __('about.hero_subtitle') }}</p>
    </div>
</section>

<div class="py-5 mb-5">
    <div class="container">
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6" data-reveal="left">
                <div class="card-enterprise p-2 overflow-hidden shadow-lg">
                    <img src="{{ asset('assets/img/hero/slide-1.png') }}" alt="@setting('brand_name')" class="img-fluid rounded-4">
                </div>
            </div>
            <div class="col-lg-6" data-reveal="right">
                <h2 class="mb-4">{{ __('about.section_title') }}</h2>
                <p class="text-secondary lead"><strong>@setting('company_name')</strong>; {{ __('about.desc_p1') }}</p>
                <p class="text-secondary">{{ __('about.desc_p2') }}</p>

                <div class="d-flex flex-wrap gap-2 my-4">
                    <span class="agency-tag agency-tag-tkgm">TKGM 22/a KADASTRO</span>
                    <span class="agency-tag agency-tag-kgm">KGM / TCDD KORİDOR</span>
                    <span class="agency-tag agency-tag-dsi">DSİ KAMULAŞTIRMA</span>
                    <span class="agency-tag agency-tag-ogm">OGM 2/B KADASTRO</span>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="d-block font-heading fw-bold h4 text-primary mb-1">{{ __('about.stat_1_val') }}</span>
                            <small class="text-muted fw-semibold">{{ __('about.stat_1_lbl') }}</small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="d-block font-heading fw-bold h4 text-warning mb-1">{{ __('about.stat_2_val') }}</span>
                            <small class="text-muted fw-semibold">{{ __('about.stat_2_lbl') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vision & Mission -->
        <div class="bento-grid mb-5">
            <div class="bento-col-6" data-reveal="up">
                <div class="bento-card-light h-100">
                    <div class="bento-icon-light">{!! render_svg_icon('shield-halved', 'fs-3') !!}</div>
                    <h3 class="h4 mb-3 text-dark">{{ __('about.vision_title') }}</h3>
                    <p class="text-secondary mb-0">{{ __('about.vision_desc') }}</p>
                </div>
            </div>
            <div class="bento-col-6" data-reveal="up" data-delay="100">
                <div class="bento-card-light h-100">
                    <div class="bento-icon-light">{!! render_svg_icon('building', 'fs-3') !!}</div>
                    <h3 class="h4 mb-3 text-dark">{{ __('about.mission_title') }}</h3>
                    <p class="text-secondary mb-0">{{ __('about.mission_desc') }}</p>
                </div>
            </div>
        </div>

        <!-- ── YÜKSEK TEKNOLOJİ HARİTA ENVANTERİ & EKİPMAN STACK ── -->
        <div class="my-5 pt-5 border-top">
            <div class="text-center max-w-700 mx-auto mb-5" data-reveal="up">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill font-mono mb-2">{!! render_svg_icon('layer-group', 'me-1') !!} {{ __('about.inventory_badge') }}</span>
                <h2 class="h2 font-heading fw-bold">{{ __('about.inventory_title') }}</h2>
                <p class="text-secondary">{{ __('about.inventory_subtitle') }}</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-3" data-reveal="up" data-delay="100">
                    <div class="equip-card-enterprise">
                        <div class="equip-icon-box">{!! render_svg_icon('plane', 'fs-3 text-primary') !!}</div>
                        <h4 class="h5 mb-2 font-heading">{{ __('about.equip_1_title') }}</h4>
                        <p class="small text-secondary mb-3">{{ __('about.equip_1_desc') }}</p>
                        <span class="tech-badge-enterprise">{!! render_svg_icon('check', 'me-1') !!} {{ __('about.equip_1_badge') }}</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-reveal="up" data-delay="200">
                    <div class="equip-card-enterprise">
                        <div class="equip-icon-box">{!! render_svg_icon('building', 'fs-3 text-primary') !!}</div>
                        <h4 class="h5 mb-2 font-heading">{{ __('about.equip_2_title') }}</h4>
                        <p class="small text-secondary mb-3">{{ __('about.equip_2_desc') }}</p>
                        <span class="tech-badge-enterprise">{!! render_svg_icon('check', 'me-1') !!} {{ __('about.equip_2_badge') }}</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-reveal="up" data-delay="300">
                    <div class="equip-card-enterprise">
                        <div class="equip-icon-box">{!! render_svg_icon('route', 'fs-3 text-primary') !!}</div>
                        <h4 class="h5 mb-2 font-heading">{{ __('about.equip_3_title') }}</h4>
                        <p class="small text-secondary mb-3">{{ __('about.equip_3_desc') }}</p>
                        <span class="tech-badge-enterprise">{!! render_svg_icon('check', 'me-1') !!} {{ __('about.equip_3_badge') }}</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-reveal="up" data-delay="400">
                    <div class="equip-card-enterprise">
                        <div class="equip-icon-box">{!! render_svg_icon('file-contract', 'fs-3 text-primary') !!}</div>
                        <h4 class="h5 mb-2 font-heading">{{ __('about.equip_4_title') }}</h4>
                        <p class="small text-secondary mb-3">{{ __('about.equip_4_desc') }}</p>
                        <span class="tech-badge-enterprise">{!! render_svg_icon('check', 'me-1') !!} {{ __('about.equip_4_badge') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
