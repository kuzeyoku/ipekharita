@extends('admin.layouts.master')

@section('title', 'Blog Düzenle — ' . $post->title)

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Blog Makalesi Düzenle: ' . Str::limit($post->title, 40),
    'subtitle' => 'Mevcut blog yazısının metnini, yazarını ve kapak görselini güncelleyin.',
    'icon' => 'fa-pen-to-square',
    'backUrl' => route('admin.blog.index')
])

@include('admin.partials.alerts')

@php
    $tr = $post->translation('tr');
    $en = $post->translation('en');
@endphp

<form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        
        <div class="col-lg-8">
            @include('admin.partials.translatable_fields', [
                'title'  => 'Makale / Haber İçeriği',
                'model'  => $post,
                'fields' => [
                    ['name' => 'title', 'label' => 'Makale Başlığı', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: Kadastro Yenilemede Yeni Teknolojik Yaklaşımlar'],
                    ['name' => 'summary', 'label' => 'Özet Açıklama', 'type' => 'textarea', 'rows' => 3, 'required' => true, 'placeholder' => 'Makale kartında ve özet alanlarında görünecek kısa giriş metni...'],
                    ['name' => 'content', 'label' => 'Detaylı Makale Metni', 'type' => 'editor', 'rows' => 8, 'placeholder' => 'Makale detaylı metni...'],
                ]
            ])
        </div>

        <div class="col-lg-4">
            
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Makale Kapak Görseli</h5>
                <div class="mb-2">
                    <input type="file" name="image" class="dropify" data-height="180" data-default-file="{{ $post->image ? asset(str_starts_with($post->image, 'storage/') || str_starts_with($post->image, 'assets/') ? $post->image : 'storage/' . $post->image) : '' }}" data-allowed-file-extensions="png jpg jpeg webp gif">
                    <small class="text-muted mt-2 d-block"><i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i> Otomatik <strong>WebP 1200×800</strong> optimize edilir.</small>
                </div>
            </div>

            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Blog Kategorisi</label>
                    <select name="category_id" class="form-select admin-input-light">
                        <option value="">Kategori Seçiniz</option>
                        @if(isset($categories))
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label class="admin-label-light">Yazar Adı</label>
                    <input type="text" name="author" value="{{ old('author', $post->author) }}" class="form-control admin-input-light">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Sitede aktif görüntülensin</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ $post->is_published ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Değişiklikleri Kaydet
                    </button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
