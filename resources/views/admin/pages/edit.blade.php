@extends('admin.layouts.master')

@section('title', 'Sayfa Düzenle — ' . $page->title)

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Sayfa Düzenle: ' . Str::limit($page->title, 40),
    'subtitle' => 'Mevcut sayfanın içeriğini, görsellerini ve SEO ayarlarını güncelleyin.',
    'icon' => 'fa-pen-to-square',
    'backUrl' => route('admin.pages.index')
])

@include('admin.partials.alerts')

@php
    $tr = $page->translation('tr');
    $en = $page->translation('en');
@endphp

<form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Sol Ana İçerik Sütunu -->
        <div class="col-lg-8">
            @include('admin.partials.translatable_fields', [
                'title'  => 'Sayfa İçeriği & SEO',
                'model'  => $page,
                'fields' => [
                    ['name' => 'title', 'label' => 'Sayfa Başlığı', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: Kalite Politikamız'],
                    ['name' => 'summary', 'label' => 'Özet Açıklama', 'type' => 'textarea', 'rows' => 3, 'placeholder' => 'Sayfa hakkında kısa özet...'],
                    ['name' => 'content', 'label' => 'Detaylı Sayfa Metni', 'type' => 'editor', 'rows' => 8, 'placeholder' => 'Sayfa detay metni...'],
                ]
            ])
        </div>

        <!-- Sağ Yan Sütun (Resim Üstte, Yayın Ayarları Altta) -->
        <div class="col-lg-4">
            <!-- 1. Görsel Kartı (En Üstte) -->
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Sayfa Görseli</h5>
                <div class="mb-2">
                    <input type="file" name="image" class="dropify" data-height="180" data-default-file="{{ $page->image ? asset(str_starts_with($page->image, 'storage/') || str_starts_with($page->image, 'assets/') ? $page->image : 'storage/' . $page->image) : '' }}" data-allowed-file-extensions="png jpg jpeg webp gif">
                    <small class="text-muted mt-2 d-block"><i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i> Otomatik <strong>WebP 1200×800</strong> optimize edilir.</small>
                </div>
            </div>

            <!-- 2. Yayın Ayarları -->
            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Görüntülenme Sıralaması</label>
                    <input type="number" name="order" value="{{ old('order', $page->order) }}" class="form-control admin-input-light">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Sitede aktif görüntülensin</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $page->is_active ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Değişiklikleri Kaydet
                    </button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
