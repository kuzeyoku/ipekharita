@extends('admin.layouts.master')

@section('title', 'Blog Yorum Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Blog Yorum Yönetimi',
    'subtitle' => 'Ziyaretçiler tarafından blog haberlerine yapılan yorumların denetimi ve onayı.',
    'icon' => 'fa-comments'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Yorumlarda ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $comments->total() }} Yorum</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th>Yorum Yapan</th>
                    <th>E-Posta / IP</th>
                    <th>İlgili Blog Yazısı</th>
                    <th style="width: 35%;">Yorum Metni</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                    <tr>
                        <td>
                            <span class="fw-bold text-dark d-block"><i class="fa-solid fa-circle-user me-1 text-primary"></i> {{ $comment->name }}</span>
                        </td>
                        <td>
                            <span class="text-secondary small d-block">{{ $comment->email }}</span>
                            <span class="text-muted font-monospace fs-xs">{{ $comment->ip_address ?: 'IP Bilgisi Yok' }}</span>
                        </td>
                        <td>
                            @if($comment->blogPost)
                                <a href="{{ route('blog.detail', $comment->blogPost->slug) }}" target="_blank" class="text-primary small fw-semibold text-decoration-none">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> {{ Str::limit($comment->blogPost->title, 25) }}
                                </a>
                            @else
                                <span class="text-muted small">Silinmiş Yazı</span>
                            @endif
                        </td>
                        <td>
                            <div class="small text-dark p-2 bg-light rounded border text-wrap" style="max-height: 100px; overflow-y: auto;">
                                {{ $comment->comment }}
                            </div>
                        </td>
                        <td>
                            @if($comment->is_approved)
                                <span class="badge badge-pill-enterprise badge-pill-success">Yayında / Onaylı</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-warning">Onay Bekliyor</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted small font-mono">{{ $comment->created_at ? $comment->created_at->format('d.m.Y H:i') : '-' }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <form action="{{ route('admin.comments.toggle-approve', $comment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @if($comment->is_approved)
                                        <button type="submit" class="table-action-btn btn-warning-light border-0" title="Yayından Kaldır">{!! render_svg_icon('xmark') !!}</button>
                                    @else
                                        <button type="submit" class="table-action-btn btn-success-light border-0" title="Onayla ve Yayınla">{!! render_svg_icon('check') !!}</button>
                                    @endif
                                </form>
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline" data-confirm="Bu yorumu silmek istediğinizden emin misiniz?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="table-action-btn btn-danger-light border-0" title="Sil">{!! render_svg_icon('trash') !!}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            @include('admin.partials.empty_state', [
                                'icon' => 'fa-comments',
                                'title' => 'Henüz Yorum Yok',
                                'message' => 'Sistemde onay bekleyen veya yayınlanan yorum bulunmamaktadır.'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($comments->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $comments->links() }}
        </div>
    @endif
</div>
@endsection
