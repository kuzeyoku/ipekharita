<!-- ── CTA TEKLİF BANNER ───────────────────────────────────── -->
<section id="teklif" class="py-5 my-4">
    <div class="container">
        <div class="cta-enterprise" style="background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 100%) !important; color: #FFFFFF !important; padding: 60px 45px; border-radius: 28px; box-shadow: 0 20px 45px rgba(15, 23, 42, 0.35);">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="badge bg-warning text-dark px-3 py-2 rounded-pill font-mono mb-3 fs-6">{!! render_svg_icon('file-contract', 'me-1') !!} {{ __('common.topbar_slogan_title') }}</div>
                    <h2 class="text-white mb-3 font-heading fw-bold fs-2" style="color: #FFFFFF !important;">{{ __('common.cta_title') }}</h2>
                    <p class="mb-0 text-white-50 lead fs-6" style="color: #E2E8F0 !important;">{{ __('common.cta_desc') }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('contact') }}" class="btn btn-warning btn-lg fw-bold px-4 py-3 rounded-pill text-dark border-0 shadow-lg d-inline-flex align-items-center gap-2">
                        {!! render_svg_icon('phone', 'me-1') !!} {{ __('common.cta_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
