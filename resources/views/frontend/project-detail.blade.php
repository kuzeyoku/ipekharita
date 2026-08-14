@extends('frontend.layouts.master')

@section('title', $project->title)
@section('meta_description', $project->meta_description)

@section('content')

<section class="subpage-header-banner">
    <div class="container text-center">
        <nav class="breadcrumb-enterprise mb-3" aria-label="breadcrumb">
            <a href="{{ route('home') }}">{!! render_svg_icon('house', 'me-1') !!} {{ __('common.home') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <a href="{{ route('projects') }}">{{ __('common.projects') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <span class="breadcrumb-active">{{ $project->title }}</span>
        </nav>
        <h1 class="subpage-title mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary max-w-600 mx-auto mb-0" style="font-size:1.1rem;">{{ $project->summary }}</p>
    </div>
</section>

<div class="py-5 mb-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8" data-reveal="left">
                @if($project->image)
                    <div class="card-enterprise p-3 mb-4 bg-light border text-center">
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="img-fluid rounded-4" style="max-height: 420px; object-fit: contain;">
                    </div>
                @endif

                <h3 class="mb-3 text-dark font-heading">{{ __('projects.project_summary') }}</h3>
                <div class="content-body text-secondary lead mb-4">
                    {!! $project->description ?: $project->content !!}
                </div>

                <h4 class="mt-4 mb-3 text-dark font-heading">{{ __('projects.applied_technologies') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border d-flex align-items-center gap-3">
                            {!! render_svg_icon('check', 'text-success fs-3') !!}
                            <div>
                                <h6 class="mb-0 text-dark font-heading">{{ __('projects.tech_1_title') }}</h6>
                                <small class="text-muted">{{ __('projects.tech_1_desc') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border d-flex align-items-center gap-3">
                            {!! render_svg_icon('check', 'text-success fs-3') !!}
                            <div>
                                <h6 class="mb-0 text-dark font-heading">{{ __('projects.tech_2_title') }}</h6>
                                <small class="text-muted">{{ __('projects.tech_2_desc') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($faqs) && count($faqs) > 0)
                <h4 class="mt-5 mb-3 text-dark font-heading">Proje & Saha İle İlgili Sıkça Sorulan Sorular</h4>
                <div class="accordion" id="projectFaqAccordion">
                    @foreach($faqs as $faq)
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#pfaq{{ $faq->id }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="pfaq{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#projectFaqAccordion">
                                <div class="accordion-body text-secondary">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="col-lg-4" data-reveal="right">
                <div class="bento-card-light p-4 mb-4">
                    <h4 class="h5 mb-4 text-dark font-heading border-bottom pb-2">{{ __('projects.project_details') }}</h4>
                    <ul class="list-unstyled text-secondary mb-0">
                        <li class="mb-3 pb-2 border-bottom d-flex justify-content-between">
                            <strong>{{ __('projects.client') }}:</strong> 
                            <span class="text-dark">{{ $project->client ?: 'Kamu İdaresi' }}</span>
                        </li>
                        <li class="mb-3 pb-2 border-bottom d-flex justify-content-between">
                            <strong>{{ __('projects.category') }}:</strong> 
                            <span class="text-dark">{{ $project->category ?: 'Mühendislik Projesi' }}</span>
                        </li>
                        <li class="mb-3 pb-2 border-bottom d-flex justify-content-between">
                            <strong>{{ __('projects.location') }}:</strong> 
                            <span class="text-dark font-mono">{{ $project->location ?: 'Türkiye' }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <strong>Durum:</strong> 
                            <span class="badge {{ $project->is_completed ? 'bg-success' : 'bg-primary' }} text-white font-mono">
                                {{ $project->is_completed ? 'TAMAMLANDI' : 'DEVAM EDİYOR' }}
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="bg-primary text-white p-4 rounded-4 shadow">
                    <h4 class="text-white mb-2 font-heading">{{ __('projects.consult_banner_title') }}</h4>
                    <p class="small text-white-50 mb-4">{{ __('projects.consult_banner_desc') }}</p>
                    <a href="{{ route('contact') }}" class="btn-enterprise btn-enterprise-primary bg-warning text-dark border-0 w-100 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                        {!! render_svg_icon('phone', 'me-1') !!} {{ __('projects.get_quote_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
