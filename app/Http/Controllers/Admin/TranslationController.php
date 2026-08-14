<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\TranslationService;
use App\Http\Requests\Admin\Translation\UpdateTranslationRequest;
use App\Http\Requests\Admin\Translation\StoreLanguageRequest;
use App\Http\Requests\Admin\Translation\DeleteLanguageRequest;
use App\Http\Requests\Admin\Translation\StoreTranslationKeyRequest;
use App\Http\Requests\Admin\Translation\DeleteTranslationKeyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TranslationController extends BaseAdminController
{
    public function __construct(protected TranslationService $translationService)
    {
    }

    /**
     * Display unified language and translation management interface.
     */
    public function index(Request $request): View
    {
        $locales = $this->translationService->getAvailableLocales();
        $selectedLocale = $request->get('locale', 'tr');
        if (!isset($locales[$selectedLocale])) {
            $selectedLocale = 'tr';
        }

        $files = $this->translationService->getTranslationFiles($selectedLocale);
        $selectedFile = $request->get('file', $files[0] ?? 'site');
        if (!in_array($selectedFile, $files) && !empty($files)) {
            $selectedFile = $files[0];
        }

        $translations = $this->translationService->getTranslations($selectedLocale, $selectedFile);
        $baseTranslations = $this->translationService->getBaseTranslations($selectedFile);

        return $this->renderView('admin.translations.index', compact(
            'locales',
            'selectedLocale',
            'files',
            'selectedFile',
            'translations',
            'baseTranslations'
        ));
    }

    /**
     * Update/Save bulk translations for the specified locale and file.
     */
    public function update(UpdateTranslationRequest $request): RedirectResponse
    {
        $locale = $request->validated('locale');
        $file = $request->validated('file');
        $keys = $request->input('keys', []);

        $this->translationService->saveTranslations($locale, $file, $keys);

        return redirect()->route('admin.translations.index', [
            'locale' => $locale,
            'file'   => $file,
        ])->with('success', "({$locale}/{$file}) Çevirileri başarıyla güncellendi ve önbellek temizlendi.");
    }

    /**
     * Add a new translation key to the specified locale and file.
     */
    public function addKey(StoreTranslationKeyRequest $request): RedirectResponse
    {
        $locale = $request->validated('locale');
        $file = $request->validated('file');
        $key = trim($request->validated('key'));
        $value = (string) $request->input('value', '');

        $this->translationService->addTranslationKey($locale, $file, $key, $value);

        return redirect()->route('admin.translations.index', [
            'locale' => $locale,
            'file'   => $file,
        ])->with('success', "Yeni çeviri anahtarı '{$key}' başarıyla eklendi.");
    }

    /**
     * Delete a single translation key from the specified locale and file.
     */
    public function deleteKey(DeleteTranslationKeyRequest $request): RedirectResponse
    {
        $locale = $request->validated('locale');
        $file = $request->validated('file');
        $key = $request->validated('key');

        $this->translationService->deleteTranslationKey($locale, $file, $key);

        return redirect()->route('admin.translations.index', [
            'locale' => $locale,
            'file'   => $file,
        ])->with('success', "'{$key}' çeviri anahtarı silindi.");
    }

    /**
     * Initialize a new language locale.
     */
    public function storeLanguage(StoreLanguageRequest $request): RedirectResponse
    {
        $locale = strtolower(trim($request->validated('locale')));

        $this->translationService->createLanguage($locale);

        return redirect()->route('admin.translations.index', [
            'locale' => $locale,
        ])->with('success', "Yeni dil '{$locale}' başarıyla oluşturuldu ve şablon dosyaları kopyalandı.");
    }

    /**
     * Delete a language locale and all its files.
     */
    public function destroyLanguage(DeleteLanguageRequest $request): RedirectResponse
    {
        $locale = strtolower(trim($request->validated('locale')));

        try {
            $this->translationService->deleteLanguage($locale);
            return redirect()->route('admin.translations.index', ['locale' => 'tr'])
                ->with('success', "('{$locale}') dili ve tüm çeviri dosyaları başarıyla silindi.");
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
