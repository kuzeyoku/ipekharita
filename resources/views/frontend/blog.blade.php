@extends('frontend.layouts.master')

@section('title', __('common.blog'))

@section('content')

<section class="subpage-header-banner">
    <div class="container text-center">
        <nav class="breadcrumb-enterprise mb-3" aria-label="breadcrumb">
            <a href="{{ route('home') }}">{!! render_svg_icon('house', 'me-1') !!} {{ __('common.home') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <span class="breadcrumb-active">{{ __('common.blog') }}</span>
        </nav>
        <h1 class="subpage-title mb-3">{{ __('blog.hero_title') }}</h1>
        <p class="lead text-secondary max-w-600 mx-auto mb-0" style="font-size:1.1rem;">{{ __('blog.hero_subtitle') }}</p>
    </div>
</section>

<div class="py-5 mb-5">
    <div class="container">

        @if(isset($categories) && count($categories) > 0)
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-5">
                <a href="{{ route('blog') }}" class="btn btn-sm {{ !$selectedCatSlug ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }} rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-1">
                    {!! render_svg_icon('layer-group', 'me-1') !!} {{ __('blog.all_posts') }}
                </a>
                @foreach($categories as $catItem)
                    <a href="{{ route('blog', ['category' => $catItem->slug]) }}" class="btn btn-sm {{ $selectedCatSlug == $catItem->slug ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }} rounded-pill px-4 py-2 fw-semibold">
                        {{ $catItem->title }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-6 col-lg-4" data-reveal="up">
                    <div class="card-enterprise h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="position-relative overflow-hidden p-2 bg-light border-bottom" style="height:220px;">
                                @if(data_get($post, 'image'))
                                    <img src="{{ asset('storage/' . data_get($post, 'image')) }}" alt="{{ data_get($post, 'title') }}" class="w-100 h-100 object-fit-contain">
                                @else
                                    <img src="{{ asset('assets/img/hero/slide-1.png') }}" alt="{{ data_get($post, 'title') }}" class="w-100 h-100 object-fit-contain">
                                @endif
                                <span class="badge bg-primary position-absolute top-0 start-0 m-3 font-mono">
                                    {{ data_get($post, 'category.title') ?: 'MAKALE' }}
                                </span>
                            </div>
                            <div class="p-4">
                                <div class="text-muted small mb-2 d-flex align-items-center justify-content-between">
                                    <span>{!! render_svg_icon('calendar', 'me-1') !!} {{ data_get($post, 'created_at') ? (is_string(data_get($post, 'created_at')) ? date('d.m.Y', strtotime(data_get($post, 'created_at'))) : data_get($post, 'created_at')->format('d.m.Y')) : date('d.m.Y') }}</span>
                                    <span>{!! render_svg_icon('envelope', 'me-1 text-primary') !!} {{ data_get($post, 'approvedComments') ? data_get($post, 'approvedComments')->count() : 0 }}</span>
                                </div>
                                <h4 class="h5 mb-3 text-dark fw-bold">{{ data_get($post, 'title') }}</h4>
                                <p class="text-secondary small mb-3">{{ Str::limit(data_get($post, 'summary'), 120) }}</p>
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <a href="{{ route('blog.detail', data_get($post, 'slug')) }}" class="btn-detail-enterprise w-100 justify-content-center">{{ __('common.read_more') }} {!! render_svg_icon('arrow-right', 'ms-1') !!}</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <div class="mb-3 opacity-50">{!! render_svg_icon('newspaper', 'fs-1 text-secondary') !!}</div>
                    {{ __('blog.no_posts_found') ?? 'Bu kategoride henüz yayınlanmış bir makale bulunmuyor.' }}
                </div>
            @endforelse
        </div>

        @if(method_exists($posts, 'hasPages') && $posts->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
