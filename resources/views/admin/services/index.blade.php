@extends('admin.layouts.master')

@section('title', 'Hizmet Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Hizmet Yönetimi',
    'subtitle' => 'Web sitesinde sunulan hizmetleri ve detaylarını bu alandan yönetin.',
    'icon' => 'fa-cubes',
    'createUrl' => route('admin.services.create'),
    'createTitle' => 'Yeni Hizmet Ekle'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Hizmet ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $services->total() }} Hizmet</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Görsel</th>
                    <th>Hizmet Adı</th>
                    <th>Özet Açıklama</th>
                    <th>Sıra</th>
                    <th>Durum</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $svc)
                    <tr>
                        <td>
                            @if($svc->image)
                                <img src="{{ asset(str_starts_with($svc->image, 'storage/') || str_starts_with($svc->image, 'assets/') ? $svc->image : 'storage/' . $svc->image) }}" class="rounded-3 border thumb-img-sm" alt="{{ $svc->title }}">
                            @else
                                <div class="stat-icon-square icon-blue-gradient rounded-3 thumb-img-sm justify-content-center">
                                    <i class="{{ $svc->icon ?: 'fa-solid fa-layer-group' }}"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $svc->title }}</span>
                            <span class="text-muted fs-xs font-mono">/hizmet/{{ $svc->slug }}</span>
                        </td>
                        <td class="text-secondary small text-truncate mw-400">
                            {{ $svc->summary }}
                        </td>
                        <td><span class="badge bg-light text-dark border px-2 py-1 font-mono">{{ $svc->order }}</span></td>
                        <td>
                            @if($svc->is_active)
                                <span class="badge badge-pill-enterprise badge-pill-success">Aktif</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-muted">Pasif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.services.edit', $svc) }}" class="table-action-btn" title="Düzenle">
                                    {!! render_svg_icon('edit') !!}
                                </a>
                                <form action="{{ route('admin.services.destroy', $svc) }}" method="POST" class="d-inline" data-confirm="Bu hizmeti ve kapak görselini silmek istediğinizden emin misiniz?">
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
                                'icon' => 'fa-cubes',
                                'title' => 'Henüz Hizmet Eklenmedi',
                                'message' => 'Sistemde tanımlı uzmanlık hizmeti bulunmuyor.',
                                'createUrl' => route('admin.services.create'),
                                'createTitle' => 'İlk Hizmeti Ekle'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($services->hasPages())
        <div class="admin-card-body-light border-top py-3 d-flex justify-content-end">
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
