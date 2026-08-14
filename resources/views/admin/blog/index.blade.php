@extends('admin.layouts.master')

@section('title', 'Blog Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Blog Yönetimi',
    'subtitle' => 'Sektörel yayınları, duyuruları ve teknik makaleleri yönetin.',
    'icon' => 'fa-newspaper',
    'createUrl' => route('admin.blog.create'),
    'createTitle' => 'Yeni Makale Ekle'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Makale ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $posts->total() }} Makale</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Görsel</th>
                    <th>Başlık & Slug</th>
                    <th>Kategori</th>
                    <th>Yazar</th>
                    <th>Yayın Tarihi</th>
                    <th>Durum</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>
                            @if($post->image)
                                <img src="{{ asset(str_starts_with($post->image, 'storage/') || str_starts_with($post->image, 'assets/') ? $post->image : 'storage/' . $post->image) }}" class="rounded-3 border thumb-img-sm" alt="{{ $post->title }}">
                            @else
                                <div class="stat-icon-square icon-emerald-gradient rounded-3 thumb-img-sm justify-content-center">
                                    <i class="fa-solid fa-newspaper"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $post->title }}</span>
                            <span class="text-muted fs-xs font-mono">/blog/{{ $post->slug }}</span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-semibold">{{ data_get($post, 'category.title') ?: 'Genel' }}</span>
                        </td>
                        <td class="text-secondary small"><i class="fa-regular fa-user me-1 text-muted"></i> {{ $post->author ?: 'Yönetici' }}</td>
                        <td class="text-muted small"><i class="fa-regular fa-calendar me-1"></i> {{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : '-' }}</td>
                        <td>
                            @if($post->is_published)
                                <span class="badge badge-pill-enterprise badge-pill-success">Yayında</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-muted">Taslak</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.blog.edit', $post) }}" class="table-action-btn" title="Düzenle">
                                    {!! render_svg_icon('edit') !!}
                                </a>
                                <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="d-inline" data-confirm="Bu makaleyi ve kapak görselini silmek istediğinizden emin misiniz?">
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
                                'icon' => 'fa-newspaper',
                                'title' => 'Henüz Blog Yazısı Yok',
                                'message' => 'Sistemde henüz yayınlanmış teknik haber veya makale bulunmuyor.',
                                'createUrl' => route('admin.blog.create'),
                                'createTitle' => 'İlk Yazıyı Yayınla'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
        <div class="admin-card-body-light border-top py-3 d-flex justify-content-end">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
