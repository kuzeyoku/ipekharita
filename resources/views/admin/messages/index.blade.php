@extends('admin.layouts.master')

@section('title', 'Mesaj & İletişim Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Gelen İletişim Mesajları',
    'subtitle' => 'Web sitesi iletişim formundan ve modal pencerelerden gelen tüm talepler.',
    'icon' => 'fa-envelope'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-header-light">
        <div class="table-search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="form-control table-search-input" placeholder="Mesajlarda ara...">
        </div>
        <span class="badge badge-pill-enterprise badge-pill-info font-mono">Toplam: {{ $messages->total() }} Mesaj</span>
    </div>

    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 40px;"></th>
                    <th>Gönderen</th>
                    <th>E-Posta / Telefon</th>
                    <th>Konu / Hizmet</th>
                    <th>Mesaj Özeti</th>
                    <th>Tarih</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr class="{{ $msg->is_read ? '' : 'fw-bold bg-primary bg-opacity-10' }}">
                        <td>
                            @if(!$msg->is_read)
                                <span class="badge rounded-circle bg-warning p-1" title="Okunmadı"><i class="fa-solid fa-circle" style="font-size: 0.5rem;"></i></span>
                            @else
                                <i class="fa-regular fa-envelope-open text-muted"></i>
                            @endif
                        </td>
                        <td>
                            <span class="text-dark d-block">{{ $msg->name }}</span>
                        </td>
                        <td>
                            <span class="text-secondary small d-block">{{ $msg->email }}</span>
                            <span class="text-muted small d-block font-mono">{{ $msg->phone ?: '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $msg->subject ?: ($msg->service_title ?: 'Genel İletişim') }}</span>
                        </td>
                        <td>
                            <span class="text-muted small d-block text-truncate mw-400">{{ $msg->message }}</span>
                        </td>
                        <td>
                            <span class="text-muted small font-mono">{{ $msg->created_at ? $msg->created_at->format('d.m.Y H:i') : '-' }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="table-action-btn" title="Detay Okuma">
                                    {!! render_svg_icon('eye') !!}
                                </a>
                                <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="d-inline" data-confirm="Bu mesajı silmek istediğinizden emin misiniz?">
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
                                'icon' => 'fa-envelope-open',
                                'title' => 'Henüz Mesaj Bulunmuyor',
                                'message' => 'Web sitesinden tarafınıza ulaşan herhangi bir iletişim talebi bulunmuyor.'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($messages->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
