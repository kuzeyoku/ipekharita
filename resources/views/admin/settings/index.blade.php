@extends('admin.layouts.master')

@section('title', 'Site Ayarları & Sistem Yönetimi')

@section('content')
@include('admin.partials.page_header', [
    'title' => 'Kurumsal Site & Sistem Ayarları',
    'subtitle' => 'İletişim bilgileri, sosyal medya, SMTP sunucu ayarları, statik metinler ve paylaşımlı hosting araçları.',
    'icon' => 'fa-gears'
])

@include('admin.partials.alerts')

<div class="admin-card-glass">
    <div class="admin-card-body-light">
        <!-- Navigation Tabs -->
        <ul class="nav nav-pills custom-admin-tabs mb-4 gap-2 border-bottom pb-3" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold rounded-pill" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                    <i class="fa-solid fa-building me-1"></i> Genel & Kurumsal
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold rounded-pill" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">
                    <i class="fa-solid fa-address-book me-1"></i> İletişim & Konum
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold rounded-pill" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">
                    <i class="fa-solid fa-share-nodes me-1"></i> Sosyal Medya
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold rounded-pill" id="smtp-tab" data-bs-toggle="tab" data-bs-target="#smtp" type="button" role="tab">
                    <i class="fa-solid fa-paper-plane me-1"></i> E-Posta & SMTP
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold rounded-pill" id="recaptcha-tab" data-bs-toggle="tab" data-bs-target="#recaptcha" type="button" role="tab">
                    <i class="fa-solid fa-shield-halved me-1"></i> reCAPTCHA & Güvenlik
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold rounded-pill text-danger bg-danger bg-opacity-10" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button" role="tab">
                    <i class="fa-solid fa-server me-1"></i> Sunucu & Sürüm Bilgileri (Hosting)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="settingsTabContent">
            <!-- 1. Genel Tab -->
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-sliders me-1"></i> Kurumsal Kimlik, Marka ve SEO Tanımları</h6>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="admin-label-light">Kurumsal Şirket / Firma Adı (Tam Ünvan)</label>
                            <input type="text" name="company_name" value="{{ old('company_name', $settings['company_name'] ?? '') }}" class="form-control admin-input-light" placeholder="Örn: İpek Mühendislik A.Ş.">
                            <small class="text-muted">Header, Footer, Telif ve resmi alanlarda tek noktadan kullanılır.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="admin-label-light">Kısa Marka / Sistem Adı</label>
                            <input type="text" name="brand_name" value="{{ old('brand_name', $settings['brand_name'] ?? '') }}" class="form-control admin-input-light" placeholder="Örn: İpek Mühendislik">
                            <small class="text-muted">Admin panel başlıkları ve logo altı kısa adlandırmalarda kullanılır.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="admin-label-light">Site Başlığı (SEO Title)</label>
                        <input type="text" name="site_title" value="{{ old('site_title', $settings['site_title'] ?? '') }}" class="form-control admin-input-light" placeholder="Örn: İpek Mühendislik A.Ş. | Harita, Kadastro & 3D Oblik">
                    </div>
                    <div class="mb-3">
                        <label class="admin-label-light">Site Meta Açıklaması (Description)</label>
                        <textarea name="site_description" rows="3" class="form-control admin-input-light" placeholder="Site genel açıklama ve arama motoru meta metni...">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-enterprise-admin mt-3">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Kaydet
                    </button>
                </form>
            </div>

            <!-- 2. İletişim Tab -->
            <div class="tab-pane fade" id="contact" role="tabpanel">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-phone me-1"></i> İletişim Bilgileri</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="admin-label-light">Birincil Telefon Numarası</label>
                            <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                        <div class="col-md-6">
                            <label class="admin-label-light">İkinci Telefon / GSM</label>
                            <input type="text" name="phone_2" value="{{ old('phone_2', $settings['phone_2'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="admin-label-light">Kurumsal E-Posta Adresi</label>
                            <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                        <div class="col-md-6">
                            <label class="admin-label-light">Kısa Konum / Şehir (Header İçin)</label>
                            <input type="text" name="company_address_short" value="{{ old('company_address_short', $settings['company_address_short'] ?? '') }}" class="form-control admin-input-light" placeholder="Örn: Çankaya / ANKARA">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="admin-label-light">Merkez Adres Bilgisi (Tam Açık Adres)</label>
                        <textarea name="address" rows="3" class="form-control admin-input-light">{{ old('address', $settings['address'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="admin-label-light">Çalışma Saatleri</label>
                        <input type="text" name="working_hours" value="{{ old('working_hours', $settings['working_hours'] ?? '') }}" class="form-control admin-input-light">
                    </div>
                    <button type="submit" class="btn btn-enterprise-admin mt-3">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Kaydet
                    </button>
                </form>
            </div>

            <!-- 3. Sosyal Medya Tab -->
            <div class="tab-pane fade" id="social" role="tabpanel">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-globe me-1"></i> Sosyal Medya Profil Bağlantıları</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="admin-label-light"><i class="fa-brands fa-linkedin text-primary me-1"></i> LinkedIn Bağlantısı</label>
                            <input type="url" name="linkedin" value="{{ old('linkedin', $settings['linkedin'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                        <div class="col-md-6">
                            <label class="admin-label-light"><i class="fa-brands fa-instagram text-danger me-1"></i> Instagram Bağlantısı</label>
                            <input type="url" name="instagram" value="{{ old('instagram', $settings['instagram'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="admin-label-light"><i class="fa-brands fa-facebook text-primary me-1"></i> Facebook Bağlantısı</label>
                            <input type="url" name="facebook" value="{{ old('facebook', $settings['facebook'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                        <div class="col-md-6">
                            <label class="admin-label-light"><i class="fa-brands fa-x-twitter text-dark me-1"></i> Twitter / X Bağlantısı</label>
                            <input type="url" name="twitter" value="{{ old('twitter', $settings['twitter'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-enterprise-admin mt-3">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Kaydet
                    </button>
                </form>
            </div>

            <!-- 4. SMTP Tab -->
            <div class="tab-pane fade" id="smtp" role="tabpanel">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-server me-1"></i> E-Posta Sunucusu (SMTP) Yapılandırması</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="admin-label-light">SMTP Host Sunucu Adresi</label>
                            <input type="text" name="smtp_host" value="{{ old('smtp_host', $settings['smtp_host'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                        <div class="col-md-4">
                            <label class="admin-label-light">SMTP Port</label>
                            <input type="text" name="smtp_port" value="{{ old('smtp_port', $settings['smtp_port'] ?? '587') }}" class="form-control admin-input-light">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="admin-label-light">SMTP Kullanıcı Adı / E-Posta</label>
                            <input type="text" name="smtp_username" value="{{ old('smtp_username', $settings['smtp_username'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                        <div class="col-md-6">
                            <label class="admin-label-light">SMTP Şifre</label>
                            <input type="password" name="smtp_password" value="{{ old('smtp_password', $settings['smtp_password'] ?? '') }}" class="form-control admin-input-light">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-enterprise-admin mt-3">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Kaydet
                    </button>
                </form>
            </div>

            <!-- 5. reCAPTCHA Tab -->
            <div class="tab-pane fade" id="recaptcha" role="tabpanel">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-shield-halved me-1"></i> Google reCAPTCHA v3 (Görünmez Bot Koruması)</h6>
                    <p class="text-muted small mb-4">Giriş ekranında kullanıcılara bulmaca veya kutucuk işletmeden arka planda bot ve kaba kuvvet (brute-force) saldırılarını engellemek için Google reCAPTCHA v3 korumasını aktifleştirebilirsiniz.</p>

                    <div class="switch-card mb-4 mw-400">
                        <div>
                            <span class="d-block fw-bold text-dark small">reCAPTCHA Bot Koruması</span>
                            <span class="text-muted small" style="font-size: 0.78rem;">Giriş ekranında reCAPTCHA v3 korumasını aktif et</span>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="recaptcha_enabled" id="recaptcha_enabled" value="1" {{ ($settings['recaptcha_enabled'] ?? '') == '1' ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="admin-label-light">reCAPTCHA Site Key (Site Anahtarı)</label>
                            <input type="text" name="recaptcha_site_key" value="{{ old('recaptcha_site_key', $settings['recaptcha_site_key'] ?? '') }}" class="form-control admin-input-light" placeholder="6Ld_...">
                        </div>
                        <div class="col-md-6">
                            <label class="admin-label-light">reCAPTCHA Secret Key (Gizli Anahtar)</label>
                            <input type="password" name="recaptcha_secret_key" value="{{ old('recaptcha_secret_key', $settings['recaptcha_secret_key'] ?? '') }}" class="form-control admin-input-light" placeholder="6Ld_...">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-enterprise-admin mt-3">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Kaydet
                    </button>
                </form>
            </div>

            <!-- 6. Sunucu & Paylaşımlı Hosting Araçları Tab -->
            <div class="tab-pane fade" id="system" role="tabpanel">
                <h6 class="fw-bold text-danger mb-3"><i class="fa-solid fa-microchip me-1"></i> Sunucu Durumu & Sürüm Teşhis Araçları</h6>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="p-3 bg-light border rounded-3">
                            <span class="text-muted small d-block">Laravel Sürümü</span>
                            <strong class="fs-5 text-primary">{{ $systemInfo['laravel_version'] }}</strong>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light border rounded-3">
                            <span class="text-muted small d-block">PHP Sürümü</span>
                            <strong class="fs-5 text-dark">{{ $systemInfo['php_version'] }}</strong>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light border rounded-3">
                            <span class="text-muted small d-block">Veritabanı Sürücüsü</span>
                            <strong class="fs-5 text-success">{{ strtoupper($systemInfo['db_driver']) }}</strong>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light border rounded-3">
                            <span class="text-muted small d-block">PHP Memory Limit</span>
                            <strong class="fs-5 text-warning">{{ $systemInfo['memory_limit'] }}</strong>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-2">Gerekli PHP Eklentileri Durumu</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($systemInfo['extensions'] as $extName => $isLoaded)
                            <span class="badge {{ $isLoaded ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }} p-2 border">
                                <i class="fa-solid {{ $isLoaded ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i> {{ $extName }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="p-4 bg-light border rounded-3 mb-3">
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-screwdriver-wrench text-warning me-2"></i> Paylaşımlı Hosting Tek Tıkla Onarım Araçları</h6>
                    <p class="text-muted small mb-4">Paylaşımlı hosting alanında SSH terminal erişimi bulunmadığında veritabanı güncellemelerini veya storage bağlantısını panele tek tıkla yaptırabilirsiniz.</p>

                    <div class="d-flex flex-wrap gap-3">
                        <form action="{{ route('admin.settings.run-migrations') }}" method="POST" data-confirm="Veritabanı güncellemelerini çalıştırmak istediğinizden emin misiniz?">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary fw-bold">
                                <i class="fa-solid fa-database me-1"></i> Veritabanı Migrasyonlarını Çalıştır
                            </button>
                        </form>

                        <form action="{{ route('admin.settings.storage-link') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-success fw-bold">
                                <i class="fa-solid fa-link me-1"></i> Storage Sembolik Bağlantısını Oluştur (Storage Link)
                            </button>
                        </form>

                        <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning text-dark fw-bold">
                                <i class="fa-solid fa-bolt me-1"></i> Tüm Önbelleği Sıfırla
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
