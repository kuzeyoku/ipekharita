@extends('admin.layouts.master')

@section('title', 'Proje Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Proje Yönetimi',
    'subtitle' => 'Projeleri, detaylarını ve kategorilerini bu alandan yönetin.',
    'icon' => 'fa-diagram-project',
    'createUrl' => route('admin.projects.create'),
    'createTitle' => 'Yeni Proje Ekle'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Proje ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $projects->total() }} Proje</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Görsel</th>
                    <th>Proje Başlığı</th>
                    <th>Kategori</th>
                    <th>İşveren / İdare</th>
                    <th>Yıl</th>
                    <th>Durum</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $proj)
                    <tr>
                        <td>
                            @if($proj->image)
                                <img src="{{ asset(str_starts_with($proj->image, 'storage/') || str_starts_with($proj->image, 'assets/') ? $proj->image : 'storage/' . $proj->image) }}" class="rounded-3 border thumb-img-sm" alt="{{ $proj->title }}">
                            @else
                                <div class="stat-icon-square icon-gold-gradient rounded-3 thumb-img-sm justify-content-center">
                                    <i class="fa-solid fa-route"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $proj->title }}</span>
                            <span class="text-muted fs-xs"><i class="fa-solid fa-location-dot me-1 text-primary"></i> {{ $proj->location ?: 'Türkiye' }}</span>
                        </td>
                        <td><span class="badge badge-pill-enterprise badge-pill-info">{{ data_get($proj, 'categoryRel.title') ?: ($proj->category ?: 'Haritacılık') }}</span></td>
                        <td class="text-secondary small">{{ $proj->client ?: '-' }}</td>
                        <td class="text-muted small font-mono">{{ $proj->year ?: '-' }}</td>
                        <td>
                            @if($proj->is_completed)
                                <span class="badge badge-pill-enterprise badge-pill-success">Tamamlandı</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-warning">Devam Ediyor</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.projects.edit', $proj) }}" class="table-action-btn" title="Düzenle">
                                    {!! render_svg_icon('edit') !!}
                                </a>
                                <form action="{{ route('admin.projects.destroy', $proj) }}" method="POST" class="d-inline" data-confirm="Bu projeyi ve kapak görselini silmek istediğinizden emin misiniz?">
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
                        <td colspan="7">
                            @include('admin.partials.empty_state', [
                                'icon' => 'fa-diagram-project',
                                'title' => 'Henüz Kayıtlı Proje Bulunmuyor',
                                'message' => 'Sistemde henüz eklenmiş referans proje bulunmuyor.',
                                'createUrl' => route('admin.projects.create'),
                                'createTitle' => 'İlk Projeyi Ekle'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($projects->hasPages())
        <div class="admin-card-body-light border-top py-3 d-flex justify-content-end">
            {{ $projects->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
