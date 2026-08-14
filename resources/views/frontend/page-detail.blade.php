@extends('frontend.layouts.master')

@section('title', $page->title)
@section('meta_description', $page->meta_description)

@section('content')

<section class="subpage-header-banner">
    <div class="container text-center">
        <nav class="breadcrumb-enterprise mb-3" aria-label="breadcrumb">
            <a href="{{ route('home') }}">{!! render_svg_icon('house', 'me-1') !!} {{ __('common.home') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <span class="breadcrumb-active">{{ $page->title }}</span>
        </nav>
        <h1 class="subpage-title mb-3">{{ $page->title }}</h1>
        @if($page->summary)
            <p class="lead text-secondary max-w-700 mx-auto mb-0" style="font-size:1.1rem;">{{ $page->summary }}</p>
        @endif
    </div>
</section>

<div class="py-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card-enterprise p-4 p-md-5 bg-white shadow-sm rounded-4">
                    @if($page->image)
                        <div class="mb-4 text-center rounded-4 overflow-hidden shadow-sm">
                            <img src="{{ asset(str_starts_with($page->image, 'storage/') || str_starts_with($page->image, 'assets/') ? $page->image : 'storage/' . $page->image) }}" alt="{{ $page->title }}" class="img-fluid w-100 object-fit-cover" style="max-height: 400px;">
                        </div>
                    @endif

                    <div class="typography-body leading-relaxed text-dark" style="font-size: 1.05rem;">
                        {!! $page->content !!}
                    </div>

                    <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill px-4 d-inline-flex align-items-center gap-1">
                            {!! render_svg_icon('arrow-left', 'me-1') !!} {{ __('common.home') }}
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-primary rounded-pill px-4 fw-bold d-inline-flex align-items-center gap-1">
                            {!! render_svg_icon('paper-plane', 'me-1') !!} {{ __('common.contact') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
