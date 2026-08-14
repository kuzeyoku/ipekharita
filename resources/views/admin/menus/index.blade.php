@extends('admin.layouts.master')

@section('title', 'Header Menü Yönetimi — İpek Mühendislik Admin')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Header Menü Yönetimi',
    'subtitle' => 'Web sitesinin üst navigasyon menüsünü ve ikonlarını hiyerarşik olarak düzenleyin.',
    'icon' => 'sitemap'
])

@include('admin.partials.alerts')

<div class="row g-4">
    
    <div class="col-lg-7">
        <div class="admin-card-glass">
            <div class="admin-card-header-light border-bottom">
                <h5 class="card-title fw-bold text-dark mb-0 fs-6 font-outfit d-flex align-items-center gap-2">
                    {!! render_svg_icon('sitemap', 'text-primary') !!} Menü Hiyerarşisi & İkonları
                </h5>
                <span class="badge badge-pill-enterprise badge-pill-info font-mono">{{ $topMenus->count() }} Ana Menü</span>
            </div>
            <div class="card-body p-4">
                @if($topMenus->isEmpty())
                    @include('admin.partials.empty_state', [
                        'icon' => 'sitemap',
                        'title' => 'Henüz Menü Elemanı Eklenmedi',
                        'message' => 'Sistemde gezinti menüsü bulunmamaktadır. Sağ taraftaki formdan ekleyebilirsiniz.'
                    ])
                @else
                    <div class="menu-hierarchy-list d-flex flex-column gap-3">
                        @foreach($topMenus as $parent)
                            <div class="border rounded-3 p-3 bg-light bg-opacity-50">
                                
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge bg-primary text-white font-mono px-2 py-1">Sıra: {{ $parent->order }}</span>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($parent->icon)
                                                <span class="badge bg-white text-primary border p-2 rounded-2">{!! render_svg_icon($parent->icon, 'fs-5 text-primary') !!}</span>
                                            @endif
                                            <div>
                                                <h6 class="fw-bold text-dark mb-0">{{ $parent->title }}</h6>
                                                <small class="text-muted font-mono fs-7">{{ $parent->url }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($parent->is_active)
                                            <span class="badge badge-pill-enterprise badge-pill-success fs-7">Aktif</span>
                                        @else
                                            <span class="badge badge-pill-enterprise badge-pill-muted fs-7">Pasif</span>
                                        @endif

                                        <button type="button" class="table-action-btn" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $parent->id }}" title="Düzenle">
                                            {!! render_svg_icon('edit') !!}
                                        </button>

                                        <form action="{{ route('admin.menus.destroy', $parent->id) }}" method="POST" class="d-inline" data-confirm="Bu menüyü ve tüm alt menülerini silmek istediğinize emin misiniz?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="table-action-btn btn-danger-light border-0" title="Sil">
                                                {!! render_svg_icon('trash') !!}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($parent->children->count() > 0)
                                    <div class="ms-4 mt-3 pt-3 border-top border-secondary border-opacity-10 d-flex flex-column gap-2">
                                        <small class="text-muted fw-semibold mb-1 d-block">{!! render_svg_icon('chevron-right', 'me-1 text-primary') !!} Alt Menüler ({{ $parent->children->count() }})</small>
                                        @foreach($parent->children as $child)
                                            <div class="d-flex align-items-center justify-content-between p-2 rounded-2 bg-white border">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-secondary bg-opacity-10 text-dark font-mono fs-7">Sıra: {{ $child->order }}</span>
                                                    @if($child->icon)
                                                        <span class="badge bg-light text-primary border px-2 py-1">{!! render_svg_icon($child->icon) !!}</span>
                                                    @endif
                                                    <span class="fw-semibold text-dark fs-7">{{ $child->title }}</span>
                                                    <span class="text-muted font-mono fs-7">({{ $child->url }})</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1">
                                                    @if($child->is_active)
                                                        <span class="badge badge-pill-enterprise badge-pill-success fs-7">Aktif</span>
                                                    @else
                                                        <span class="badge badge-pill-enterprise badge-pill-muted fs-7">Pasif</span>
                                                    @endif

                                                    <button type="button" class="table-action-btn" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $child->id }}" title="Düzenle">
                                                        {!! render_svg_icon('edit') !!}
                                                    </button>

                                                    <form action="{{ route('admin.menus.destroy', $child->id) }}" method="POST" class="d-inline" data-confirm="Alt menüyü silmek istediğinize emin misiniz?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="table-action-btn btn-danger-light border-0" title="Sil">
                                                            {!! render_svg_icon('trash') !!}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="editMenuModal{{ $child->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('admin.menus.update', $child->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content rounded-4 border-0 shadow">
                                                            <div class="modal-header border-bottom">
                                                                <h5 class="modal-title fw-bold text-dark font-outfit">Alt Menü Düzenle</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                                            </div>
                                                            <div class="modal-body p-4">
                                                                <div class="mb-3">
                                                                    <label class="admin-label-light">Menü Başlığı</label>
                                                                    <input type="text" name="title" value="{{ $child->title }}" class="form-control admin-input-light" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="admin-label-light mb-1">Menü Vektör İkonu</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text bg-white border-end-0 text-primary fs-5" id="iconPreviewChild{{ $child->id }}">
                                                                            {!! render_svg_icon($child->icon ?: 'chevron-right', 'fs-4 text-primary') !!}
                                                                        </span>
                                                                        <input type="text" id="iconInputChild{{ $child->id }}" name="icon" value="{{ $child->icon }}" class="form-control admin-input-light border-start-0 border-end-0" placeholder="house, building, layer-group, route...">
                                                                        <button type="button" class="btn btn-primary px-3 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#iconPickerModal" data-icon-target="iconInputChild{{ $child->id }}" data-preview-target="iconPreviewChild{{ $child->id }}">
                                                                            {!! render_svg_icon('icons', 'me-1') !!} <span>İkon Seç</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="admin-label-light">URL / Bağlantı</label>
                                                                    <input type="text" name="url" value="{{ $child->url }}" class="form-control admin-input-light" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="admin-label-light">Üst Menü</label>
                                                                    <select name="parent_id" class="form-select admin-input-light">
                                                                        <option value="">-- Ana Menü (Üst Seviye) --</option>
                                                                        @foreach($allParents as $p)
                                                                            <option value="{{ $p->id }}" {{ $child->parent_id == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="row g-3 mb-3">
                                                                    <div class="col-6">
                                                                        <label class="admin-label-light">Sıralama</label>
                                                                        <input type="number" name="order" value="{{ $child->order }}" class="form-control admin-input-light">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="admin-label-light">Hedef</label>
                                                                        <select name="target" class="form-select admin-input-light">
                                                                            <option value="_self" {{ $child->target == '_self' ? 'selected' : '' }}>Aynı Sayfa (_self)</option>
                                                                            <option value="_blank" {{ $child->target == '_blank' ? 'selected' : '' }}>Yeni Sekme (_blank)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="switch-card mb-3">
                                                                    <div>
                                                                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                                                                        <span class="text-muted small" style="font-size: 0.78rem;">Menüyü aktif olarak yayınla</span>
                                                                    </div>
                                                                    <div class="form-check form-switch m-0">
                                                                        <input class="form-check-input" type="checkbox" name="is_active" id="activeChild{{ $child->id }}" value="1" {{ $child->is_active ? 'checked' : '' }}>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-top">
                                                                <button type="button" class="btn btn-light border rounded-3" data-bs-dismiss="modal">İptal</button>
                                                                <button type="submit" class="btn btn-enterprise-admin">Kaydet</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="modal fade" id="editMenuModal{{ $parent->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('admin.menus.update', $parent->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-bottom">
                                                <h5 class="modal-title fw-bold text-dark font-outfit">Ana Menü Düzenle</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="admin-label-light">Menü Başlığı</label>
                                                    <input type="text" name="title" value="{{ $parent->title }}" class="form-control admin-input-light" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="admin-label-light mb-1">Menü Vektör İkonu</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0 text-primary fs-5" id="iconPreviewParent{{ $parent->id }}">
                                                            {!! render_svg_icon($parent->icon ?: 'house', 'fs-4 text-primary') !!}
                                                        </span>
                                                        <input type="text" id="iconInputParent{{ $parent->id }}" name="icon" value="{{ $parent->icon }}" class="form-control admin-input-light border-start-0 border-end-0" placeholder="house, building, layer-group, route...">
                                                        <button type="button" class="btn btn-primary px-3 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#iconPickerModal" data-icon-target="iconInputParent{{ $parent->id }}" data-preview-target="iconPreviewParent{{ $parent->id }}">
                                                            {!! render_svg_icon('icons', 'me-1') !!} <span>İkon Seç</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="admin-label-light">URL / Bağlantı</label>
                                                    <input type="text" name="url" value="{{ $parent->url }}" class="form-control admin-input-light" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="admin-label-light">Üst Menü</label>
                                                    <select name="parent_id" class="form-select admin-input-light">
                                                        <option value="">-- Ana Menü (Üst Seviye) --</option>
                                                        @foreach($allParents as $p)
                                                            @if($p->id !== $parent->id)
                                                                <option value="{{ $p->id }}" {{ $parent->parent_id == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-6">
                                                        <label class="admin-label-light">Sıralama</label>
                                                        <input type="number" name="order" value="{{ $parent->order }}" class="form-control admin-input-light">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="admin-label-light">Hedef</label>
                                                        <select name="target" class="form-select admin-input-light">
                                                            <option value="_self" {{ $parent->target == '_self' ? 'selected' : '' }}>Aynı Sayfa (_self)</option>
                                                            <option value="_blank" {{ $parent->target == '_blank' ? 'selected' : '' }}>Yeni Sekme (_blank)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="switch-card mb-3">
                                                    <div>
                                                        <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                                                        <span class="text-muted small" style="font-size: 0.78rem;">Menüyü aktif olarak yayınla</span>
                                                    </div>
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" name="is_active" id="activeParent{{ $parent->id }}" value="1" {{ $parent->is_active ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top">
                                                <button type="button" class="btn btn-light border rounded-3" data-bs-dismiss="modal">İptal</button>
                                                <button type="submit" class="btn btn-enterprise-admin">Kaydet</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="admin-card-glass">
            <div class="admin-card-header-light border-bottom">
                <h5 class="card-title fw-bold text-dark mb-0 fs-6 font-outfit d-flex align-items-center gap-2">
                    {!! render_svg_icon('plus', 'text-primary') !!} Yeni Menü Elemanı Ekle
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.menus.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="admin-label-light">Menü Başlığı *</label>
                        <input type="text" name="title" class="form-control admin-input-light" placeholder="Örn: Kurumsal veya Hizmetlerimiz" required>
                    </div>

                    <div class="mb-3">
                        <label class="admin-label-light mb-1">Menü Vektör İkonu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-primary fs-5" id="iconPreviewNew">
                                {!! render_svg_icon('house', 'fs-4 text-primary') !!}
                            </span>
                            <input type="text" id="iconInputNew" name="icon" value="house" class="form-control admin-input-light border-start-0 border-end-0" placeholder="house, building, layer-group, route...">
                            <button type="button" class="btn btn-primary px-3 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#iconPickerModal" data-icon-target="iconInputNew" data-preview-target="iconPreviewNew">
                                {!! render_svg_icon('icons', 'me-1') !!} <span>İkon Seç</span>
                            </button>
                        </div>
                        <span class="text-muted small d-block mt-1" style="font-size:0.78rem;">İstediğiniz ikon kodunu yazabilir veya <strong>'İkon Seç'</strong> butonuna tıklayarak katalogdan seçebilirsiniz.</span>
                    </div>

                    <div class="mb-3">
                        <label class="admin-label-light">URL / Rota Bağlantısı *</label>
                        <input type="text" name="url" class="form-control admin-input-light" placeholder="Örn: /hakkimizda veya https://..." required>
                    </div>

                    <div class="mb-3">
                        <label class="admin-label-light">Üst Menü (Hiyerarşi)</label>
                        <select name="parent_id" class="form-select admin-input-light">
                            <option value="">-- Ana Menü (Üst Seviye) --</option>
                            @foreach($allParents as $p)
                                <option value="{{ $p->id }}">{{ $p->title }} (Ana Menü)</option>
                            @endforeach
                        </select>
                        <div class="form-text text-muted fs-xs mt-1">Eğer bu seçeneği seçerseniz, bu eleman seçtiğiniz ana menünün altında açılır menü (dropdown) olarak görünür.</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6 mb-3">
                            <label class="admin-label-light">Sıralama</label>
                            <input type="number" name="order" value="{{ $topMenus->count() + 1 }}" class="form-control admin-input-light">
                        </div>

                        <div class="col-6 mb-3">
                            <label class="admin-label-light">Hedef</label>
                            <select name="target" class="form-select admin-input-light">
                                <option value="_self">Aynı Sayfa (_self)</option>
                                <option value="_blank">Yeni Sekme (_blank)</option>
                            </select>
                        </div>
                    </div>

                    <div class="switch-card mb-4">
                        <div>
                            <span class="d-block fw-bold text-dark small">Yayın Durumu</span>
                            <span class="text-muted small" style="font-size: 0.78rem;">Menüyü aktif olarak yayınla</span>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveNew" value="1" checked>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-enterprise-admin w-100 py-3 justify-content-center fw-bold d-inline-flex align-items-center gap-2">
                        {!! render_svg_icon('floppy-disk', 'me-1') !!} Menü Elemanını Ekle
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin.partials.icon_picker_modal')

@endsection
