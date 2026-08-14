@extends('admin.layouts.master')

@section('title', 'Hizmet Düzenle — ' . $service->title)

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Hizmet Düzenle: ' . Str::limit($service->title, 40),
    'subtitle' => 'Mevcut hizmet kolunun içeriğini, ikonunu ve kapak görselini güncelleyin.',
    'icon' => 'fa-pen-to-square',
    'backUrl' => route('admin.services.index')
])

@include('admin.partials.alerts')

@php
    $tr = $service->translation('tr');
    $en = $service->translation('en');
@endphp

<form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        
        <div class="col-lg-8">
            @include('admin.partials.translatable_fields', [
                'title'  => 'Hizmet İçeriği',
                'model'  => $service,
                'fields' => [
                    ['name' => 'title', 'label' => 'Hizmet Adı', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: 22/a Kadastro Yenileme'],
                    ['name' => 'summary', 'label' => 'Özet Açıklama', 'type' => 'textarea', 'rows' => 3, 'required' => true, 'placeholder' => 'Kartlarda ve özet alanlarında görünecek kısa açıklama...'],
                    ['name' => 'content', 'label' => 'Detaylı İçerik Metni', 'type' => 'editor', 'rows' => 6, 'placeholder' => 'Hizmet detay sayfasında görüntülenecek detaylı açıklama...'],
                ]
            ])

            <div class="admin-card-glass p-4">
                
                <div class="mb-0">
                    <label class="admin-label-light mb-1">Hizmet Vektör İkonu *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-primary fs-5" id="iconPreview">
                            {!! render_svg_icon(old('icon', $service->icon ?: 'map-location'), 'fs-4 text-primary') !!}
                        </span>
                        <input type="text" id="iconInput" name="icon" value="{{ old('icon', $service->icon) }}" class="form-control admin-input-light border-start-0 border-end-0" placeholder="map-location, city, plane-up">
                        <button type="button" class="btn btn-icon-picker px-3 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#iconPickerModal">
                            <i class="fa-solid fa-icons me-1"></i> <span>İkon Seç</span>
                        </button>
                    </div>
                    <span class="text-muted small d-block mt-1" style="font-size:0.78rem;">Sağdaki <strong>'İkon Seç'</strong> butonuna tıklayarak katalogdan kolayca seçebilirsiniz.</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Hizmet Kapak Görseli</h5>
                <div class="mb-2">
                    <input type="file" name="image" class="dropify" data-height="180" data-default-file="{{ $service->image ? asset(str_starts_with($service->image, 'storage/') || str_starts_with($service->image, 'assets/') ? $service->image : 'storage/' . $service->image) : '' }}" data-allowed-file-extensions="png jpg jpeg webp gif">
                    <small class="text-muted mt-2 d-block"><i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i> Otomatik <strong>WebP 800×600</strong> optimize edilir.</small>
                </div>
            </div>

            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Görüntülenme Sıralaması</label>
                    <input type="number" name="order" value="{{ old('order', $service->order) }}" class="form-control admin-input-light">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Sitede aktif görüntülensin</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $service->is_active ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Değişiklikleri Kaydet
                    </button>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>

@include('admin.partials.icon_picker_modal')

@endsection
