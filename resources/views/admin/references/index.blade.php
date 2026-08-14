@extends('admin.layouts.master')

@section('title', 'Referans Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Referans Yönetimi',
    'subtitle' => 'Web sitesinde gösterilen marka ve idare logolarının yönetimi.',
    'icon' => 'fa-handshake',
    'createUrl' => route('admin.references.create'),
    'createTitle' => 'Yeni Referans Ekle'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Referans ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $references->total() }} Referans</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">Logo</th>
                    <th>Kurum / Marka Adı</th>
                    <th>Bağlantı URL</th>
                    <th>Sıra</th>
                    <th>Durum</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($references as $item)
                    @php
                        $imgPath = $item->logo ?: $item->image;
                    @endphp
                    <tr>
                        <td>
                            @if($imgPath)
                                <img src="{{ asset(str_starts_with($imgPath, 'storage/') || str_starts_with($imgPath, 'assets/') ? $imgPath : 'storage/' . $imgPath) }}" alt="{{ $item->title }}" class="img-fluid rounded border bg-white p-1" style="max-height: 40px; max-width: 60px; object-fit: contain;">
                            @else
                                <div class="stat-icon-square icon-blue-gradient rounded thumb-img-sm justify-content-center text-muted">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $item->title }}</span>
                        </td>
                        <td>
                            @if($item->url)
                                <a href="{{ $item->url }}" target="_blank" class="text-primary small text-decoration-none"><i class="fa-solid fa-link me-1"></i> {{ Str::limit($item->url, 30) }}</a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border font-mono">{{ $item->order }}</span>
                        </td>
                        <td>
                            @if($item->is_active)
                                <span class="badge badge-pill-enterprise badge-pill-success">Aktif</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-danger">Pasif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.references.edit', $item) }}" class="table-action-btn" title="Düzenle">
                                    {!! render_svg_icon('edit') !!}
                                </a>
                                <form action="{{ route('admin.references.destroy', $item) }}" method="POST" class="d-inline" data-confirm="Bu referansı silmek istediğinizden emin misiniz?">
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
                                'icon' => 'fa-handshake-slash',
                                'title' => 'Henüz Referans Bulunmuyor',
                                'message' => 'Sistemde gösterilecek marka veya idare logosu bulunmuyor.',
                                'createUrl' => route('admin.references.create'),
                                'createTitle' => 'İlk Referansı Ekle'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($references->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $references->links() }}
        </div>
    @endif
</div>
@endsection
