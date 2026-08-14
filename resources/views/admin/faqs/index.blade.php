@extends('admin.layouts.master')

@section('title', 'Sıkça Sorulan Sorular (SSS) Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'SSS Yönetimi',
    'subtitle' => 'Hizmetler, Projeler veya Genel site sayfaları için soru-cevap havuzunu yönetin.',
    'icon' => 'fa-circle-question',
    'createUrl' => route('admin.faqs.create'),
    'createTitle' => 'Yeni SSS Ekle'
])

@include('admin.partials.alerts')

<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm {{ !$moduleType ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3 fw-semibold">
        Tüm SSS'ler
    </a>
    <a href="{{ route('admin.faqs.index', ['module_type' => 'service']) }}" class="btn btn-sm {{ $moduleType == 'service' ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3 fw-semibold">
        <i class="fa-solid fa-layer-group me-1"></i> Hizmet SSS'leri
    </a>
    <a href="{{ route('admin.faqs.index', ['module_type' => 'project']) }}" class="btn btn-sm {{ $moduleType == 'project' ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3 fw-semibold">
        <i class="fa-solid fa-route me-1"></i> Proje SSS'leri
    </a>
    <a href="{{ route('admin.faqs.index', ['module_type' => 'general']) }}" class="btn btn-sm {{ $moduleType == 'general' ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3 fw-semibold">
        <i class="fa-solid fa-globe me-1"></i> Genel SSS'ler
    </a>
</div>

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Soru veya cevap ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $faqs->total() }} Soru</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">Sıra</th>
                    <th>Soru & Cevap Özeti</th>
                    <th>Ait Olduğu Modül</th>
                    <th>Özel İçerik Bağlantısı</th>
                    <th>Durum</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr>
                        <td>
                            <span class="badge bg-light text-dark border font-mono">{{ $faq->order }}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block mb-1">
                                <i class="fa-solid fa-circle-question text-primary me-1"></i> {{ $faq->question }}
                            </span>
                            <span class="text-muted small">
                                {{ Str::limit(strip_tags($faq->answer), 110) }}
                            </span>
                        </td>
                        <td>
                            @if($faq->module_type === 'service')
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1">
                                    <i class="fa-solid fa-layer-group me-1"></i> Hizmetler
                                </span>
                            @elseif($faq->module_type === 'project')
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2.5 py-1 text-dark">
                                    <i class="fa-solid fa-route me-1"></i> Projeler
                                </span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1">
                                    <i class="fa-solid fa-globe me-1"></i> Genel
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($faq->service)
                                <span class="text-dark small fw-semibold">
                                    <i class="fa-solid fa-link text-primary me-1"></i> {{ $faq->service->title }}
                                </span>
                            @elseif($faq->project)
                                <span class="text-dark small fw-semibold">
                                    <i class="fa-solid fa-link text-warning me-1"></i> {{ $faq->project->title }}
                                </span>
                            @else
                                <span class="text-muted small italic">Tüm Modül Genelinde</span>
                            @endif
                        </td>
                        <td>
                            @if($faq->is_active)
                                <span class="badge badge-pill-enterprise badge-pill-success">Aktif</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-muted">Pasif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="table-action-btn" title="Düzenle">
                                    {!! render_svg_icon('edit') !!}
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" data-confirm="Bu SSS kaydını silmek istediğinize emin misiniz?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="table-action-btn btn-danger-light border-0" title="Sil">
                                        {!! render_svg_icon('trash') !!}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            @include('admin.partials.empty_state', [
                                'icon' => 'fa-circle-question',
                                'title' => 'Henüz SSS Kaydı Bulunmuyor',
                                'message' => 'Yeni soru ve cevaplar ekleyerek ziyaretçilerinizin sorularını yanıtlayın.',
                                'createUrl' => route('admin.faqs.create'),
                                'createTitle' => 'İlk SSS Kaydını Ekle'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($faqs->hasPages())
        <div class="admin-card-body-light border-top py-3 d-flex justify-content-end">
            {{ $faqs->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
