@extends('admin.layouts.master')

@section('title', 'Yeni Hizmet Ekle')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Yeni Hizmet Ekle',
    'subtitle' => 'Sisteme yeni bir uzmanlık alanı ve hizmet metni tanımlayın.',
    'icon' => 'fa-plus',
    'backUrl' => route('admin.services.index')
])

@include('admin.partials.alerts')

<form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Sol Ana İçerik Sütunu -->
        <div class="col-lg-8">
            @include('admin.partials.translatable_fields', [
                'title'  => 'Hizmet İçeriği',
                'model'  => null,
                'fields' => [
                    ['name' => 'title', 'label' => 'Hizmet Adı', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: 22/a Kadastro Yenileme'],
                    ['name' => 'summary', 'label' => 'Özet Açıklama', 'type' => 'textarea', 'rows' => 3, 'required' => true, 'placeholder' => 'Kartlarda ve özet alanlarında görünecek kısa açıklama...'],
                    ['name' => 'content', 'label' => 'Detaylı İçerik Metni', 'type' => 'editor', 'rows' => 6, 'placeholder' => 'Hizmet detay sayfasında görüntülenecek detaylı açıklama...'],
                ]
            ])

            <div class="admin-card-glass p-4">
                <!-- İkon Seçimi (Dilden Bağımsız Ortak Alan) -->
                <div class="mb-0">
                    <label class="admin-label-light mb-1">Hizmet Vektör İkonu *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-primary fs-5" id="iconPreview">
                            {!! render_svg_icon(old('icon', 'map-location'), 'fs-4 text-primary') !!}
                        </span>
                        <input type="text" id="iconInput" name="icon" value="{{ old('icon', 'map-location') }}" class="form-control admin-input-light border-start-0 border-end-0" placeholder="map-location, city, plane-up">
                        <button type="button" class="btn btn-icon-picker px-3 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#iconPickerModal">
                            <i class="fa-solid fa-icons me-1"></i> <span>İkon Seç</span>
                        </button>
                    </div>
                    <span class="text-muted small d-block mt-1" style="font-size:0.78rem;">Sağdaki <strong>'İkon Seç'</strong> butonuna tıklayarak katalogdan kolayca seçebilirsiniz.</span>
                </div>
            </div>
        </div>

        <!-- Sağ Yan Sütun (Resim Üstte, Yayın Ayarları Altta) -->
        <div class="col-lg-4">
            <!-- 1. Görsel Kartı (En Üstte) -->
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Hizmet Kapak Görseli</h5>
                <div class="mb-2">
                    <input type="file" name="image" class="dropify" data-height="180" data-allowed-file-extensions="png jpg jpeg webp gif">
                    <small class="text-muted mt-2 d-block"><i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i> Otomatik <strong>WebP 800×600</strong> optimize edilir.</small>
                </div>
            </div>

            <!-- 2. Yayın & Hizalama Ayarları -->
            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Görüntülenme Sıralaması</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="form-control admin-input-light">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Sitede aktif görüntülensin</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Hizmeti Kaydet
                    </button>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>

@include('admin.partials.icon_picker_modal')

@endsection
