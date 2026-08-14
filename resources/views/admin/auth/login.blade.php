<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli Girişi |
        {{ setting('company_name', setting('site_title', config('app.name', 'Yönetim Paneli'))) }}
    </title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/hero/icon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/admin.css') }}">
    @if(!empty($isRecaptchaActive) && !empty($recaptchaSiteKey))
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}"></script>
    @endif
</head>

<body class="login-body-light">

    <div class="login-wrapper-split">
        <!-- Left Side: Interactive Dynamic Hero with Mouse-Tracking TIN Triangulated Mesh -->
        <div class="login-hero-side position-relative overflow-hidden">
            <!-- Animated Interactive Mesh Canvas -->
            <canvas id="tinMeshCanvas" class="tin-mesh-canvas" data-theme="dark"></canvas>

            <div class="d-flex align-items-center justify-content-between position-relative z-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="login-brand-icon-wrapper login-brand-small-icon mb-0"
                        style="background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3);">
                        <i class="fa-solid fa-compass text-info"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="fw-extrabold text-white font-outfit tracking-wide login-brand-title">Kuzeyoku
                            Software</span>
                        <span class="text-info fw-bold login-brand-sub">Yönetim Paneli</span>
                    </div>
                </div>
                <span class="login-hero-badge mb-0"><i class="fa-solid fa-shield-halved text-info"></i> ISO 27001 &
                    OWASP Güvenli Giriş</span>
            </div>

            <div class="login-hero-content my-auto">
                <div class="mb-4">
                    <img src="{{ asset('assets/img/logo/ipek_logo_white.png') }}"
                        alt="{{ setting('company_name') ?: 'İpek Harita Mühendislik' }}" class="login-hero-logo">
                </div>
                <span class="login-hero-badge mb-3"><i class="fa-solid fa-microchip text-info"></i> Enterprise Core
                    v3.0</span>
                <h1 class="login-hero-title mb-1">YÖNETİM PLATFORMU</h1>
                <h5 class="login-hero-subheading fw-bold font-outfit mb-2">
                    {{ mb_strtoupper(setting('company_name') ?: 'İPEK MÜHENDİSLİK') }}
                </h5>

                <div class="login-tech-pills">
                    <span class="login-tech-pill"><i class="fa-solid fa-language text-warning"></i> Dinamik Çok Dilli
                        Altyapı</span>
                    <span class="login-tech-pill"><i class="fa-solid fa-lock text-success"></i> Çok Katmanlı
                        Güvenlik</span>
                </div>
            </div>

            <div class="login-hero-footer">
                <span>© {{ date('Y') }} {{ setting('company_name') ?: 'İpek Harita Mühendislik' }}</span>
                <span class="d-flex align-items-center gap-2">
                    <span class="pulse-dot-green"></span>
                    <span class="text-white-50 font-monospace">Sistem Aktif & Güvenli</span>
                </span>
            </div>
        </div>

        <!-- Right Side: Elevated Luxury Login Form -->
        <div class="login-form-side">
            <div class="login-form-container">
                <div class="login-brand-header text-center">
                    <div class="login-brand-icon-wrapper">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="login-panel-title">Yönetici Girişi</h3>
                    <p class="text-muted small mb-0">Sisteme erişmek için yetkili kimlik bilgilerinizi doğrulayınız.</p>
                </div>

                @if($errors->any())
                    <div
                        class="alert alert-danger bg-danger bg-opacity-10 border-0 text-danger rounded-3 mb-4 small p-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation fs-5 flex-shrink-0"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST" id="adminLoginForm"
                    @if(!empty($isRecaptchaActive) && !empty($recaptchaSiteKey))
                    data-recaptcha-sitekey="{{ $recaptchaSiteKey }}" @endif>
                    @csrf
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                    <div class="mb-3">
                        <label class="admin-label-light">
                            <i class="fa-solid fa-envelope text-primary"></i> E-Posta Adresi
                        </label>
                        <div class="input-group login-input-group">
                            <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="admin@example.com" required autofocus autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="admin-label-light mb-0">
                                <i class="fa-solid fa-lock text-primary"></i> Güvenli Şifre
                            </label>
                        </div>
                        <div class="input-group login-input-group">
                            <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                            <input type="password" name="password" id="passwordInput" class="form-control"
                                placeholder="••••••••" required autocomplete="current-password">
                            <button type="button" class="btn password-toggle-btn" id="togglePasswordBtn"
                                title="Şifreyi Göster/Gizle">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4 pt-1">
                        <label class="luxury-switch-wrapper" for="remember">
                            <input type="checkbox" name="remember" id="remember" class="luxury-switch-input" checked>
                            <span class="luxury-switch-track">
                                <span class="luxury-switch-knob"></span>
                            </span>
                            <span class="luxury-switch-label">Beni Hatırla</span>
                        </label>
                        <span class="login-ssl-badge">
                            <i class="fa-solid fa-shield-check text-success"></i> 256-Bit SSL
                        </span>
                    </div>

                    <button type="submit"
                        class="btn btn-enterprise-admin w-100 py-3 justify-content-center fw-bold fs-6">
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Panele Giriş Yap
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top border-light">
                    <a href="{{ route('home') }}" class="login-back-link">
                        <i class="fa-solid fa-arrow-left"></i> Web Sitesine Dön
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/tin-mesh.js') }}"></script>
    <script src="{{ asset('admin-assets/js/admin.js') }}"></script>
</body>

</html>