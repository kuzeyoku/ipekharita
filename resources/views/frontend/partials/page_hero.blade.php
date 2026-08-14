<section class="subpage-header-banner py-5 bg-gradient-dark position-relative overflow-hidden">
    <div class="container text-center py-3 position-relative z-2" data-reveal="down">
        @if(!empty($breadcrumbs))
            <nav class="breadcrumb-enterprise mb-3 justify-content-center" aria-label="breadcrumb">
                @foreach($breadcrumbs as $bc)
                    @if(!empty($bc['active']))
                        <span class="breadcrumb-active fw-semibold text-primary-light">{{ $bc['title'] }}</span>
                    @else
                        <a href="{{ $bc['url'] ?? '#' }}" class="text-white-50 text-decoration-none hover-white">
                            @if($loop->first){!! render_svg_icon('house', 'me-1') !!}@endif {{ $bc['title'] }}
                        </a>
                        {!! render_svg_icon('chevron-right', 'breadcrumb-separator text-white-50 mx-2 font-xs') !!}
                    @endif
                @endforeach
            </nav>
        @endif

        <h1 class="subpage-title text-white fw-extrabold mb-3 display-6 font-outfit">
            {{ $title }}
            @if(!empty($highlightTitle))
                <span class="text-gradient-blue ms-1">{{ $highlightTitle }}</span>
            @endif
        </h1>

        @if(!empty($subtitle))
            <p class="lead text-white-50 max-w-700 mx-auto mb-0" style="font-size: 1.1rem; line-height: 1.6;">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</section>
