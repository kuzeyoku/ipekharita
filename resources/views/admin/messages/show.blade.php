@extends('admin.layouts.master')

@section('title', 'Mesaj Detayı — ' . $message->name)

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Gelen Mesaj Detayı',
    'subtitle' => $message->name . ' tarafından gönderilen mesajın içeriği.',
    'icon' => 'fa-envelope-open-text',
    'backUrl' => route('admin.messages.index')
])

@include('admin.partials.alerts')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card-glass">
            <div class="admin-card-body-light">
                <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1 font-outfit">{{ $message->name }}</h5>
                        <div class="d-flex flex-wrap gap-3 text-muted small">
                            <span><i class="fa-regular fa-envelope me-1 text-primary"></i> <a href="mailto:{{ $message->email }}" class="text-decoration-none text-dark">{{ $message->email }}</a></span>
                            @if($message->phone)
                                <span><i class="fa-solid fa-phone me-1 text-success"></i> <a href="tel:{{ $message->phone }}" class="text-decoration-none text-dark font-mono">{{ $message->phone }}</a></span>
                            @endif
                        </div>
                    </div>
                    <span class="badge bg-light text-secondary border px-3 py-2 font-mono">
                        <i class="fa-regular fa-clock me-1"></i> {{ $message->created_at ? $message->created_at->format('d.m.Y H:i') : '-' }}
                    </span>
                </div>

                @if($message->subject || $message->service_title)
                    <div class="mb-4 p-3 bg-light rounded-3 border">
                        <div class="row g-2">
                            @if($message->subject)
                                <div class="col-md-6">
                                    <span class="text-muted small d-block">Konu:</span>
                                    <span class="fw-bold text-dark">{{ $message->subject }}</span>
                                </div>
                            @endif
                            @if($message->service_title)
                                <div class="col-md-6">
                                    <span class="text-muted small d-block">İlgilenilen Hizmet:</span>
                                    <span class="badge badge-pill-enterprise badge-pill-info">{{ $message->service_title }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="admin-label-light mb-2">Mesaj Metni:</label>
                    <div class="p-4 rounded-3 border bg-white text-dark leading-relaxed font-outfit" style="min-height: 120px; font-size: 1.05rem; white-space: pre-line;">
                        {{ $message->message }}
                    </div>
                </div>

                <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject ?: 'İpek Mühendislik İletişim') }}" class="btn btn-enterprise-admin">
                        <i class="fa-solid fa-reply me-1"></i> E-Posta İle Yanıtla
                    </a>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" data-confirm="Bu mesajı silmek istediğinizden emin misiniz?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger rounded-3"><i class="fa-solid fa-trash me-1"></i> Mesajı Sil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
