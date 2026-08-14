@extends('admin.layouts.master')

@section('title', 'Proje Düzenle — ' . $project->title)

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Proje Düzenle: ' . Str::limit($project->title, 40),
    'subtitle' => 'Mevcut projenin içeriğini, lokasyonunu ve kapak görselini güncelleyin.',
    'icon' => 'fa-pen-to-square',
    'backUrl' => route('admin.projects.index')
])

@include('admin.partials.alerts')

@php
    $tr = $project->translation('tr');
    $en = $project->translation('en');
@endphp

<form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Sol Ana İçerik Sütunu -->
        <div class="col-lg-8">
            @include('admin.partials.translatable_fields', [
                'title'  => 'Proje Detayları',
                'model'  => $project,
                'fields' => [
                    ['name' => 'title', 'label' => 'Proje Başlığı', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: Muğla 22/a Kadastro Yenileme Projesi'],
                    ['name' => 'location', 'label' => 'Lokasyon / Şehir', 'type' => 'text', 'col' => 'col-md-6', 'placeholder' => 'Muğla / Menteşe'],
                    ['name' => 'client', 'label' => 'İşveren / İdare', 'type' => 'text', 'col' => 'col-md-6', 'placeholder' => 'TKGM Genel Müdürlüğü'],
                    ['name' => 'summary', 'label' => 'Özet Açıklama', 'type' => 'textarea', 'rows' => 3, 'required' => true, 'placeholder' => 'Kartlarda görünecek kısa özet...'],
                    ['name' => 'description', 'label' => 'Detaylı Proje Metni', 'type' => 'editor', 'rows' => 6, 'placeholder' => 'Projenin teknik kapsamı, hektar bilgisi ve detaylar...'],
                ]
            ])
        </div>

        <!-- Sağ Yan Sütun (Resim Üstte, Yayın Ayarları Altta) -->
        <div class="col-lg-4">
            <!-- 1. Görsel Kartı (En Üstte) -->
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Proje Kapak Görseli</h5>
                <div class="mb-2">
                    <input type="file" name="image" class="dropify" data-height="180" data-default-file="{{ $project->image ? asset(str_starts_with($project->image, 'storage/') || str_starts_with($project->image, 'assets/') ? $project->image : 'storage/' . $project->image) : '' }}" data-allowed-file-extensions="png jpg jpeg webp gif">
                    <small class="text-muted mt-2 d-block"><i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i> Otomatik <strong>WebP 1200×800</strong> optimize edilir.</small>
                </div>
            </div>

            <!-- 2. Yayın & Kategori Ayarları -->
            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Proje Kategorisi</label>
                    <select name="category_id" class="form-select admin-input-light">
                        <option value="">Kategori Seçiniz</option>
                        @if(isset($categories))
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $project->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label class="admin-label-light">Sıralama</label>
                    <input type="number" name="order" value="{{ old('order', $project->order) }}" class="form-control admin-input-light">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Proje Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Tamamlandı olarak işaretle</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_completed" id="is_completed" value="1" {{ $project->is_completed ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Değişiklikleri Kaydet
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
