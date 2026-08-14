@extends('admin.layouts.master')

@section('title', 'Dil ve Çeviri Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Dil ve Çeviri Yönetimi',
    'subtitle' => 'Web sitesinin tüm dil dosyalarını, statik metinlerini ve çok dilli çeviri anahtarlarını tek merkezden yönetin.',
    'icon' => 'fa-language'
])

@include('admin.partials.alerts')

<div class="admin-card-glass mb-4">
    <div class="admin-card-body-light">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-3 border-bottom">
            <div>
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">
                    <i class="fa-solid fa-globe text-primary me-1"></i> Aktif Dil Seçimi
                </span>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    @foreach($locales as $code => $locale)
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.translations.index', ['locale' => $code, 'file' => $selectedFile]) }}" 
                               class="btn btn-sm {{ $selectedLocale === $code ? 'btn-primary shadow-sm text-white' : 'btn-outline-secondary' }} px-3 py-2 rounded-pill {{ $code !== 'tr' ? 'rounded-end-0 border-end-0' : '' }} fw-bold">
                                <span class="me-1">{{ $locale['flag'] ?? '🌐' }}</span> {{ $locale['name'] ?? strtoupper($code) }} ({{ strtoupper($code) }})
                                @if(!empty($locale['default']))
                                    <span class="badge bg-light text-dark ms-1" style="font-size: 0.65rem;">Varsayılan</span>
                                @endif
                            </a>
                            @if($code !== 'tr')
                                <button type="button" 
                                        class="btn btn-sm {{ $selectedLocale === $code ? 'btn-primary text-white-50' : 'btn-outline-secondary' }} rounded-pill rounded-start-0 delete-language-btn px-2" 
                                        data-locale="{{ $code }}"
                                        data-name="{{ $locale['name'] ?? strtoupper($code) }}"
                                        title="{{ $locale['name'] ?? strtoupper($code) }} dilini sil">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#addLanguageModal">
                    <i class="fa-solid fa-plus me-1"></i> Yeni Dil Ekle
                </button>
            </div>
        </div>

        {{-- Translation Files Navigation --}}
        <div class="pt-3">
            <span class="text-muted small fw-semibold text-uppercase d-block mb-2">
                <i class="fa-solid fa-folder-open text-warning me-1"></i> Modül / Dil Dosyası Seçimi ({{ strtoupper($selectedLocale) }})
            </span>
            <div class="d-flex flex-wrap gap-2">
                @foreach($files as $file)
                    <a href="{{ route('admin.translations.index', ['locale' => $selectedLocale, 'file' => $file]) }}" 
                       class="btn btn-sm {{ $selectedFile === $file ? 'btn-dark text-white shadow-sm' : 'btn-light border text-secondary' }} px-3 py-2 rounded-3 fw-medium">
                        <i class="fa-solid {{ $file === '_json' ? 'fa-file-code' : 'fa-file-lines' }} me-1 text-primary"></i> 
                        {{ $file === '_json' ? $selectedLocale . '.json' : $file . '.php' }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Main Translation Editor Card --}}
<div class="admin-card-glass">
    <div class="admin-card-body-light">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-3 mb-4 border-bottom">
            <div>
                <h5 class="fw-bold mb-1 text-dark">
                    <i class="fa-solid fa-pen-to-square text-primary me-2"></i>
                    <code>{{ $selectedLocale }}/{{ $selectedFile === '_json' ? $selectedLocale . '.json' : $selectedFile . '.php' }}</code> Çevirileri
                </h5>
                <span class="text-muted small">
                    Toplam <strong class="text-primary">{{ count($translations) }}</strong> adet çeviri anahtarı listeleniyor.
                </span>
            </div>

            <div class="d-flex gap-2 align-items-center">
                {{-- Quick Filter Input --}}
                <div class="input-group input-group-sm" style="max-width: 260px;">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" id="translationSearch" class="form-control border-start-0" placeholder="Anahtar veya metin ara...">
                </div>

                {{-- Add Key Button --}}
                <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addKeyModal">
                    <i class="fa-solid fa-plus me-1"></i> Yeni Anahtar
                </button>
            </div>
        </div>

        @if(empty($translations))
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-circle-exclamation fa-3x mb-3 text-warning"></i>
                <h6>Bu dil dosyasında henüz çeviri anahtarı bulunamadı.</h6>
                <p class="small">Yukarıdaki "Yeni Anahtar Ekle" butonunu kullanarak yeni çeviri anahtarları ekleyebilirsiniz.</p>
            </div>
        @else
            <form action="{{ route('admin.translations.update') }}" method="POST" id="translationsForm">
                @csrf
                <input type="hidden" name="locale" value="{{ $selectedLocale }}">
                <input type="hidden" name="file" value="{{ $selectedFile }}">

                <div class="row g-3" id="translationList">
                    @foreach($translations as $key => $value)
                        <div class="col-12 translation-row" data-search="{{ strtolower($key . ' ' . $value) }}">
                            <div class="p-3 bg-light border rounded-3 transition-hover">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-secondary bg-opacity-10 text-primary font-mono fw-bold px-2 py-1">
                                            <i class="fa-solid fa-key text-warning me-1"></i> {{ $key }}
                                        </span>
                                        <small class="text-muted font-mono">
                                            __('{{ $selectedFile }}.{{ $key }}')
                                        </small>
                                    </div>

                                    <div>
                                        <button type="button" class="btn btn-link text-danger p-0 delete-key-btn" 
                                                data-key="{{ $key }}" title="Bu anahtarı sil">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- If editing non-TR locale: Show Turkish reference --}}
                                @if($selectedLocale !== 'tr' && isset($baseTranslations[$key]))
                                    <div class="mb-2 p-2 bg-white border border-light-subtle rounded small">
                                        <span class="text-muted fw-semibold d-block" style="font-size: 0.72rem;">
                                            <i class="fa-solid fa-language text-secondary me-1"></i> TÜRKÇE REFERANS:
                                        </span>
                                        <span class="text-dark">{{ $baseTranslations[$key] }}</span>
                                    </div>
                                @endif

                                {{-- Smart input: Textarea for longer texts, text input for single line --}}
                                @if(strlen($value) > 75 || str_contains($key, 'desc') || str_contains($key, 'content') || str_contains($key, 'summary') || str_contains($key, 'history') || str_contains($key, 'subtitle'))
                                    <textarea name="keys[{{ $key }}]" rows="3" class="form-control admin-input-light font-sans" required>{{ $value }}</textarea>
                                @else
                                    <input type="text" name="keys[{{ $key }}]" value="{{ $value }}" class="form-control admin-input-light font-sans" required>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        <i class="fa-solid fa-info-circle me-1 text-primary"></i> Kaydettiğinizde sistem önbelleği ve derlenmiş görünümler otomatik olarak yenilenir.
                    </span>

                    <button type="submit" class="btn btn-enterprise-admin px-5 py-3 shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Çevirileri Kaydet ({{ strtoupper($selectedLocale) }})
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

