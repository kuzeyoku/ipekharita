<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Yönetim Paneli') | {{ setting('brand_name', setting('company_name', config('app.name', 'Yönetim Paneli'))) }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/hero/icon.png') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/dropify.min.css') }}">

    <script src="{{ asset('assets/js/chart.min.js') }}"></script>

    <script src="{{ asset('assets/js/tinymce.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin-assets/css/admin.css') }}">
    @stack('styles')
</head>

<body class="admin-body-light" data-editor-upload-url="{{ route('admin.editor-upload') }}"
    data-toast-success="{{ session('success') }}" data-toast-error="{{ session('error') }}">

    <aside class="admin-sidebar-light">
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="fa-solid fa-compass"></i>
            </div>
            <div class="d-flex flex-column">
                <span class="fw-extrabold text-dark font-outfit tracking-tight" style="font-size: 0.92rem; line-height: 1.2;">Kuzeyoku Software</span>
                <span class="text-primary fw-bold" style="font-size: 0.65rem; letter-spacing: 0.6px; text-transform: uppercase;">Yönetim Paneli</span>
            </div>
        </a>

        <div class="admin-sidebar-scroll py-2">
            
            <div class="admin-nav-section-title">Genel</div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    {!! render_svg_icon('chart-pie') !!} Dashboard
                </a>
            </div>

            <div class="admin-nav-section-title">İçerik Yönetimi</div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.services.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                    {!! render_svg_icon('layer-group') !!} Hizmet Yönetimi
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.projects.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
                    {!! render_svg_icon('route') !!} Proje Yönetimi
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.blog.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.blog*') ? 'active' : '' }}">
                    {!! render_svg_icon('newspaper') !!} Blog & Haberler
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.pages.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.pages*') ? 'active' : '' }}">
                    {!! render_svg_icon('file-contract') !!} Sayfa Yönetimi
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.categories.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    {!! render_svg_icon('tags') !!} Kategori Yönetimi
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.faqs.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.faqs*') ? 'active' : '' }}">
                    {!! render_svg_icon('circle-question') !!} SSS Yönetimi
                </a>
            </div>

            <div class="admin-nav-section-title">Etkileşim & CRM</div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.messages.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                    {!! render_svg_icon('envelope-open-text') !!} Mesajlar
                    @if(!empty($unreadMessagesCount) && $unreadMessagesCount > 0)
                        <span class="badge badge-pill-enterprise badge-pill-primary ms-auto" style="font-size: 0.68rem; padding: 2px 7px;">{{ $unreadMessagesCount }}</span>
                    @endif
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.comments.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.comments*') ? 'active' : '' }}">
                    {!! render_svg_icon('envelope') !!} Yorumlar
                    @if(!empty($pendingCommentsCount) && $pendingCommentsCount > 0)
                        <span class="badge badge-pill-enterprise badge-pill-warning ms-auto" style="font-size: 0.68rem; padding: 2px 7px;">{{ $pendingCommentsCount }}</span>
                    @endif
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.references.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.references*') ? 'active' : '' }}">
                    {!! render_svg_icon('handshake') !!} Referanslar
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.site-modals.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.site-modals*') ? 'active' : '' }}">
                    {!! render_svg_icon('window-restore') !!} Duyuru Modalleri
                </a>
            </div>

            <div class="admin-nav-section-title">Sistem & Yapılandırma</div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.menus.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.menus*') ? 'active' : '' }}">
                    {!! render_svg_icon('sitemap') !!} Menü Yönetimi
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.translations.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.translations*') ? 'active' : '' }}">
                    {!! render_svg_icon('language') !!} Diller ve Çeviriler
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.users.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    {!! render_svg_icon('users') !!} Kullanıcı Yönetimi
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="{{ route('admin.settings.index') }}"
                    class="admin-nav-link-light {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    {!! render_svg_icon('sliders') !!} Sistem Ayarları
                </a>
            </div>
        </div>

        <div class="px-3 py-2 mx-3 mb-2 rounded-3 bg-light border d-flex align-items-center justify-content-between small">
            <span class="d-flex align-items-center gap-2 text-dark font-monospace fw-semibold" style="font-size: 0.75rem;">
                <span class="pulse-indicator"></span> Sistem Aktif
            </span>
            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold" style="font-size: 0.68rem;">v13.8</span>
        </div>

        <div class="p-2 border-top border-light">
            <a href="{{ route('home') }}" target="_blank"
                class="admin-nav-link-light text-primary bg-primary bg-opacity-10 mb-1">
                {!! render_svg_icon('globe') !!} Web Sitesini İncele
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="admin-nav-link-light w-100 text-danger border-0 bg-transparent text-start">
                    {!! render_svg_icon('right-from-bracket') !!} Çıkış Yap
                </button>
            </form>
        </div>
    </aside>

    <header class="admin-header-light">
        <div class="d-flex align-items-center gap-3">
            <h6 class="mb-0 fw-extrabold text-dark" style="font-family: 'Outfit', sans-serif; font-size: 0.95rem;">
                @yield('title', 'Yönetim Paneli')</h6>

            <div class="search-command-btn" data-bs-toggle="modal" data-bs-target="#commandPaletteModal">
                {!! render_svg_icon('magnifying-glass', 'text-primary') !!}
                <span>Hızlı Menü Ara...</span>
                <span class="kbd-badge ms-1">Ctrl + K</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-sm-block">
                <span class="d-block fw-bold text-dark font-outfit"
                    style="font-size: 0.85rem; line-height: 1.2;">{{ auth()->user()->name ?? 'Yönetici' }}</span>
                <span class="d-inline-flex align-items-center gap-1 text-muted" style="font-size: 0.7rem;">
                    <span class="pulse-dot-green" style="width: 6px; height: 6px;"></span> Sistem Yöneticisi
                </span>
            </div>
            <div class="admin-user-avatar">
                {!! render_svg_icon('shield-halved') !!}
            </div>
        </div>
    </header>

    <main class="admin-main-light">
        @yield('content')
    </main>

    <div class="modal fade" id="commandPaletteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg p-2">
                <div class="modal-body p-3">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        {!! render_svg_icon('magnifying-glass', 'text-primary fs-6') !!}
                        <input type="text" class="form-control border-0 shadow-none small" id="commandSearchInput"
                            placeholder="Modül veya işlem arayın... (Örn: Projeler, Statik Metinler)" autofocus>
                    </div>
                    <div class="list-group list-group-flush small" id="commandList">
                        <a href="{{ route('admin.dashboard') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('chart-pie', 'text-primary') !!} <span>Dashboard (Genel Bakış)</span>
                        </a>
                        <a href="{{ route('admin.services.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('layer-group', 'text-info') !!} <span>Hizmet Yönetimi</span>
                        </a>
                        <a href="{{ route('admin.projects.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('route', 'text-warning') !!} <span>Proje Yönetimi</span>
                        </a>
                        <a href="{{ route('admin.blog.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('newspaper', 'text-success') !!} <span>Blog & Haberler Yönetimi</span>
                        </a>
                        <a href="{{ route('admin.pages.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('file-contract', 'text-primary') !!} <span>Sayfa Yönetimi</span>
                        </a>
                        <a href="{{ route('admin.categories.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('tags', 'text-secondary') !!} <span>Kategori Yönetimi</span>
                        </a>
                        <a href="{{ route('admin.faqs.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('circle-question', 'text-info') !!} <span>SSS (Sıkça Sorulan Sorular)</span>
                        </a>
                        <a href="{{ route('admin.messages.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('envelope-open-text', 'text-danger') !!} <span>Gelen İletişim Mesajları</span>
                        </a>
                        <a href="{{ route('admin.comments.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('envelope', 'text-warning') !!} <span>Müşteri Yorumları</span>
                        </a>
                        <a href="{{ route('admin.references.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('handshake', 'text-success') !!} <span>Referans Yönetimi</span>
                        </a>
                        <a href="{{ route('admin.site-modals.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('window-restore', 'text-purple') !!} <span>Duyuru Pencereleri (Modaller)</span>
                        </a>
                        <a href="{{ route('admin.menus.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('sitemap', 'text-info') !!} <span>Menü Yönetimi</span>
                        </a>
                        <a href="{{ route('admin.translations.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('language', 'text-primary') !!} <span>Diller ve Çeviri Yönetimi</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('users', 'text-dark') !!} <span>Kullanıcı Yönetimi</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}"
                            class="list-group-item list-group-item-action rounded-3 border-0 py-2 d-flex align-items-center gap-3">
                            {!! render_svg_icon('sliders', 'text-secondary') !!} <span>Sistem Ayarları & SMTP</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/dropify.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/admin.js') }}"></script>
    @stack('scripts')
</body>

</html>
