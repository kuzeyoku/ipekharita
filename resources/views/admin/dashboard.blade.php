@extends('admin.layouts.master')

@section('title', 'Genel Bakış & Analiz Dashboard')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Genel Bakış & İstatistikler',
    'subtitle' => setting('company_name', config('app.name', 'Kurumsal')) . ' yönetim paneli performans metrikleri ve hızlı işlemler.',
    'icon' => 'fa-chart-line'
])

@include('admin.partials.alerts')

<div class="row g-3 mb-4">
    
    <div class="col-md-3">
        <div class="stat-card-light">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge badge-pill-enterprise badge-pill-primary fs-3xs">GÜNLÜK</span>
                </div>
                <span class="d-block text-muted small fw-bold text-uppercase tracking-wider fs-2xs">Bugünkü Ziyaretçi</span>
                <span class="fs-4 fw-extrabold text-dark font-outfit">{{ number_format($visitorStats['today'] ?? 0) }}</span>
            </div>
            <div class="stat-icon-square icon-blue-gradient">
                {!! render_svg_icon('user-check') !!}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card-light">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge badge-pill-enterprise badge-pill-info fs-3xs">HAFTALIK</span>
                </div>
                <span class="d-block text-muted small fw-bold text-uppercase tracking-wider fs-2xs">Bu Haftaki Ziyaretçi</span>
                <span class="fs-4 fw-extrabold text-dark font-outfit">{{ number_format($visitorStats['week'] ?? 0) }}</span>
            </div>
            <div class="stat-icon-square icon-blue-gradient">
                {!! render_svg_icon('calendar-days') !!}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card-light">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge badge-pill-enterprise badge-pill-warning fs-3xs">AYLIK</span>
                </div>
                <span class="d-block text-muted small fw-bold text-uppercase tracking-wider fs-2xs">Bu Ayki Ziyaretçi</span>
                <span class="fs-4 fw-extrabold text-dark font-outfit">{{ number_format($visitorStats['month'] ?? 0) }}</span>
            </div>
            <div class="stat-icon-square icon-gold-gradient">
                {!! render_svg_icon('chart-simple') !!}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card-light">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge badge-pill-enterprise badge-pill-success fs-3xs">TOPLAM</span>
                </div>
                <span class="d-block text-muted small fw-bold text-uppercase tracking-wider fs-2xs">Toplam Tekil Ziyaretçi</span>
                <span class="fs-4 fw-extrabold text-dark font-outfit">{{ number_format($visitorStats['total'] ?? 0) }}</span>
            </div>
            <div class="stat-icon-square icon-emerald-gradient">
                {!! render_svg_icon('chart-line') !!}
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card-light bg-white border">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge badge-pill-enterprise badge-pill-primary fs-3xs">İLETİŞİM FORMU</span>
                    @if($unreadMessagesCount > 0)
                        <span class="badge badge-pill-enterprise badge-pill-danger fs-3xs">{{ $unreadMessagesCount }} OKUNMAMIŞ</span>
                    @endif
                </div>
                <span class="d-block text-muted small fw-bold text-uppercase tracking-wider fs-2xs">Gelen İletişim Mesajları</span>
                <span class="fs-4 fw-extrabold text-dark font-outfit">{{ $messagesCount }}</span>
            </div>
            <div class="stat-icon-square icon-blue-gradient">
                {!! render_svg_icon('envelope-open-text') !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card-light bg-white border">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge badge-pill-enterprise badge-pill-warning fs-3xs">DEĞERLENDİRMELER</span>
                    @if($pendingCommentsCount > 0)
                        <span class="badge badge-pill-enterprise badge-pill-warning fs-3xs">{{ $pendingCommentsCount }} ONAY BEKLEYEN</span>
                    @endif
                </div>
                <span class="d-block text-muted small fw-bold text-uppercase tracking-wider fs-2xs">Müşteri Yorumları</span>
                <span class="fs-4 fw-extrabold text-dark font-outfit">{{ $commentsCount }}</span>
            </div>
            <div class="stat-icon-square icon-gold-gradient">
                {!! render_svg_icon('comments') !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card-light bg-white border">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge badge-pill-enterprise badge-pill-info fs-3xs">ÇOĞUL SAYFA GÖSTERİMİ</span>
                    <span class="badge badge-pill-enterprise badge-pill-success fs-3xs">BUGÜN: {{ number_format($visitorStats['todayViews'] ?? 0) }}</span>
                </div>
                <span class="d-block text-muted small fw-bold text-uppercase tracking-wider fs-2xs">Toplam Sayfa Görüntüleme</span>
                <span class="fs-4 fw-extrabold text-primary font-outfit">{{ number_format($visitorStats['totalViews'] ?? 0) }}</span>
            </div>
            <div class="stat-icon-square icon-blue-gradient">
                {!! render_svg_icon('eye') !!}
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="admin-card-glass mb-0">
            <div class="admin-card-header-light py-3 border-bottom">
                <div>
                    <h6 class="mb-0 fw-bold text-dark small font-outfit">{!! render_svg_icon('chart-line', 'text-primary me-1') !!} Günlük Ziyaretçi & Sayfa Görüntüleme Grafiği (Son 7 Gün)</h6>
                </div>
                <span class="badge badge-pill-enterprise badge-pill-info"><i class="fa-solid fa-sync fa-spin me-1"></i> Canlı Analitik</span>
            </div>
            <div class="admin-card-body-light p-3 position-relative" style="height: 250px;">
                <canvas id="analyticsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card-glass h-100 mb-0">
            <div class="admin-card-header-light py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark small font-outfit"><i class="fa-solid fa-bolt text-primary me-1"></i> Hızlı İşlem Kısayolları</h6>
            </div>
            <div class="admin-card-body-light p-3 d-flex flex-column gap-2">
                <a href="{{ route('admin.services.create') }}" class="btn btn-enterprise-admin w-100 text-start d-flex align-items-center justify-content-between py-2 px-3 btn-qs">
                    <span><i class="fa-solid fa-plus me-2"></i> Yeni Hizmet Ekle</span>
                    <i class="fa-solid fa-chevron-right small"></i>
                </a>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-light border text-dark fw-bold w-100 text-start d-flex align-items-center justify-content-between rounded-3 py-2 px-3 btn-qs">
                    <span><i class="fa-solid fa-plus text-primary me-2"></i> Yeni Proje Ekle</span>
                    <i class="fa-solid fa-chevron-right small text-muted"></i>
                </a>
                <a href="{{ route('admin.blog.create') }}" class="btn btn-light border text-dark fw-bold w-100 text-start d-flex align-items-center justify-content-between rounded-3 py-2 px-3 btn-qs">
                    <span><i class="fa-solid fa-pen text-warning me-2"></i> Blog Makalesi Yayınla</span>
                    <i class="fa-solid fa-chevron-right small text-muted"></i>
                </a>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-light border text-dark fw-bold w-100 text-start d-flex align-items-center justify-content-between rounded-3 py-2 px-3 btn-qs">
                    <span><i class="fa-solid fa-envelope-open-text text-success me-2"></i> Mesaj Yönetimi</span>
                    <i class="fa-solid fa-chevron-right small text-muted"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="admin-card-glass">
    <div class="admin-card-header-light py-3 border-bottom">
        <h6 class="mb-0 fw-bold text-dark small font-outfit"><i class="fa-solid fa-inbox text-primary me-1"></i> Son Gelen Müşteri İletileri</h6>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold fs-2xs">Tüm Mesajları İncele</a>
    </div>
    <div class="table-responsive">
        <table class="table table-admin-light align-middle mb-0">
            <thead>
                <tr>
                    <th>Gönderen</th>
                    <th>İletişim</th>
                    <th>Konu / Hizmet</th>
                    <th>Tarih</th>
                    <th>Durum</th>
                    <th class="text-end">İşlem</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentMessages as $msg)
                    <tr>
                        <td>
                            <span class="fw-bold d-block text-dark">{{ $msg->name }}</span>
                            <span class="text-muted fs-2xs font-mono">{{ $msg->email }}</span>
                        </td>
                        <td class="fw-semibold text-secondary">{{ $msg->phone ?: '-' }}</td>
                        <td>
                            <span class="badge badge-pill-enterprise badge-pill-info">{{ $msg->service_title ?: ($msg->subject ?: 'Genel İletişim') }}</span>
                        </td>
                        <td class="text-muted fs-2xs font-mono">{{ $msg->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            @if($msg->is_read)
                                <span class="badge badge-pill-enterprise badge-pill-muted">Okundu</span>
                            @else
                                <span class="badge badge-pill-enterprise badge-pill-primary">Okunmadı</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="table-action-btn" title="Detay"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            @include('admin.partials.empty_state', [
                                'icon' => 'fa-inbox',
                                'title' => 'Henüz Mesaj Bulunmuyor',
                                'message' => 'Gelen tüm müşteri mesajları ve teklif formları burada listelenecektir.'
                            ])
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.visitorChartConfig = @json($chartData);
</script>
@endpush
