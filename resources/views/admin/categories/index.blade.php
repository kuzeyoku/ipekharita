@extends('admin.layouts.master')

@section('title', 'Merkezi Kategori Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Kategori Yönetimi',
    'subtitle' => 'Blog, Proje ve Hizmet modüllerinin ortak kategori havuzunu yönetin.',
    'icon' => 'fa-folder-tree',
    'createUrl' => route('admin.categories.create'),
    'createTitle' => 'Yeni Kategori Ekle'
])

@include('admin.partials.alerts')

<!-- Type Filters -->
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm {{ !$type ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3 fw-semibold">
        Tüm Kategoriler
    </a>
    <a href="{{ route('admin.categories.index', ['type' => 'blog']) }}" class="btn btn-sm {{ $type == 'blog' ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3 fw-semibold">
        <i class="fa-solid fa-newspaper me-1"></i> Blog Kategorileri
    </a>
    <a href="{{ route('admin.categories.index', ['type' => 'project']) }}" class="btn btn-sm {{ $type == 'project' ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3 fw-semibold">
        <i class="fa-solid fa-route me-1"></i> Proje Kategorileri
    </a>
    <a href="{{ route('admin.categories.index', ['type' => 'service']) }}" class="btn btn-sm {{ $type == 'service' ? 'btn-primary' : 'btn-light border' }} rounded-pill px-3 fw-semibold">
        <i class="fa-solid fa-layer-group me-1"></i> Hizmet Kategorileri
    </a>
</div>

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Kategori ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $categories->total() }} Kategori</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th>Kategori Adı</th>
                    <th>Ait Olduğu Modül</th>
                    <th>Slug / Bağlantı</th>
                    <th>Açıklama</th>
                    <th>Sıra</th>
                    <th>Durum</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>
                            <span class="fw-bold text-dark d-block">
                                <i class="fa-solid fa-folder me-1 text-warning"></i> {{ $cat->title }}
                            </span>
                        </td>
                        <td>
                            @if($cat->type == 'blog')
                                <span class="badge badge-pill-enterprise badge-pill-info"><i class="fa-solid fa-newspaper me-1"></i> Blog & Haber</span>
                            @elseif($cat->type == 'project')
                                <span class="badge badge-pill-enterprise badge-pill-warning"><i class="fa-solid fa-route me-1"></i> Proje</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-success"><i class="fa-solid fa-layer-group me-1"></i> Hizmet</span>
                            @endif
                        </td>
                        <td>
                            <span class="font-monospace text-muted small">{{ $cat->slug }}</span>
                        </td>
                        <td>
                            <span class="text-muted small d-block text-truncate mw-400">{{ $cat->description ?: '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border font-mono">{{ $cat->order }}</span>
                        </td>
                        <td>
                            @if($cat->is_active)
                                <span class="badge badge-pill-enterprise badge-pill-success">Aktif</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-danger">Pasif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="table-action-btn" title="Düzenle">
                                    {!! render_svg_icon('edit') !!}
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" data-confirm="Bu kategoriyi silmek istediğinizden emin misiniz?">
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
                                'icon' => 'fa-folder-open',
                                'title' => 'Henüz Kategori Bulunmuyor',
                                'message' => 'Sistemde seçilen kriterde kayıtlı kategori tanımlanmadı.',
                                'createUrl' => route('admin.categories.create'),
                                'createTitle' => 'İlk Kategoriyi Ekle'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
