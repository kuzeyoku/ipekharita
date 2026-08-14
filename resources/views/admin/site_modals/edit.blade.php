@extends('admin.layouts.master')

@section('title', 'Modal Duyuru Düzenle — ' . $siteModal->title)

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Modal Duyuru Düzenle: ' . $siteModal->title,
    'subtitle' => 'Mevcut duyuru pop-up penceresinin bilgilerini ve görselini güncelleyin.',
    'icon' => 'fa-pen-to-square',
    'backUrl' => route('admin.site-modals.index')
])

@include('admin.partials.alerts')

@php
    $tr = $siteModal->translation('tr');
    $en = $siteModal->translation('en');
@endphp

<form action="{{ route('admin.site-modals.update', $siteModal) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Sol Ana İçerik Sütunu -->
        <div class="col-lg-8">
            @include('admin.partials.translatable_fields', [
                'title'  => 'Modal İçeriği',
                'model'  => $siteModal,
                'fields' => [
                    ['name' => 'title', 'label' => 'Modal Başlığı', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: Yeni Şubemiz Açıldı!'],
                    ['name' => 'content', 'label' => 'Duyuru İçerik Metni', 'type' => 'editor', 'rows' => 5, 'placeholder' => 'Duyuru detay metni...'],
                    ['name' => 'btn_text', 'label' => 'Aksiyon Buton Metni', 'type' => 'text', 'placeholder' => 'Örn: Detaylı Bilgi'],
                ]
            ])

            <div class="admin-card-glass p-4">
                <div class="mb-0">
                    <label class="admin-label-light">Aksiyon Buton Linki (URL)</label>
                    <input type="text" name="btn_url" value="{{ old('btn_url', $siteModal->btn_url) }}" class="form-control admin-input-light">
                </div>
            </div>
        </div>

        <!-- Sağ Yan Sütun (Resim Üstte, Yayın Ayarları Altta) -->
        <div class="col-lg-4">
            <!-- 1. Görsel Kartı (En Üstte) -->
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Modal Banner Görseli</h5>
                @if($siteModal->image)
                    <div class="d-flex align-items-center gap-3 p-3 bg-light border rounded mb-2">
                        <img src="{{ asset(str_starts_with($siteModal->image, 'storage/') || str_starts_with($siteModal->image, 'assets/') ? $siteModal->image : 'storage/' . $siteModal->image) }}" alt="{{ $siteModal->title }}" style="max-height: 70px; max-width: 120px; object-fit: cover;" class="rounded">
                        <div class="form-check m-0">
                            <input type="checkbox" name="remove_image" id="remove_image" value="1" class="form-check-input">
                            <label for="remove_image" class="form-check-label text-danger small fw-semibold">Mevcut Görseli Sil</label>
                        </div>
                    </div>
                @endif
                <input type="file" name="image" class="dropify" data-height="150" data-allowed-file-extensions="png jpg jpeg webp gif">
            </div>

            <!-- 2. Yayın & Gecikme Ayarları -->
            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Görünme Gecikmesi (Saniye)</label>
                    <input type="number" name="show_delay" value="{{ old('show_delay', $siteModal->show_delay) }}" class="form-control admin-input-light" min="0" max="60">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Pop-up pencereyi aktif olarak göster</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $siteModal->is_active) ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Değişiklikleri Kaydet
                    </button>
                    <a href="{{ route('admin.site-modals.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
