@extends('admin.layouts.master')

@section('title', 'Kategori Düzenle — ' . $category->title)

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Kategori Düzenle: ' . $category->title,
    'subtitle' => 'Mevcut kategori adını ve aktiflik durumunu güncelleyin.',
    'icon' => 'fa-pen-to-square',
    'backUrl' => route('admin.categories.index')
])

@include('admin.partials.alerts')

@php
    $tr = $category->translation('tr');
    $en = $category->translation('en');
@endphp

<div class="admin-card-glass">
    <div class="admin-card-body-light p-4">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="admin-label-light">Ait Olduğu Modül Türü *</label>
                <select name="type" class="form-select admin-input-light @error('type') is-invalid @enderror" required style="max-width: 400px;">
                    <option value="blog" {{ old('type', $category->type) == 'blog' ? 'selected' : '' }}>Blog & Haberler</option>
                    <option value="project" {{ old('type', $category->type) == 'project' ? 'selected' : '' }}>Projeler</option>
                    <option value="service" {{ old('type', $category->type) == 'service' ? 'selected' : '' }}>Hizmetler</option>
                </select>
                @error('type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            @include('admin.partials.translatable_fields', [
                'title'  => 'Kategori Bilgileri',
                'model'  => $category,
                'fields' => [
                    ['name' => 'title', 'label' => 'Kategori Adı', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: Kadastro Yenileme'],
                    ['name' => 'description', 'label' => 'Kısa Açıklama', 'type' => 'text', 'placeholder' => 'Kategori hakkında kısa açıklama'],
                ]
            ])

            <div class="row g-3 my-2" style="max-width: 400px;">
                <div class="col-12">
                    <label class="admin-label-light">Sıralama</label>
                    <input type="number" name="order" value="{{ old('order', $category->order) }}" class="form-control admin-input-light">
                </div>
            </div>

            <div class="mb-4" style="max-width: 400px;">
                <div class="switch-card">
                    <div>
                        <span class="d-block fw-bold text-dark small">Kategori Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Sistemde aktif olarak kullanılsın</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                    </div>
                </div>
            </div>

            <div class="border-top pt-3 d-flex gap-2">
                <button type="submit" class="btn btn-enterprise-admin">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Değişiklikleri Kaydet
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light border rounded-3">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
