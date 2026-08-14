@extends('admin.layouts.master')

@section('title', 'Yeni Referans Ekle')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Yeni Referans Ekle',
    'subtitle' => 'Web sitesinde gösterilecek marka veya idare logosu ekleyin.',
    'icon' => 'fa-plus',
    'backUrl' => route('admin.references.index')
])

@include('admin.partials.alerts')

<form action="{{ route('admin.references.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-4 border-bottom pb-2 font-outfit">Referans Bilgileri</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Kurum / Marka Adı *</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control admin-input-light @error('title') is-invalid @enderror" placeholder="Örn: ASELSAN A.Ş." required>
                    @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="admin-label-light">Web Sitesi Bağlantısı (URL)</label>
                    <input type="url" name="url" value="{{ old('url') }}" class="form-control admin-input-light" placeholder="https://www.ornekkurum.com.tr">
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Kurum / Marka Logosu</h5>
                <div class="mb-2">
                    <input type="file" name="image" class="dropify" data-height="180" data-allowed-file-extensions="png jpg jpeg webp svg gif">
                    <small class="text-muted mt-2 d-block"><i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i> PNG/SVG veya otomatik <strong>WebP (400×200)</strong>.</small>
                </div>
            </div>

            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Görüntülenme Sırası</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="form-control admin-input-light">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Aktif olarak yayınla</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Referansı Kaydet
                    </button>
                    <a href="{{ route('admin.references.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
