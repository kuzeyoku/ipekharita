@extends('admin.layouts.master')

@section('title', 'Yeni Blog / Haber Ekle')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Yeni Blog Makalesi / Haber Ekle',
    'subtitle' => 'Sektörel makale, teknik duyuru veya haber metni oluşturun.',
    'icon' => 'fa-plus',
    'backUrl' => route('admin.blog.index')
])

@include('admin.partials.alerts')

<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Sol Ana İçerik Sütunu -->
        <div class="col-lg-8">
            @include('admin.partials.translatable_fields', [
                'title'  => 'Makale / Haber İçeriği',
                'model'  => null,
                'fields' => [
                    ['name' => 'title', 'label' => 'Makale Başlığı', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: Kadastro Yenilemede Yeni Teknolojik Yaklaşımlar'],
                    ['name' => 'summary', 'label' => 'Özet Açıklama', 'type' => 'textarea', 'rows' => 3, 'required' => true, 'placeholder' => 'Makale kartında ve özet alanlarında görünecek kısa giriş metni...'],
                    ['name' => 'content', 'label' => 'Detaylı Makale Metni', 'type' => 'editor', 'rows' => 8, 'placeholder' => 'Makale detaylı metni...'],
                ]
            ])
        </div>

        <!-- Sağ Yan Sütun (Resim Üstte, Yayın Ayarları Altta) -->
        <div class="col-lg-4">
            <!-- 1. Görsel Kartı (En Üstte) -->
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Makale Kapak Görseli</h5>
                <div class="mb-2">
                    <input type="file" name="image" class="dropify" data-height="180" data-allowed-file-extensions="png jpg jpeg webp gif">
                    <small class="text-muted mt-2 d-block"><i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i> Otomatik <strong>WebP 1200×800</strong> optimize edilir.</small>
                </div>
            </div>

            <!-- 2. Yayın & Kategori Ayarları -->
            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Blog Kategorisi</label>
                    <select name="category_id" class="form-select admin-input-light">
                        <option value="">Kategori Seçiniz</option>
                        @if(isset($categories))
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label class="admin-label-light">Yazar Adı</label>
                    <input type="text" name="author" value="{{ old('author', auth()->user()->name ?? 'İpek Mühendislik') }}" class="form-control admin-input-light">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Hemen yayına al</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Makaleyi Kaydet
                    </button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
