<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class TranslationService
{
    /**
     * Predefined dictionary of supported languages and metadata.
     */
    protected array $supportedLanguages = [
        'tr' => ['name' => 'Türkçe', 'native' => 'Türkçe', 'flag' => '🇹🇷', 'default' => true],
        'en' => ['name' => 'English', 'native' => 'English', 'flag' => '🇬🇧', 'default' => false],
        'de' => ['name' => 'Almanca', 'native' => 'Deutsch', 'flag' => '🇩🇪', 'default' => false],
        'fr' => ['name' => 'Fransızca', 'native' => 'Français', 'flag' => '🇫🇷', 'default' => false],
        'ar' => ['name' => 'Arapça', 'native' => 'العربية', 'flag' => '🇸🇦', 'default' => false],
        'ru' => ['name' => 'Rusça', 'native' => 'Русский', 'flag' => '🇷🇺', 'default' => false],
        'es' => ['name' => 'İspanyolca', 'native' => 'Español', 'flag' => '🇪🇸', 'default' => false],
        'it' => ['name' => 'İtalyanca', 'native' => 'Italiano', 'flag' => '🇮🇹', 'default' => false],
    ];

    /**
     * Get all detected locales from the lang/ directory.
     */
    public function getAvailableLocales(): array
    {
        $langPath = base_path('lang');
        $locales = [];

        if (File::exists($langPath)) {
            $directories = File::directories($langPath);
            foreach ($directories as $dir) {
                $code = basename($dir);
                $meta = $this->supportedLanguages[$code] ?? [
                    'name' => strtoupper($code),
                    'native' => strtoupper($code),
                    'flag' => '🌐',
                    'default' => false,
                ];

                $filesCount = count(File::files($dir));
                $locales[$code] = array_merge($meta, [
                    'code' => $code,
                    'files_count' => $filesCount,
                    'is_active' => in_array($code, ['tr', 'en']), // active locales
                ]);
            }
        }

        // Always ensure 'tr' and 'en' are present
        if (!isset($locales['tr'])) {
            $locales['tr'] = array_merge($this->supportedLanguages['tr'], ['code' => 'tr', 'files_count' => 0, 'is_active' => true]);
        }
        if (!isset($locales['en'])) {
            $locales['en'] = array_merge($this->supportedLanguages['en'], ['code' => 'en', 'files_count' => 0, 'is_active' => true]);
        }

        // Always put default locale ('tr') FIRST, followed by 'en', then alphabetical
        uksort($locales, function ($a, $b) {
            if ($a === 'tr') return -1;
            if ($b === 'tr') return 1;
            if ($a === 'en') return -1;
            if ($b === 'en') return 1;
            return strcmp($a, $b);
        });

        return $locales;
    }

    /**
     * Get all translation files for a specific locale.
     */
    public function getTranslationFiles(string $locale): array
    {
        $localeDir = base_path("lang/{$locale}");
        $files = [];

        if (File::exists($localeDir)) {
            foreach (File::files($localeDir) as $file) {
                if ($file->getExtension() === 'php') {
                    $filename = $file->getFilenameWithoutExtension();
                    $files[] = $filename;
                }
            }
        }

        // Also check if {locale}.json exists
        if (File::exists(base_path("lang/{$locale}.json"))) {
            $files[] = '_json';
        }

        // Sort: site and common first, then alphabetical
        usort($files, function ($a, $b) {
            if ($a === 'site') return -1;
            if ($b === 'site') return 1;
            if ($a === 'common') return -1;
            if ($b === 'common') return 1;
            return strcmp($a, $b);
        });

        return $files;
    }

    /**
     * Load raw and flat translation array for a locale and file.
     */
    public function getTranslations(string $locale, string $file): array
    {
        if ($file === '_json') {
            $path = base_path("lang/{$locale}.json");
            if (File::exists($path)) {
                $content = json_decode(File::get($path), true) ?: [];
                return Arr::dot($content);
            }
            return [];
        }

        $path = base_path("lang/{$locale}/{$file}.php");
        if (File::exists($path)) {
            $content = include $path;
            if (is_array($content)) {
                return Arr::dot($content);
            }
        }

        return [];
    }

    /**
     * Get base locale ('tr') translations to use as side-by-side reference.
     */
    public function getBaseTranslations(string $file): array
    {
        return $this->getTranslations('tr', $file);
    }

    /**
     * Save translation keys for a locale and file.
     */
    public function saveTranslations(string $locale, string $file, array $flatData): void
    {
        if ($file === '_json') {
            $path = base_path("lang/{$locale}.json");
            $nested = [];
            foreach ($flatData as $key => $value) {
                Arr::set($nested, $key, (string) $value);
            }
            File::put($path, json_encode($nested, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            $dir = base_path("lang/{$locale}");
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            $path = "{$dir}/{$file}.php";
            $nested = [];
            foreach ($flatData as $key => $value) {
                Arr::set($nested, $key, (string) $value);
            }

            $exported = var_export($nested, true);
            $exported = str_replace(['array (', ')'], ['[', ']'], $exported);

            $phpContent = "<?php\n\ndeclare(strict_types=1);\n\nreturn " . $exported . ";\n";
            File::put($path, $phpContent);
        }

        // Clear view and cache
        Artisan::call('view:clear');
    }

    /**
     * Add a single new translation key.
     */
    public function addTranslationKey(string $locale, string $file, string $key, string $value): void
    {
        $translations = $this->getTranslations($locale, $file);
        $translations[$key] = $value;
        $this->saveTranslations($locale, $file, $translations);
    }

    /**
     * Delete a single translation key.
     */
    public function deleteTranslationKey(string $locale, string $file, string $key): void
    {
        $translations = $this->getTranslations($locale, $file);
        unset($translations[$key]);
        $this->saveTranslations($locale, $file, $translations);
    }

    /**
     * Initialize a new language locale by cloning the base 'tr' structure.
     */
    public function createLanguage(string $locale): void
    {
        $targetDir = base_path("lang/{$locale}");
        $baseDir = base_path('lang/tr');

        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        if (File::exists($baseDir)) {
            $files = File::files($baseDir);
            foreach ($files as $file) {
                $targetFile = "{$targetDir}/" . $file->getFilename();
                if (!File::exists($targetFile)) {
                    File::copy($file->getPathname(), $targetFile);
                }
            }
        }

        $baseJson = base_path('lang/tr.json');
        $targetJson = base_path("lang/{$locale}.json");
        if (File::exists($baseJson) && !File::exists($targetJson)) {
            File::copy($baseJson, $targetJson);
        }
    }

    /**
     * Delete a language locale and all its associated translation files.
     */
    public function deleteLanguage(string $locale): bool
    {
        if ($locale === 'tr') {
            throw new \InvalidArgumentException('Varsayılan Türkçe (tr) dili silinemez.');
        }

        $targetDir = base_path("lang/{$locale}");
        if (File::exists($targetDir)) {
            File::deleteDirectory($targetDir);
        }

        $targetJson = base_path("lang/{$locale}.json");
        if (File::exists($targetJson)) {
            File::delete($targetJson);
        }

        // Clear view and cache
        Artisan::call('view:clear');

        return true;
    }
}
