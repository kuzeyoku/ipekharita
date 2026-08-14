@extends('admin.layouts.master')

@section('title', 'Yeni Modal Duyuru Ekle')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Yeni Modal Duyuru Tanımla',
    'subtitle' => 'Ziyaretçilere pop-up pencerede gösterilecek duyuru veya kampanya görseli ekleyin.',
    'icon' => 'fa-plus',
    'backUrl' => route('admin.site-modals.index')
])

@include('admin.partials.alerts')

<form action="{{ route('admin.site-modals.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        
        <div class="col-lg-8">
            @include('admin.partials.translatable_fields', [
                'title'  => 'Modal İçeriği',
                'model'  => null,
                'fields' => [
                    ['name' => 'title', 'label' => 'Modal Başlığı', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: Yeni Şubemiz Açıldı!'],
                    ['name' => 'content', 'label' => 'Duyuru İçerik Metni', 'type' => 'editor', 'rows' => 5, 'placeholder' => 'Duyuru detay metni...'],
                    ['name' => 'btn_text', 'label' => 'Aksiyon Buton Metni', 'type' => 'text', 'placeholder' => 'Örn: Detaylı Bilgi'],
                ]
            ])

            <div class="admin-card-glass p-4">
                <div class="mb-0">
                    <label class="admin-label-light">Aksiyon Buton Linki (URL)</label>
                    <input type="text" name="btn_url" value="{{ old('btn_url') }}" class="form-control admin-input-light" placeholder="https://...">
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Modal Banner Görseli</h5>
                <input type="file" name="image" class="dropify" data-height="150" data-allowed-file-extensions="png jpg jpeg webp gif">
            </div>

            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Görünme Gecikmesi (Saniye)</label>
                    <input type="number" name="show_delay" value="{{ old('show_delay', 3) }}" class="form-control admin-input-light" min="0" max="60">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Pop-up pencereyi aktif olarak göster</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Modal Duyuruyu Kaydet
                    </button>
                    <a href="{{ route('admin.site-modals.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