{{-- Modal: Add New Translation Key --}}
<div class="modal fade" id="addKeyModal" tabindex="-1" aria-labelledby="addKeyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.translations.add-key') }}" method="POST">
                @csrf
                <input type="hidden" name="locale" value="{{ $selectedLocale }}">
                <input type="hidden" name="file" value="{{ $selectedFile }}">

                <div class="modal-header border-bottom">
                    <h6 class="modal-title fw-bold" id="addKeyModalLabel">
                        <i class="fa-solid fa-plus-circle text-success me-1"></i> Yeni Çeviri Anahtarı Ekle
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Hedef Dosya & Dil</label>
                        <input type="text" class="form-control bg-light" value="{{ $selectedLocale }}/{{ $selectedFile }}.php" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Anahtar Adı (Key) <span class="text-danger">*</span></label>
                        <input type="text" name="key" class="form-control" placeholder="örneğin: hero_title veya header.cta_btn" required>
                        <div class="form-text small">Nokta (.) kullanarak iç içe gruplar oluşturabilirsiniz (örneğin: <code>header.btn_text</code>).</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Çeviri Metni (Değer)</label>
                        <textarea name="value" rows="3" class="form-control" placeholder="Çeviri metnini giriniz..."></textarea>
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-plus me-1"></i> Anahtarı Ekle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal: Add New Language --}}
<div class="modal fade" id="addLanguageModal" tabindex="-1" aria-labelledby="addLanguageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.translations.store-language') }}" method="POST">
                @csrf

                <div class="modal-header border-bottom">
                    <h6 class="modal-title fw-bold" id="addLanguageModalLabel">
                        <i class="fa-solid fa-globe text-primary me-1"></i> Yeni Dil Ekle
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Dil Kodu (ISO 639-1) <span class="text-danger">*</span></label>
                        <input type="text" name="locale" class="form-control" placeholder="örneğin: de, fr, ar, ru, es" required maxlength="5">
                        <div class="form-text small">Yeni dil oluşturulduğunda sistem otomatik olarak <code>lang/{dil_kodu}</code> klasörünü açar ve temel şablon dosyalarını kopyalar.</div>
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-check me-1"></i> Dili Oluştur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Hidden Form for Delete Key --}}
<form id="deleteKeyForm" action="{{ route('admin.translations.delete-key') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="locale" value="{{ $selectedLocale }}">
    <input type="hidden" name="file" value="{{ $selectedFile }}">
    <input type="hidden" name="key" id="deleteKeyInput">
</form>

{{-- Hidden Form for Delete Language --}}
<form id="deleteLanguageForm" action="{{ route('admin.translations.delete-language') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="locale" id="deleteLanguageInput">
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick search filter
    const searchInput = document.getElementById('translationSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.translation-row');
            
            rows.forEach(function(row) {
                const text = row.getAttribute('data-search') || '';
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Delete key confirmation
    const deleteButtons = document.querySelectorAll('.delete-key-btn');
    deleteButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const key = this.getAttribute('data-key');
            if (confirm(`"${key}" anahtarını silmek istediğinizden emin misiniz?`)) {
                document.getElementById('deleteKeyInput').value = key;
                document.getElementById('deleteKeyForm').submit();
            }
        });
    });

    // Delete language confirmation
    const deleteLangButtons = document.querySelectorAll('.delete-language-btn');
    deleteLangButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const locale = this.getAttribute('data-locale');
            const name = this.getAttribute('data-name');
            if (confirm(`"${name} (${locale.toUpperCase()})" dilini ve bu dile ait TÜM ÇEVİRİ DOSYALARINI sistemden tamamen silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!`)) {
                document.getElementById('deleteLanguageInput').value = locale;
                document.getElementById('deleteLanguageForm').submit();
            }
        });
    });
});
</script>
@endpush
@endsection
