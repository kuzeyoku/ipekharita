<!-- FontAwesome Icon Picker Modal -->
<div class="modal fade" id="iconPickerModal" tabindex="-1" aria-labelledby="iconPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 bg-primary bg-opacity-25 rounded-3 text-primary">
                        {!! render_svg_icon('icons', 'fs-5 text-primary') !!}
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold fs-6 mb-0 text-white" id="iconPickerModalLabel">Vektör İkon Kataloğu & Seçici</h5>
                        <small class="text-white-50" style="font-size: 0.78rem;">Uygun ikona tıklayarak otomatik form alanına aktarabilirsiniz</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            
            <div class="modal-body p-4 bg-light">
                <!-- Search Bar -->
                <div class="position-relative mb-4">
                    <input type="text" id="iconSearchInput" class="form-control form-control-lg rounded-3 fs-6" placeholder="İkon ismi veya kategori ara... (örn: harita, bina, ev, gazete, telefon, kurum)">
                </div>

                <!-- Icon Grid -->
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3" id="iconGrid">
                    @php
                        $icons = [
                            ['class' => 'house', 'title' => 'Ana Sayfa / Ev', 'tags' => 'ev house home anasayfa'],
                            ['class' => 'building', 'title' => 'Kurumsal / Bina', 'tags' => 'bina building kurum şirket hakkımızda'],
                            ['class' => 'layer-group', 'title' => 'Hizmetler / Katman', 'tags' => 'hizmet cbs katman harita projeler'],
                            ['class' => 'route', 'title' => 'Projeler / Yol', 'tags' => 'proje route yol güzergah arazi'],
                            ['class' => 'newspaper', 'title' => 'Blog & Haber', 'tags' => 'blog haber dergi duyuru makale'],
                            ['class' => 'phone', 'title' => 'Telefon / İletişim', 'tags' => 'telefon arama iletişim numara'],
                            ['class' => 'envelope', 'title' => 'E-Posta / Mesaj', 'tags' => 'eposta email mesaj mail iletişim'],
                            ['class' => 'handshake', 'title' => 'Referanslar', 'tags' => 'referans el sıkışma ortak kamu'],
                            ['class' => 'shield-halved', 'title' => 'Güvenlik & Kalite', 'tags' => 'kalite lisans güvenlik sertifika'],
                            ['class' => 'city', 'title' => 'Şehir / İmar', 'tags' => 'şehir kent imar bina 3d'],
                            ['class' => 'map-location-dot', 'title' => 'Harita & Konum', 'tags' => 'harita kadastro konum yer saha'],
                            ['class' => 'plane-up', 'title' => 'LiDAR & Uçak', 'tags' => 'uçak lidar drone hava fotogrametri'],
                            ['class' => 'database', 'title' => 'Veri Tabanı', 'tags' => 'database veri yazılım cbs'],
                            ['class' => 'draw-polygon', 'title' => 'İmar & Parsel', 'tags' => 'imar parsel poligon arazi'],
                            ['class' => 'bridge-water', 'title' => 'Altyapı & Köprü', 'tags' => 'köprü altyapı baraj inşaat'],
                            ['class' => 'satellite', 'title' => 'Uydu & GNSS', 'tags' => 'uydu gnss cors nirengi konum'],
                            ['class' => 'compass', 'title' => 'Pusula & Yön', 'tags' => 'pusula yön ölçüm nirengi'],
                            ['class' => 'ruler-combined', 'title' => 'Ölçüm & Metraj', 'tags' => 'cetvel metraj küraj harita'],
                            ['class' => 'mountain', 'title' => 'Arazi & Topoğrafya', 'tags' => 'arazi dağ maden topoğrafya'],
                            ['class' => 'road', 'title' => 'Karayolu & Şerit', 'tags' => 'yol karayolu otoban şerit'],
                            ['class' => 'tree', 'title' => 'Orman & Çevre', 'tags' => 'orman ağaç çevre doğa 2b'],
                            ['class' => 'file-contract', 'title' => 'Sözleşme & Teklif', 'tags' => 'teklif dosya sözleşme doküman'],
                            ['class' => 'tags', 'title' => 'Kategori & Etiket', 'tags' => 'etiket kategori tür grup'],
                            ['class' => 'globe', 'title' => 'WebGIS & Coğrafi', 'tags' => 'webgis dünya global internet'],
                        ];
                    @endphp

                    @foreach($icons as $iconItem)
                        <div class="col icon-item-col" data-tags="{{ $iconItem['tags'] }} {{ strtolower($iconItem['title']) }} {{ $iconItem['class'] }}">
                            <button type="button" class="btn btn-outline-secondary w-100 h-100 p-3 rounded-4 d-flex flex-column align-items-center justify-content-center gap-2 icon-select-btn bg-white" data-icon="{{ $iconItem['class'] }}">
                                <div class="text-primary fs-2">{!! render_svg_icon($iconItem['class'], 'fs-2 text-primary') !!}</div>
                                <span class="small fw-semibold text-dark text-truncate w-100 text-center" style="font-size:0.75rem;">{{ $iconItem['title'] }}</span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer bg-white px-4 py-2 border-top-0 d-flex justify-content-between">
                <span class="text-muted small"><i class="fa-solid fa-circle-info me-1"></i> Seçmek istediğiniz ikona tıklayarak formu otomatik doldurabilirsiniz.</span>
                <button type="button" class="btn btn-secondary btn-sm px-3 rounded-3" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<style>
.icon-select-btn {
    border-color: #E2E8F0 !important;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.icon-select-btn:hover {
    border-color: #2563EB !important;
    background-color: #EFF6FF !important;
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.12) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const iconSearchInput = document.getElementById('iconSearchInput');
    const iconGrid = document.getElementById('iconGrid');

    if (iconSearchInput && iconGrid) {
        iconSearchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            const cols = iconGrid.querySelectorAll('.icon-item-col');

            cols.forEach(function (col) {
                const tags = col.getAttribute('data-tags');
                if (!query || (tags && tags.includes(query))) {
                    col.style.display = 'block';
                } else {
                    col.style.display = 'none';
                }
            });
        });
    }

    // Track active target input
    document.querySelectorAll('[data-bs-target="#iconPickerModal"]').forEach(function(triggerBtn) {
        triggerBtn.addEventListener('click', function() {
            window.activeIconInputId = this.getAttribute('data-icon-target') || 'iconInput';
            window.activeIconPreviewId = this.getAttribute('data-preview-target') || 'iconPreview';
        });
    });

    document.querySelectorAll('.icon-select-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const iconClass = this.getAttribute('data-icon');
            const targetInputId = window.activeIconInputId || 'iconInput';
            const targetPreviewId = window.activeIconPreviewId || 'iconPreview';

            const targetInput = document.getElementById(targetInputId);
            const targetPreview = document.getElementById(targetPreviewId);

            if (targetInput) {
                targetInput.value = iconClass;
                targetInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
            if (targetPreview) {
                const svgElem = this.querySelector('svg');
                if (svgElem) {
                    targetPreview.innerHTML = svgElem.outerHTML;
                }
            }

            // Close bootstrap modal smoothly
            const modalEl = document.getElementById('iconPickerModal');
            if (modalEl) {
                const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modalInstance.hide();
            }

            // SweetAlert Toast Notification if available
            if (typeof Swal !== 'undefined') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                Toast.fire({
                    icon: 'success',
                    title: 'İkon seçildi: ' + iconClass
                });
            }
        });
    });
});
</script>
