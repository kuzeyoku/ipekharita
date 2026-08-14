@if(isset($references) && is_countable($references) && count($references) > 0)
<section class="py-5 bg-light border-top border-bottom overflow-hidden position-relative">
    <div class="container text-center mb-4">
        <div class="corporate-badge mb-2 mx-auto">{!! render_svg_icon('handshake', 'me-1') !!} ÇÖZÜM ORTAKLARIMIZ VE REFERANSLARIMIZ</div>
        <h2 class="mb-1">Birlikte Çalıştığımız <span class="text-gradient-blue">Güçlü Markalar & Kurumlar</span></h2>
        <p class="text-secondary small mb-0">Kamu idareleri, belediyeler ve yüklenici ortaklarımızla sürdürülen projelere ait liyakat referansları.</p>
    </div>

    <!-- Infinite Single-Row Horizontal Marquee -->
    <div class="marquee-wrapper position-relative py-3">
        <div class="marquee-track">
            <!-- First Set -->
            @foreach($references as $refItem)
                @php
                    $logoPath = data_get($refItem, 'logo') ?: data_get($refItem, 'image');
                    $imgUrl = $logoPath ? (str_starts_with($logoPath, 'assets/') ? asset($logoPath) : asset('storage/' . $logoPath)) : null;
                @endphp
                <div class="marquee-card">
                    @if($imgUrl)
                        <img src="{{ $imgUrl }}" alt="{{ data_get($refItem, 'title') }}" class="marquee-img">
                    @else
                        <span class="fw-bold text-dark small">{!! render_svg_icon('building', 'me-1 text-primary') !!} {{ data_get($refItem, 'title') }}</span>
                    @endif
                </div>
            @endforeach

            <!-- Duplicate Set for Seamless Continuous Loop -->
            @foreach($references as $refItem)
                @php
                    $logoPath = data_get($refItem, 'logo') ?: data_get($refItem, 'image');
                    $imgUrl = $logoPath ? (str_starts_with($logoPath, 'assets/') ? asset($logoPath) : asset('storage/' . $logoPath)) : null;
                @endphp
                <div class="marquee-card">
                    @if($imgUrl)
                        <img src="{{ $imgUrl }}" alt="{{ data_get($refItem, 'title') }}" class="marquee-img">
                    @else
                        <span class="fw-bold text-dark small">{!! render_svg_icon('building', 'me-1 text-primary') !!} {{ data_get($refItem, 'title') }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.marquee-wrapper {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
    -webkit-mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
}

.marquee-track {
    display: inline-flex;
    align-items: center;
    gap: 1.5rem;
    animation: marqueeScroll 25s linear infinite;
}

.marquee-wrapper:hover .marquee-track {
    animation-play-state: paused;
}

.marquee-card {
    flex: 0 0 auto;
    width: 240px;
    height: 85px;
    background: #ffffff;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 12px 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.marquee-card:hover {
    transform: translateY(-4px);
    border-color: #2563EB;
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.12);
}

.marquee-img {
    max-height: 52px;
    max-width: 100%;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.05));
}

@keyframes marqueeScroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}
</style>
@endif
