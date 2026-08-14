@extends('frontend.layouts.master')

@section('title', __('common.contact'))

@section('content')

<section class="subpage-header-banner">
    <div class="container text-center">
        <nav class="breadcrumb-enterprise mb-3" aria-label="breadcrumb">
            <a href="{{ route('home') }}">{!! render_svg_icon('house', 'me-1') !!} {{ __('common.home') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <span class="breadcrumb-active">{{ __('common.contact') }}</span>
        </nav>
        <h1 class="subpage-title mb-3">{{ __('contact.hero_title') }}</h1>
        <p class="lead text-secondary max-w-600 mx-auto mb-0" style="font-size:1.1rem;">{{ __('contact.hero_subtitle') }}</p>
    </div>
</section>

<div class="py-5 mb-5">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4" data-reveal="up">
                <div class="bento-card-light text-center h-100 p-4">
                    <div class="bento-icon-light mx-auto mb-3">{!! render_svg_icon('location-dot', 'fs-3') !!}</div>
                    <h5 class="text-dark font-heading mb-2">{{ __('contact.headquarters') }}</h5>
                    <p class="text-secondary small mb-0">@setting('address')</p>
                </div>
            </div>
            <div class="col-md-4" data-reveal="up" data-delay="100">
                <div class="bento-card-light text-center h-100 p-4">
                    <div class="bento-icon-light mx-auto mb-3">{!! render_svg_icon('phone', 'fs-3') !!}</div>
                    <h5 class="text-dark font-heading mb-2">{{ __('contact.phone_title') }}</h5>
                    <p class="text-secondary small mb-0">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('phone')) }}" class="text-primary font-semibold text-decoration-none">
                            @setting('phone')
                        </a><br>{{ __('contact.working_hours_info') }}
                    </p>
                </div>
            </div>
            <div class="col-md-4" data-reveal="up" data-delay="200">
                <div class="bento-card-light text-center h-100 p-4">
                    <div class="bento-icon-light mx-auto mb-3">{!! render_svg_icon('envelope', 'fs-3') !!}</div>
                    <h5 class="text-dark font-heading mb-2">{{ __('contact.email_title') }}</h5>
                    <p class="text-secondary small mb-0">
                        <a href="mailto:{{ setting('email') }}" class="text-primary font-semibold text-decoration-none">
                            @setting('email')
                        </a><br>{{ __('contact.email_sub') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-5">
            
            <div class="col-lg-6" data-reveal="left">
                <div class="card-enterprise p-4 p-md-5">
                    <h3 class="mb-2 text-dark font-heading">{{ __('contact.form_title') }}</h3>
                    <p class="text-secondary small mb-4">{{ __('contact.form_desc') }}</p>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center gap-2">
                            {!! render_svg_icon('check', 'text-success fs-4') !!}
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        
                        <div style="display:none !important;" aria-hidden="true">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="service_title" class="form-label text-dark small fw-semibold">{{ __('contact.service_label') }}</label>
                            <select name="service_title" id="service_title" class="form-select border-slate-200 p-3 rounded-3 text-secondary">
                                <option value="">{{ __('contact.service_placeholder') }}</option>
                                @if(isset($services))
                                    @foreach($services as $srv)
                                        <option value="{{ $srv->title }}">{{ $srv->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark small fw-semibold">{{ __('contact.name_label') }}</label>
                            <input type="text" name="name" id="name" class="form-control-enterprise w-100" placeholder="{{ __('contact.name_placeholder') }}" value="{{ old('name') }}" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label text-dark small fw-semibold">{{ __('contact.email_label') }}</label>
                                <input type="email" name="email" id="email" class="form-control-enterprise w-100" placeholder="{{ __('contact.email_placeholder') }}" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label text-dark small fw-semibold">{{ __('contact.phone_label') }}</label>
                                <input type="tel" name="phone" id="phone" class="form-control-enterprise w-100" placeholder="{{ __('contact.phone_placeholder') }}" value="{{ old('phone') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="company" class="form-label text-dark small fw-semibold">{{ __('contact.company_label') }}</label>
                            <input type="text" name="company" id="company" class="form-control-enterprise w-100" placeholder="{{ __('contact.company_placeholder') }}" value="{{ old('company') }}">
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label text-dark small fw-semibold">{{ __('contact.message_label') }}</label>
                            <textarea name="message" id="message" rows="4" class="form-control-enterprise w-100" placeholder="{{ __('contact.message_placeholder') }}" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn-enterprise btn-enterprise-primary w-100 py-3 d-inline-flex align-items-center justify-content-center gap-2">
                            {!! render_svg_icon('paper-plane', 'me-1') !!} {{ __('contact.btn_submit') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6" data-reveal="right">
                <div class="card-enterprise p-2 h-100 min-vh-400 overflow-hidden">
                    <iframe title="Map Location" src="{{ setting('map_iframe', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d195884.30043003058!2d32.62268393529367!3d39.90355567554904!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d347d520732db1%3A0xbdc57b0c0842b8d!2sAnkara!5e0!3m2!1str!2str!4v1700000000000!5m2!1str!2str') }}" width="100%" height="100%" style="border:0; min-height:450px;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
