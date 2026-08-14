@extends('admin.layouts.master')

@section('title', 'Modal Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Modal Yönetimi',
    'subtitle' => 'Web sitesi açılışında gösterilen duyuru ve kampanya pop-up pencerelerini yönetin.',
    'icon' => 'fa-window-restore',
    'createUrl' => route('admin.site-modals.create'),
    'createTitle' => 'Yeni Modal Ekle'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Modallarda ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $modals->total() }} Modal</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">Görsel</th>
                    <th>Duyuru Başlığı</th>
                    <th>Açılma Gecikmesi</th>
                    <th>Buton Metni / URL</th>
                    <th>Durum</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modals as $mItem)
                    <tr>
                        <td>
                            @if($mItem->image)
                                <img src="{{ asset(str_starts_with($mItem->image, 'storage/') || str_starts_with($mItem->image, 'assets/') ? $mItem->image : 'storage/' . $mItem->image) }}" alt="{{ $mItem->title }}" class="img-fluid rounded border" style="max-height: 40px; max-width: 60px; object-fit: cover;">
                            @else
                                <div class="stat-icon-square icon-blue-gradient rounded thumb-img-sm justify-content-center text-muted">
                                    <i class="fa-solid fa-window-maximize"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $mItem->title }}</span>
                            @if($mItem->content)
                                <span class="text-muted small d-block text-truncate mw-400">{{ strip_tags($mItem->content) }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border font-mono"><i class="fa-regular fa-clock me-1 text-primary"></i> {{ $mItem->show_delay }} sn sonra</span>
                        </td>
                        <td>
                            @if($mItem->btn_text)
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ $mItem->btn_text }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            @if($mItem->is_active)
                                <span class="badge badge-pill-enterprise badge-pill-success">Aktif (Gösterimde)</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-danger">Pasif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.site-modals.edit', $mItem) }}" class="table-action-btn" title="Düzenle">
                                    {!! render_svg_icon('edit') !!}
                                </a>
                                <form action="{{ route('admin.site-modals.destroy', $mItem) }}" method="POST" class="d-inline" data-confirm="Bu pop-up modal duyurusunu silmek istediğinizden emin misiniz?">
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
                                'icon' => 'fa-window-restore',
                                'title' => 'Henüz Modal Duyuru Yok',
                                'message' => 'Sistemde ziyaretçilere gösterilecek pop-up penceresi bulunmuyor.',
                                'createUrl' => route('admin.site-modals.create'),
                                'createTitle' => 'İlk Modalı Ekle'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($modals->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $modals->links() }}
        </div>
    @endif
</div>
@endsection
