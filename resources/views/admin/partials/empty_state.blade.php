<div class="text-center py-5 my-3">
    <div class="stat-icon-square icon-blue-gradient mx-auto mb-3 opacity-75 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; font-size: 1.75rem; border-radius: 18px;">
        <i class="fa-solid {{ $icon ?? 'fa-inbox' }}"></i>
    </div>
    <h5 class="fw-bold text-dark font-outfit mb-1">{{ $title ?? 'Henüz Kayıt Eklendi' }}</h5>
    <p class="text-muted small max-w-400 mx-auto mb-3">{{ $message ?? 'Aradığınız kriterlere uygun veri bulunamadı.' }}</p>
    @if(!empty($createUrl))
        <a href="{{ $createUrl }}" class="btn btn-enterprise-admin rounded-3 px-4 btn-sm">
            <i class="fa-solid fa-plus me-1"></i> {{ $createTitle ?? 'Yeni Ekle' }}
        </a>
    @endif
</div>
