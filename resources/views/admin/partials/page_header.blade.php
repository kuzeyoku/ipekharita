{{--
    Admin Page Header Partial
    Usage:
    @include('admin.partials.page_header', [
        'title' => 'Kullanıcı Yönetimi',
        'subtitle' => 'Sistem yöneticilerini ve erişim yetkilerini yönetin.',
        'icon' => 'fa-users',
        'backUrl' => route('admin.users.index'), // optional
        'createUrl' => route('admin.users.create'), // optional
        'createTitle' => 'Yeni Kullanıcı Ekle', // optional
    ])
--}}
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4 p-3 bg-white rounded-4 shadow-sm border">
    <div>
        @if(!empty($backUrl))
            <a href="{{ $backUrl }}" class="btn btn-sm btn-light border rounded-pill px-3 py-1 mb-2 text-secondary fw-semibold">
                <i class="fa-solid fa-arrow-left me-1 text-primary"></i> Geri Dön
            </a>
        @endif
        <h4 class="fw-extrabold text-dark mb-1 d-flex align-items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            @if(!empty($icon))
                <span class="stat-icon-square icon-blue-gradient d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 1rem; border-radius: 10px;">
                    <i class="fa-solid {{ $icon }}"></i>
                </span>
            @endif
            <span>{{ $title ?? 'Yönetim Paneli' }}</span>
        </h4>
        @if(!empty($subtitle))
            <p class="text-muted small mb-0 ms-1">{{ $subtitle }}</p>
        @endif
    </div>

    @if(!empty($createUrl))
        <div>
            <a href="{{ $createUrl }}" class="btn btn-enterprise-admin rounded-3 px-4 shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> {{ $createTitle ?? 'Yeni Ekle' }}
            </a>
        </div>
    @endif
</div>
