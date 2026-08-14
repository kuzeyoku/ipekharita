@extends('frontend.layouts.master')

@section('content')

<section class="hero-enterprise bg-wireframe-animated position-relative overflow-hidden">
    
    <canvas id="tinMeshCanvas" class="tin-mesh-canvas"></canvas>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">

            <div class="col-lg-7" data-reveal="left">
                <div class="corporate-badge mb-3">
                    <span class="pulse-dot"></span> {{ __('home.hero_badge') }}
                </div>
                <h1 class="mb-4">
                    {!! __('home.hero_title') !!}
                </h1>
                <p class="lead text-secondary mb-4">
                    {!! __('home.hero_subtitle') !!}
                </p>
                
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="{{ route('services') }}" class="btn-enterprise btn-enterprise-primary">
                        {!! render_svg_icon('layer-group', 'me-1') !!} {{ __('home.btn_services') }}
                    </a>
                    <a href="{{ route('projects') }}" class="btn-enterprise btn-enterprise-outline">
                        {!! render_svg_icon('building', 'me-1') !!} {{ __('home.btn_projects') }}
                    </a>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2 pt-3 border-top border-slate-200">
                    <span class="small text-muted fw-bold me-2">{{ __('home.compliance_badge') }}</span>
                    <span class="agency-tag agency-tag-tkgm">TKGM 22/a</span>
                    <span class="agency-tag agency-tag-kgm">KGM / TCDD</span>
                    <span class="agency-tag agency-tag-dsi">DSİ 2942</span>
                    <span class="agency-tag agency-tag-ogm">OGM 2/B</span>
                    <span class="agency-tag agency-tag-nvi">NVİ MAKS</span>
                </div>
            </div>

            <div class="col-lg-5" data-reveal="right">
                <div class="hero-track-record-card">
                    <div class="position-relative rounded-4 overflow-hidden mb-4 p-2 bg-light border" style="height: 300px;">
                        <img src="{{ asset('assets/img/hero/slide-2.png') }}" alt="Cadastral and Oblique Mapping" class="w-100 h-100 object-fit-contain rounded-3">
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <span class="badge bg-dark bg-opacity-75 text-white px-3 py-2 fs-6 rounded-pill">{!! render_svg_icon('plane', 'text-info me-2') !!} {{ __('home.aerial_badge') }}</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="h3 font-heading fw-bold text-primary mb-1" data-counter="{{ __('home.stat_1_val') }}">0</div>
                                <div class="small fw-semibold text-secondary">{{ __('home.stat_1_lbl') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="h3 font-heading fw-bold text-warning mb-1"><span data-counter="{{ __('home.stat_2_val') }}">0</span>+</div>
                                <div class="small fw-semibold text-secondary">{{ __('home.stat_2_lbl') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-5 bg-section-slate position-relative overflow-hidden">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6" data-reveal="up">
                <div class="stat-box-large">
                    <div class="stat-number-large"><span data-counter="{{ __('home.metric_1_val') }}">0</span>K+</div>
                    <div class="stat-label-large">{{ __('home.metric_1_lbl') }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6" data-reveal="up" data-delay="100">
                <div class="stat-box-large">
                    <div class="stat-number-large"><span data-counter="{{ __('home.metric_2_val') }}">0</span>M+</div>
                    <div class="stat-label-large">{{ __('home.metric_2_lbl') }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6" data-reveal="up" data-delay="200">
                <div class="stat-box-large">
                    <div class="stat-number-large"><span data-counter="{{ __('home.metric_3_val') }}">0</span>+</div>
                    <div class="stat-label-large">{{ __('home.metric_3_lbl') }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6" data-reveal="up" data-delay="300">
                <div class="stat-box-large">
                    <div class="stat-number-large"><span data-counter="{{ __('home.metric_4_val') }}">0</span>+</div>
                    <div class="stat-label-large">{{ __('home.metric_4_lbl') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="hizmetler" class="py-5 bg-white position-relative overflow-hidden">
    
    <svg class="trinity-route-line d-none d-md-block" viewBox="0 0 1000 100" preserveAspectRatio="none" fill="none" style="background: transparent;">
        <path d="M -50 50 C 150 15, 250 85, 400 50 C 550 15, 650 85, 800 50 C 920 25, 980 75, 1050 50" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-dasharray="8 6"/>
    </svg>

    <div class="trinity-f90-drone-bg d-none d-md-block">
        <img src="{{ asset('assets/img/vector/trinity-f90.svg') }}" alt="Trinity F90+ VTOL Survey Drone" class="w-100 h-100">
    </div>

    <div class="container my-4 position-relative" style="z-index: 2;">
        
        <div class="row align-items-end mb-5" data-reveal="up">
            <div class="col-lg-7">
                <div class="corporate-badge mb-2">{!! render_svg_icon('layer-group', 'me-1') !!} {{ __('home.services_badge') }}</div>
                <h2>{{ __('home.services_title') }}</h2>
            </div>
            <div class="col-lg-5 text-lg-end">
                <a href="{{ route('services') }}" class="btn-enterprise btn-enterprise-outline">{{ __('common.all_services') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}</a>
            </div>
        </div>

        <div class="bento-grid">

            @foreach($services as $service)
                @if($loop->first)
                    
                    <div class="bento-col-8" data-reveal="up" data-delay="100">
                        <div class="bento-card-light bento-card-hero-light h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="bento-icon-light mb-0">{!! render_svg_icon(data_get($service, 'icon') ?: 'layer-group', 'fs-2') !!}</div>
                                    <span class="agency-tag agency-tag-tkgm">{!! render_svg_icon('shield-halved', 'me-1') !!} TKGM 3402/22-a</span>
                                </div>
                                <h3 class="mb-3 text-dark">{{ data_get($service, 'title') }}</h3>
                                <p class="lead text-secondary mb-4">
                                    {{ data_get($service, 'summary') }}
                                </p>
                            </div>
                            <div class="pt-4 border-top border-slate-200 d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <div class="d-flex gap-4">
                                    <div>
                                        <small class="text-muted d-block">{{ __('services.scope_badge') }}</small>
                                        <span class="fw-bold text-primary">{{ __('services.scope_val') }}</span>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Liyakat</small>
                                        <span class="fw-bold text-warning">Kamu İhalesi İş Bitirme Belgeli</span>
                                    </div>
                                </div>
                                <a href="{{ route('services.detail', data_get($service, 'slug')) }}" class="btn-enterprise btn-enterprise-outline py-2 px-4 fs-6">{{ __('common.explore') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}</a>
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
                            <a href="{{ route('services.detail', data_get($service, 'slug')) }}" class="btn-detail-enterprise">{{ __('common.explore') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}</a>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
</section>

<section id="is-akisi" class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="text-center mb-5" data-reveal="up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill font-mono mb-2">{!! render_svg_icon('route', 'me-1') !!} İMALAT DİSİPLİNİ & METODOLOJİ</span>
            <h2 class="h2 font-heading fw-bold">4 Adımda <span class="text-gradient-blue">Kamu & İhale Saha İmalat</span> Süreci</h2>
            <p class="text-secondary max-w-2xl mx-auto">Tüm 22/a kadastro yenileme, 3D kent modelleme ve koridor haritacılığı projelerimizde milimetrik kamu uyumu sağlayan 4 kademeli imalat metodolojimiz.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-reveal="up" data-delay="100">
                <div class="workflow-step-card">
                    <div class="step-num-badge">01</div>
                    <h4 class="h5 fw-bold mb-2">İhale & Statik Ön Hazırlık</h4>
                    <p class="text-secondary small mb-0">Kamu şartnameleri analizi, uçuş planlaması, GNSS CORS-TR yer kontrol nirengi noktası tesisleri.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-reveal="up" data-delay="200">
                <div class="workflow-step-card">
                    <div class="step-num-badge">02</div>
                    <h4 class="h5 fw-bold mb-2">Saha VTOL İHA & LiDAR Taraması</h4>
                    <p class="text-secondary small mb-0">Trinity F90+ VTOL ile 5-kameralı oblik fotogrametri ve 1.2M nokta/sn hava LiDAR çekimleri.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-reveal="up" data-delay="300">
                <div class="workflow-step-card">
                    <div class="step-num-badge">03</div>
                    <h4 class="h5 fw-bold mb-2">Fotogrametri & Netcad Çizimi</h4>
                    <p class="text-secondary small mb-0">Sub-cm ortofoto üretimi, 3D nokta bulutu sınıflama ve Megsis standartlarında vektör imalat.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-reveal="up" data-delay="400">
                <div class="workflow-step-card">
                    <div class="step-num-badge">04</div>
                    <h4 class="h5 fw-bold mb-2">TKGM Tescil & Nihai Teslimat</h4>
                    <p class="text-secondary small mb-0">Kadastro müdürlüğü kontrolü, tapu kütüğü tescili ve kamu idaresine onaylı veri teslimatı.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="projeler" class="bg-section-contour-light position-relative overflow-hidden py-5">
    <div class="container position-relative" style="z-index: 2;">
        <div class="d-flex justify-content-between align-items-end mb-5" data-reveal="up">
            <div>
                <div class="corporate-badge mb-2">{!! render_svg_icon('building', 'me-1') !!} {{ __('home.projects_badge') }}</div>
                <h2>{{ __('home.projects_title') }}</h2>
            </div>
            <a href="{{ route('projects') }}" class="btn-enterprise btn-enterprise-outline d-none d-md-inline-flex">{{ __('home.view_all_projects') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}</a>
        </div>

        <div class="row g-4">
            @foreach($projects as $project)
                <div class="col-md-6 col-lg-4" data-reveal="up" data-delay="{{ $loop->iteration * 100 }}">
                    <div class="card-enterprise bg-white border rounded-4 overflow-hidden h-100 shadow-sm d-flex flex-column justify-content-between">
                        <div>
                            <div class="project-img-wrapper">
                                @if(data_get($project, 'image'))
                                    <img src="{{ asset('storage/' . data_get($project, 'image')) }}" alt="{{ data_get($project, 'title') }}">
                                @else
                                    <img src="{{ asset('assets/img/vector/clean-cadastre.png') }}" alt="{{ data_get($project, 'title') }}">
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="agency-tag agency-tag-tkgm">{{ strtoupper(data_get($project, 'category') ?: 'KAMU PROJESİ') }}</span>
                                    <span class="badge-pulse-green"><span class="pulse-dot-green"></span> {{ data_get($project, 'is_completed') ? 'TESLİM EDİLDİ' : 'SAHA ÇALIŞMASI' }}</span>
                                </div>
                                <h4 class="h5 mb-2 text-dark">{{ data_get($project, 'title') }}</h4>
                                <p class="small text-secondary mb-0">{!! render_svg_icon('location-dot', 'me-1 text-primary') !!} {{ data_get($project, 'location') ?: 'Türkiye' }} / {{ data_get($project, 'summary') }}</p>
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <a href="{{ route('projects.detail', data_get($project, 'slug')) }}" class="btn-detail-enterprise w-100 justify-content-center">{{ __('projects.project_details') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@if(isset($posts) && is_countable($posts) && count($posts) > 0)
<section class="py-5 bg-white border-top">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5" data-reveal="up">
            <div>
                <div class="corporate-badge mb-2">{!! render_svg_icon('newspaper', 'me-1') !!} {{ __('home.news_badge') }}</div>
                <h2>{{ __('home.news_title') }}</h2>
            </div>
            <a href="{{ route('blog') }}" class="btn-enterprise btn-enterprise-outline d-none d-md-inline-flex">{{ __('home.view_all_posts') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}</a>
        </div>

        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-md-4" data-reveal="up">
                    <div class="card bg-light border-0 rounded-4 p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <span class="text-muted small mb-2 d-block">{!! render_svg_icon('calendar', 'me-1') !!} {{ data_get($post, 'created_at') ? (is_string(data_get($post, 'created_at')) ? date('d.m.Y', strtotime(data_get($post, 'created_at'))) : data_get($post, 'created_at')->format('d.m.Y')) : date('d.m.Y') }}</span>
                            <h4 class="h5 text-dark fw-bold mb-3">{{ data_get($post, 'title') }}</h4>
                            <p class="text-secondary small mb-4">{{ Str::limit(data_get($post, 'summary'), 120) }}</p>
                        </div>
                        <a href="{{ route('blog.detail', data_get($post, 'slug')) }}" class="btn-detail-enterprise">{{ __('common.read_more') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('frontend.partials.references_showcase')

@endsection
