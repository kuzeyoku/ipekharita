<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use App\Models\Service;
use App\Models\Project;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SettingService extends BaseService
{
    protected string $modelClass = Setting::class;

    /**
     * Get system diagnostics array for enterprise dashboard/settings.
     */
    public function getSystemDiagnostics(): array
    {
        return [
            'laravel_version'    => app()->version(),
            'php_version'        => PHP_VERSION,
            'memory_limit'       => ini_get('memory_limit'),
            'upload_max_filesize'=> ini_get('upload_max_filesize'),
            'post_max_size'      => ini_get('post_max_size'),
            'app_env'            => config('app.env'),
            'app_debug'          => config('app.debug'),
            'storage_writable'   => is_writable(storage_path()),
            'cache_writable'     => is_writable(base_path('bootstrap/cache')),
            'extensions'         => [
                'PDO'               => extension_loaded('pdo'),
                'OpenSSL'           => extension_loaded('openssl'),
                'Mbstring'          => extension_loaded('mbstring'),
                'Tokenizer'         => extension_loaded('tokenizer'),
                'XML'               => extension_loaded('xml'),
                'Ctype'             => extension_loaded('ctype'),
                'JSON'              => extension_loaded('json'),
                'Fileinfo'          => extension_loaded('fileinfo'),
                'GD (Resim İşleme)' => extension_loaded('gd'),
            ],
            'db_driver'          => DB::connection()->getDriverName(),
        ];
    }

    /**
     * Update bulk settings array.
     */
    public function updateBulk(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::set($key, is_string($value) || is_numeric($value) ? (string) $value : null);
        }
    }

    /**
     * Clear all application, view, route, config, and model caches.
     */
    public function clearAllCaches(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');

        Service::clearCache();
        Project::clearCache();
        BlogPost::clearCache();
        Setting::flushCache();
    }

    /**
     * Run pending database migrations safely.
     */
    public function runMigrations(): string
    {
        Artisan::call('migrate', ['--force' => true]);
        return Artisan::output();
    }

    /**
     * Create storage symlink.
     */
    public function runStorageLink(): void
    {
        Artisan::call('storage:link');
    }
}
