<header class="site-header-fixed">
    
    <div class="topbar-enterprise d-none d-lg-block">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-4">
                    <span>{!! render_svg_icon('building-flag', 'text-warning me-2') !!}<strong>{{ __('common.topbar_slogan_title') }}</strong> | {{ __('common.topbar_slogan_sub') }}</span>
                    <span>{!! render_svg_icon('location-dot', 'me-1') !!} @setting('company_address_short')</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('company_phone')) }}">{!! render_svg_icon('phone', 'me-1') !!}@setting('company_phone')</a>
                    <a href="mailto:@setting('company_email')">{!! render_svg_icon('envelope', 'me-1') !!}@setting('company_email')</a>

                    <div class="dropdown d-inline-block ms-2">
                        <button class="btn btn-sm btn-outline-light border-0 dropdown-toggle py-1 px-2.5 fw-semibold text-white d-inline-flex align-items-center gap-1.5" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.82rem; background: rgba(255,255,255,0.22); border-radius: 6px;">
                            <span class="d-inline-flex align-items-center gap-1">{!! render_flag_svg($currentLocale) !!} {{ strtoupper($currentLocale) }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-1 p-1" style="min-width: 145px; font-size: 0.85rem;">
                            @foreach($activeLocales ?? ['tr' => ['name' => 'Türkçe'], 'en' => ['name' => 'English']] as $code => $loc)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between rounded-1 py-1.5 px-2.5 {{ $currentLocale === $code ? 'fw-bold text-primary bg-primary bg-opacity-10' : 'text-dark fw-semibold opacity-100' }}" href="{{ route('lang.switch', $code) }}">
                                        <span class="d-inline-flex align-items-center gap-2">{!! render_flag_svg($code) !!} {{ $loc['name'] ?? strtoupper($code) }} ({{ strtoupper($code) }})</span>
                                        @if($currentLocale === $code) {!! render_svg_icon('check', 'text-primary fs-7') !!} @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar-floating-container">
        <div class="container">
            <nav class="navbar navbar-expand-lg py-2">
                <a href="{{ route('home') }}" class="navbar-brand-enterprise d-flex align-items-center gap-2">
                    <img src="{{ asset('assets/img/logo/ipek_logo.png') }}" alt="@setting('brand_name')" class="brand-logo-img header-brand-logo">
                </a>

                <div class="d-flex align-items-center gap-2 ms-auto d-lg-none">
                    
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border py-1 px-2.5 fw-bold text-dark d-inline-flex align-items-center gap-1.5" type="button" data-bs-toggle="dropdown">
                            <span>{!! render_flag_svg($currentLocale) !!} {{ strtoupper($currentLocale) }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 p-1">
                            @foreach($activeLocales ?? ['tr' => ['name' => 'Türkçe'], 'en' => ['name' => 'English']] as $code => $loc)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between rounded-1 py-1.5 px-2.5 {{ $currentLocale === $code ? 'fw-bold text-primary bg-primary bg-opacity-10' : 'text-dark fw-semibold opacity-100' }}" href="{{ route('lang.switch', $code) }}">
                                        <span class="d-inline-flex align-items-center gap-2">{!! render_flag_svg($code) !!} {{ $loc['name'] ?? strtoupper($code) }} ({{ strtoupper($code) }})</span>
                                        @if($currentLocale === $code) {!! render_svg_icon('check', 'text-primary fs-7') !!} @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-label="Menu">
                        {!! render_svg_icon('bars', 'fs-3 text-primary') !!}
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="navContent">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                        @if(isset($headerMenuTree) && is_countable($headerMenuTree) && count($headerMenuTree) > 0)
                            @foreach($headerMenuTree as $menuItem)
                                @php
                                    $mIcon = $menuItem->icon;
                                @endphp

                                @if($menuItem->activeChildren->count() > 0)
                                    
                                    <li class="nav-item dropdown">
                                        <a class="nav-link-enterprise dropdown-toggle d-inline-flex align-items-center gap-1 {{ request()->is(ltrim($menuItem->url, '/')) ? 'active' : '' }}" href="{{ url($menuItem->url) }}" role="button" data-bs-toggle="dropdown" aria-expanded="false" target="{{ $menuItem->target }}">
                                            @if($mIcon) {!! render_svg_icon($mIcon, 'me-1 text-primary') !!} @endif
                                            <span>{{ $menuItem->title }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-enterprise">
                                            <li>
                                                <a class="dropdown-item dropdown-item-enterprise fw-bold" href="{{ url($menuItem->url) }}" target="{{ $menuItem->target }}">
                                                    @if($mIcon) {!! render_svg_icon($mIcon, 'text-primary me-2') !!} @endif
                                                    <span>{{ $menuItem->title }}</span>
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            @foreach($menuItem->activeChildren as $childMenu)
                                                <li>
                                                    <a class="dropdown-item dropdown-item-enterprise d-inline-flex align-items-center" href="{{ url($childMenu->url) }}" target="{{ $childMenu->target }}">
                                                        {!! render_svg_icon($childMenu->icon ?: 'chevron-right', 'text-muted fs-7 me-2') !!}
                                                        <span>{{ $childMenu->title }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    
                                    <li class="nav-item">
                                        <a class="nav-link-enterprise d-inline-flex align-items-center {{ request()->is(ltrim($menuItem->url, '/')) ? 'active' : '' }}" href="{{ url($menuItem->url) }}" target="{{ $menuItem->target }}">
                                            @if($mIcon) {!! render_svg_icon($mIcon, 'me-1 text-primary') !!} @endif
                                            <span>{{ $menuItem->title }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li class="nav-item">
                                <a class="nav-link-enterprise {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    {!! render_svg_icon('house', 'me-1 text-primary') !!} {{ __('common.home') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-enterprise {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                    {!! render_svg_icon('building', 'me-1 text-primary') !!} {{ __('common.about') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-enterprise {{ request()->routeIs('services*') ? 'active' : '' }}" href="{{ route('services') }}">
                                    {!! render_svg_icon('layer-group', 'me-1 text-primary') !!} {{ __('common.services') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-enterprise {{ request()->routeIs('projects*') ? 'active' : '' }}" href="{{ route('projects') }}">
                                    {!! render_svg_icon('route', 'me-1 text-primary') !!} {{ __('common.projects') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-enterprise {{ request()->routeIs('blog*') ? 'active' : '' }}" href="{{ route('blog') }}">
                                    {!! render_svg_icon('newspaper', 'me-1 text-primary') !!} {{ __('common.blog') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-enterprise {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                                    {!! render_svg_icon('envelope', 'me-1 text-primary') !!} {{ __('common.contact') }}
                                </a>
                            </li>
                        @endif

                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                            <a href="{{ route('contact') }}" class="btn-enterprise btn-enterprise-primary btn-sm d-inline-flex align-items-center">
                                {!! render_svg_icon('file-contract', 'me-1') !!} {{ __('common.get_quote') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
