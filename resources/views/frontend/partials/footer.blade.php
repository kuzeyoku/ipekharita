<footer class="footer-enterprise">
    <div class="container">
        <div class="row g-5 mb-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('assets/img/logo/ipek_logo_white.png') }}"
                        alt="@setting('brand_name')"
                        class="footer-brand-logo p-1 rounded-2 shadow-sm">
                </div>
                <p class="footer-desc">
                    @setting('footer_about')
                </p>
                <div class="d-flex gap-2">
                    @if(setting('social_linkedin'))
                        <a href="{{ setting('social_linkedin') }}" target="_blank" class="footer-social-btn" aria-label="LinkedIn">
                            {!! render_svg_icon('fab-linkedin-in') !!}
                        </a>
                    @endif
                    @if(setting('social_instagram'))
                        <a href="{{ setting('social_instagram') }}" target="_blank" class="footer-social-btn" aria-label="Instagram">
                            {!! render_svg_icon('fab-instagram') !!}
                        </a>
                    @endif
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h5>{{ __('common.quick_links') }}</h5>
                <ul class="footer-tech-links">
                    <li><a href="{{ route('home') }}">{!! render_svg_icon('chevron-right', 'me-1') !!} {{ __('common.home') }}</a></li>
                    <li><a href="{{ route('about') }}">{!! render_svg_icon('chevron-right', 'me-1') !!} {{ __('common.about') }}</a></li>
                    <li><a href="{{ route('services') }}">{!! render_svg_icon('chevron-right', 'me-1') !!} {{ __('common.services') }}</a></li>
                    <li><a href="{{ route('projects') }}">{!! render_svg_icon('chevron-right', 'me-1') !!} {{ __('common.projects') }}</a></li>
                    <li><a href="{{ route('blog') }}">{!! render_svg_icon('chevron-right', 'me-1') !!} {{ __('common.blog') }}</a></li>
                    <li><a href="{{ route('contact') }}">{!! render_svg_icon('chevron-right', 'me-1') !!} {{ __('common.contact') }}</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h5>{{ __('common.specializations') }}</h5>
                <ul class="footer-tech-links">
                    @foreach($footerServices as $fService)
                        <li><a href="{{ route('services.detail', data_get($fService, 'slug')) }}">{!! render_svg_icon('chevron-right', 'me-1') !!} {{ data_get($fService, 'title') }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-3">
                <h5>{{ __('common.contact_info') }}</h5>
                <ul class="footer-contact-list">
                    <li>{!! render_svg_icon('location-dot', 'text-primary me-2') !!} <span>@setting('company_address')</span></li>
                    <li>{!! render_svg_icon('phone', 'text-warning me-2') !!} <span>@setting('company_phone')</span></li>
                    <li>{!! render_svg_icon('envelope', 'text-info me-2') !!} <span>@setting('company_email')</span></li>
                </ul>
            </div>
        </div>

        <div
            class="pt-4 border-top border-secondary border-opacity-25 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 small text-slate-400">
            <p class="mb-0">© {{ date('Y') }} @setting('company_name')
                {{ __('common.all_rights_reserved') }}</p>
            <div class="d-flex gap-3">
                <a href="{{ route('pages.detail', 'kvkk-aydinlatma-metni') }}">{{ __('common.kvkk_notice') }}</a>
                <span>|</span>
                <a href="{{ route('pages.detail', 'gizlilik-politikasi') }}">{{ __('common.privacy_policy') }}</a>
            </div>
        </div>
    </div>
</footer>
