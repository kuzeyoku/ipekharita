@extends('frontend.layouts.master')

@section('title', $post->title)
@section('meta_description', $post->meta_description)

@section('content')

<section class="subpage-header-banner">
    <div class="container text-center">
        <nav class="breadcrumb-enterprise mb-3" aria-label="breadcrumb">
            <a href="{{ route('home') }}">{!! render_svg_icon('house', 'me-1') !!} {{ __('common.home') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <a href="{{ route('blog') }}">{{ __('common.blog') }}</a>
            {!! render_svg_icon('chevron-right', 'breadcrumb-separator') !!}
            <span class="breadcrumb-active">{{ $post->title }}</span>
        </nav>
        <h1 class="subpage-title mb-3">{{ $post->title }}</h1>
        <p class="lead text-secondary max-w-600 mx-auto mb-0" style="font-size:1.1rem;">{{ $post->summary }}</p>
    </div>
</section>

<div class="py-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9" data-reveal="up">
                <article class="card-enterprise p-4 p-md-5 mb-4">
                    @if($post->image)
                        <div class="p-3 mb-4 bg-light border rounded-4 text-center">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid rounded-4" style="max-height: 400px; object-fit: contain;">
                        </div>
                    @endif

                    <div class="d-flex align-items-center gap-3 text-muted small mb-4 pb-3 border-bottom">
                        <span>{!! render_svg_icon('calendar', 'me-1') !!} {{ $post->created_at ? $post->created_at->format('d.m.Y') : date('d.m.Y') }}</span>
                        <span>•</span>
                        <span>{!! render_svg_icon('building', 'me-1') !!} @setting('company_name')</span>
                        <span>•</span>
                        <span>{!! render_svg_icon('envelope', 'me-1') !!} {{ $post->approvedComments->count() }} {{ __('blog.comments_title') }}</span>
                    </div>

                    <div class="content-body text-secondary lead mb-4">
                        {!! $post->content !!}
                    </div>
                </article>

                <div class="card-enterprise p-4 p-md-5">
                    <h4 class="fw-extrabold text-dark mb-4 font-outfit d-flex align-items-center gap-2">
                        {!! render_svg_icon('envelope', 'text-primary me-2') !!} {{ __('blog.comments_title') }} ({{ $post->approvedComments->count() }})
                    </h4>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {!! render_svg_icon('check', 'me-2') !!} {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @forelse($post->approvedComments as $commentItem)
                        <div class="p-3 mb-3 bg-light rounded-4 border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark d-inline-flex align-items-center gap-1">{!! render_svg_icon('building', 'me-1 text-primary') !!} {{ $commentItem->name }}</span>
                                <span class="text-muted small fs-xs d-inline-flex align-items-center gap-1">{!! render_svg_icon('calendar', 'me-1') !!} {{ $commentItem->created_at ? $commentItem->created_at->format('d.m.Y H:i') : '' }}</span>
                            </div>
                            <p class="text-secondary mb-0 small leading-relaxed">{{ $commentItem->comment }}</p>
                        </div>
                    @empty
                        <p class="text-muted small mb-4 italic d-inline-flex align-items-center gap-1">{!! render_svg_icon('envelope', 'me-1') !!} {{ __('blog.no_comments') }}</p>
                    @endforelse

                    <hr class="my-4">

                    <h5 class="fw-bold text-dark mb-3 font-outfit d-flex align-items-center gap-2">{!! render_svg_icon('file-contract', 'me-2 text-primary') !!} {{ __('blog.leave_comment') }}</h5>
                    <form action="{{ route('blog.comment', $post->slug) }}" method="POST">
                        @csrf
                        
                        <div style="display:none !important;" aria-hidden="true">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold text-dark small">{{ __('blog.name_label') }}</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ahmet Yılmaz" required>
                                @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold text-dark small">{{ __('blog.email_label') }}</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="ahmet@example.com" required>
                                @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label fw-semibold text-dark small">{{ __('blog.comment_label') }}</label>
                            <textarea name="comment" id="comment" rows="4" class="form-control @error('comment') is-invalid @enderror" placeholder="Konu hakkındaki düşünce ve sorularınızı buraya yazabilirsiniz..." required>{{ old('comment') }}</textarea>
                            @error('comment') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold d-inline-flex align-items-center gap-2">
                            {!! render_svg_icon('paper-plane', 'me-1') !!} {{ __('blog.btn_submit_comment') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
