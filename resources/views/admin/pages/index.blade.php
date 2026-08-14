@extends('admin.layouts.master')

@section('title', 'Sayfa Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Sayfa Yönetimi',
    'subtitle' => 'Hakkımızda, KVKK, Politika vb. kurumsal sabit içerik sayfalarını yönetin.',
    'icon' => 'fa-file-lines',
    'createUrl' => route('admin.pages.create'),
    'createTitle' => 'Yeni Sayfa Ekle'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Sayfa ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $pages->total() }} Sayfa</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Görsel</th>
                    <th>Sayfa Adı</th>
                    <th>URL Slug</th>
                    <th>Sıra</th>
                    <th>Durum</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td>
                            @if($page->image)
                                <img src="{{ asset(str_starts_with($page->image, 'storage/') || str_starts_with($page->image, 'assets/') ? $page->image : 'storage/' . $page->image) }}" class="rounded-3 border thumb-img-sm" alt="{{ $page->title }}">
                            @else
                                <div class="stat-icon-square icon-blue-gradient rounded-3 thumb-img-sm justify-content-center">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $page->title }}</span>
                        </td>
                        <td>
                            <span class="badge bg-light text-primary border font-monospace">/sayfa/{{ $page->slug }}</span>
                        </td>
                        <td><span class="badge bg-light text-dark border font-mono">{{ $page->order }}</span></td>
                        <td>
                            @if($page->is_active)
                                <span class="badge badge-pill-enterprise badge-pill-success">Aktif</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-muted">Pasif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('pages.detail', $page->slug) }}" target="_blank" class="table-action-btn" title="Önizle">
                                    {!! render_svg_icon('eye') !!}
                                </a>
                                <a href="{{ route('admin.pages.edit', $page) }}" class="table-action-btn" title="Düzenle">
                                    {!! render_svg_icon('edit') !!}
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" data-confirm="Bu sayfayı silmek istediğinizden emin misiniz?">
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
                                'icon' => 'fa-file-circle-xmark',
                                'title' => 'Henüz Sabit Sayfa Yok',
                                'message' => 'Sistemde henüz yayınlanmış sabit sayfa bulunmuyor.',
                                'createUrl' => route('admin.pages.create'),
                                'createTitle' => 'İlk Sayfayı Ekle'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pages->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $pages->links() }}
        </div>
    @endif
</div>
@endsection
