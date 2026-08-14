@extends('admin.layouts.master')

@section('title', 'Referans Düzenle — ' . $reference->title)

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Referans Düzenle: ' . $reference->title,
    'subtitle' => 'Mevcut marka veya idare logosunun bilgilerini ve bağlantısını güncelleyin.',
    'icon' => 'fa-pen-to-square',
    'backUrl' => route('admin.references.index')
])

@include('admin.partials.alerts')

<form action="{{ route('admin.references.update', $reference) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-4 border-bottom pb-2 font-outfit">Referans Bilgileri</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Kurum / Marka Adı *</label>
                    <input type="text" name="title" value="{{ old('title', $reference->title) }}" class="form-control admin-input-light @error('title') is-invalid @enderror" required>
                    @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="admin-label-light">Web Sitesi Bağlantısı (URL)</label>
                    <input type="url" name="url" value="{{ old('url', $reference->url) }}" class="form-control admin-input-light">
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Kurum / Marka Logosu</h5>
                @php
                    $imgPath = $reference->logo ?: $reference->image;
                @endphp
                @if($imgPath)
                    <div class="d-flex align-items-center gap-3 p-3 bg-light border rounded mb-2">
                        <img src="{{ asset(str_starts_with($imgPath, 'storage/') || str_starts_with($imgPath, 'assets/') ? $imgPath : 'storage/' . $imgPath) }}" alt="{{ $reference->title }}" style="max-height: 50px; max-width: 120px; object-fit: contain;">
                        <div class="form-check m-0">
                            <input type="checkbox" name="remove_image" id="remove_image" value="1" class="form-check-input">
                            <label for="remove_image" class="form-check-label text-danger small fw-semibold">Mevcut Logoyu Sil</label>
                        </div>
                    </div>
                @endif
                <input type="file" name="image" class="dropify" data-height="150" data-allowed-file-extensions="png jpg jpeg webp svg gif">
            </div>

            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Görüntülenme Sırası</label>
                    <input type="number" name="order" value="{{ old('order', $reference->order) }}" class="form-control admin-input-light">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Aktif olarak yayınla</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $reference->is_active) ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Değişiklikleri Kaydet
                    </button>
                    <a href="{{ route('admin.references.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
