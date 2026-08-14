@extends('admin.layouts.master')

@section('title', 'Kullanıcı Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Kullanıcı Yönetimi',
    'subtitle' => 'Sistem yöneticilerini ve paneli kullanan hesapları yönetin.',
    'icon' => 'fa-users',
    'createUrl' => route('admin.users.create'),
    'createTitle' => 'Yeni Kullanıcı Ekle'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Kullanıcı ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $users->total() }} Kullanıcı</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Kullanıcı Adı</th>
                    <th>E-Posta Adresi</th>
                    <th>Kayıt Tarihi</th>
                    <th>Rol</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $userItem)
                    <tr>
                        <td>
                            <div class="stat-icon-square icon-blue-gradient rounded-circle thumb-img-sm justify-content-center text-primary fw-bold">
                                {{ strtoupper(substr($userItem->name, 0, 1)) }}
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $userItem->name }}</span>
                            @if(auth()->id() === $userItem->id)
                                <span class="badge bg-primary bg-opacity-10 text-primary fs-xs"><i class="fa-solid fa-user-check me-1"></i> Siz (Mevcut Oturum)</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-secondary font-monospace"><i class="fa-regular fa-envelope me-1 text-muted"></i> {{ $userItem->email }}</span>
                        </td>
                        <td>
                            <span class="text-muted small"><i class="fa-regular fa-calendar me-1"></i> {{ $userItem->created_at ? $userItem->created_at->format('d.m.Y H:i') : '-' }}</span>
                        </td>
                        <td>
                            <span class="badge badge-pill-enterprise badge-pill-success">Sistem Yöneticisi</span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.users.edit', $userItem) }}" class="table-action-btn" title="Düzenle">
                                    {!! render_svg_icon('edit') !!}
                                </a>
                                @if(auth()->id() !== $userItem->id)
                                    <form action="{{ route('admin.users.destroy', $userItem) }}" method="POST" class="d-inline" data-confirm="Bu kullanıcı hesabını silmek istediğinizden emin misiniz?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action-btn btn-danger-light border-0" title="Sil">
                                            {!! render_svg_icon('trash') !!}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            @include('admin.partials.empty_state', [
                                'icon' => 'fa-users-slash',
                                'title' => 'Henüz Kullanıcı Bulunmuyor',
                                'message' => 'Sistemde kayıtlı herhangi bir yönetici hesabı bulunamadı.',
                                'createUrl' => route('admin.users.create'),
                                'createTitle' => 'İlk Kullanıcıyı Ekle'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
