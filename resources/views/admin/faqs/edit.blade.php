@extends('admin.layouts.master')

@section('title', 'SSS Düzenle')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'SSS Düzenle',
    'subtitle' => '#' . $faq->id . ' numaralı SSS kaydını güncelleyin.',
    'icon' => 'fa-pen-to-square',
    'backUrl' => route('admin.faqs.index')
])

@include('admin.partials.alerts')

<form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        
        <div class="col-lg-8">
            @include('admin.partials.translatable_fields', [
                'title'  => 'Soru & Cevap İçeriği',
                'model'  => $faq,
                'fields' => [
                    ['name' => 'question', 'label' => 'Soru Metni', 'type' => 'text', 'required' => true, 'placeholder' => 'Örn: 22/a Kadastro Yenileme Projelerinde Hangi Teknik Standartlar Uygulanır?'],
                    ['name' => 'answer', 'label' => 'Detaylı Cevap Metni', 'type' => 'textarea', 'rows' => 6, 'required' => true, 'placeholder' => 'Sorunun detaylı teknik cevabını yazınız...'],
                ]
            ])
        </div>

        <div class="col-lg-4">
            <div class="admin-card-glass p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Modül Bağlantısı</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Ait Olduğu Modül Türü *</label>
                    <select name="module_type" id="moduleTypeSelect" class="form-select admin-input-light @error('module_type') is-invalid @enderror" required>
                        <option value="general" {{ old('module_type', $faq->module_type) == 'general' ? 'selected' : '' }}>Genel SSS (Tüm Sayfalar)</option>
                        <option value="service" {{ old('module_type', $faq->module_type) == 'service' ? 'selected' : '' }}>Hizmetler Modülü</option>
                        <option value="project" {{ old('module_type', $faq->module_type) == 'project' ? 'selected' : '' }}>Projeler Modülü</option>
                    </select>
                    @error('module_type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3" id="serviceSelectorWrapper" style="display: none;">
                    <label class="admin-label-light">Özel Hizmet Seçimi</label>
                    <select name="service_id" class="form-select admin-input-light">
                        <option value="">-- Tüm Hizmetler Genelinde --</option>
                        @foreach($services as $srv)
                            <option value="{{ $srv->id }}" {{ old('service_id', $faq->service_id) == $srv->id ? 'selected' : '' }}>{{ $srv->title }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">Belirli bir hizmet seçerseniz, SSS sadece o hizmetin detayında görünür.</small>
                </div>

                <div class="mb-3" id="projectSelectorWrapper" style="display: none;">
                    <label class="admin-label-light">Özel Proje Seçimi</label>
                    <select name="project_id" class="form-select admin-input-light">
                        <option value="">-- Tüm Projeler Genelinde --</option>
                        @foreach($projects as $prj)
                            <option value="{{ $prj->id }}" {{ old('project_id', $faq->project_id) == $prj->id ? 'selected' : '' }}>{{ $prj->title }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">Belirli bir proje seçerseniz, SSS o projenin detayında görünür.</small>
                </div>
            </div>

            <div class="admin-card-glass p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-outfit">Yayın Ayarları</h5>

                <div class="mb-3">
                    <label class="admin-label-light">Görüntülenme Sıralaması</label>
                    <input type="number" name="order" value="{{ old('order', $faq->order) }}" class="form-control admin-input-light">
                </div>

                <div class="switch-card mb-4">
                    <div>
                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                        <span class="text-muted small" style="font-size: 0.78rem;">Sitede aktif görüntülensin</span>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-enterprise-admin w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Değişiklikleri Kaydet
                    </button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-light border rounded-3">İptal</a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const moduleSelect = document.getElementById('moduleTypeSelect');
        const serviceWrapper = document.getElementById('serviceSelectorWrapper');
        const projectWrapper = document.getElementById('projectSelectorWrapper');

        function toggleWrappers() {
            const val = moduleSelect.value;
            serviceWrapper.style.display = (val === 'service') ? 'block' : 'none';
            projectWrapper.style.display = (val === 'project') ? 'block' : 'none';
        }

        moduleSelect.addEventListener('change', toggleWrappers);
        toggleWrappers();
    });
</script>
@endpush
@endsection
