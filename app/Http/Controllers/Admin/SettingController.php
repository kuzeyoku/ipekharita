<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Services\SettingService;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends BaseAdminController
{
    public function __construct(protected SettingService $settingService)
    {
    }

    public function index(): View
    {
        $keys = [
            // General & Branding
            'site_title', 'site_description', 'company_name', 'brand_name',
            // Contact
            'phone', 'phone_2', 'email', 'address', 'company_address_short', 'working_hours', 'google_maps_iframe',
            // Social Media
            'facebook', 'instagram', 'linkedin', 'twitter', 'youtube',
            // SMTP
            'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption', 'smtp_from_address', 'smtp_from_name',
            // reCAPTCHA
            'recaptcha_enabled', 'recaptcha_site_key', 'recaptcha_secret_key',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key, '');
        }

        $systemInfo = $this->settingService->getSystemDiagnostics();

        return $this->renderView('admin.settings.index', compact('settings', 'systemInfo'));
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $data = $request->except('_token');

        $this->settingService->updateBulk($data);

        return $this->redirectSuccess('admin.settings.index', 'Tüm site ayarları ve statik metinler başarıyla güncellendi.');
    }

    public function clearCache(): RedirectResponse
    {
        $this->settingService->clearAllCaches();

        return $this->redirectSuccess('admin.settings.index', 'Tüm sistem önbelleği, modül önbellekleri ve sayfa görünümleri başarıyla temizlendi.');
    }

    public function runMigrations(): RedirectResponse
    {
        try {
            $output = $this->settingService->runMigrations();
            return $this->redirectSuccess('admin.settings.index', 'Veritabanı güncellemeleri (Migrations) başarıyla çalıştırıldı: ' . $output);
        } catch (\Throwable $e) {
            return $this->redirectError('admin.settings.index', 'Migrasyon çalıştırılırken hata oluştu: ' . $e->getMessage());
        }
    }

    public function runStorageLink(): RedirectResponse
    {
        try {
            $this->settingService->runStorageLink();
            return $this->redirectSuccess('admin.settings.index', 'Storage sembolik köprüsü (symlink) başarıyla oluşturuldu.');
        } catch (\Throwable $e) {
            return $this->redirectError('admin.settings.index', 'Storage link oluşturulurken hata: ' . $e->getMessage());
        }
    }
}
