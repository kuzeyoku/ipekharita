<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    protected static ?array $settingsCache = null;

    protected static function loadSettings(): array
    {
        if (static::$settingsCache !== null) {
            return static::$settingsCache;
        }

        static::$settingsCache = Cache::rememberForever('site_settings_all', function () {
            try {
                return static::pluck('value', 'key')->all();
            } catch (\Throwable $e) {
                return [];
            }
        });

        return static::$settingsCache ?? [];
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $all = static::loadSettings();
        if (array_key_exists($key, $all) && $all[$key] !== null && $all[$key] !== '') {
            return (string) $all[$key];
        }

        // Key alias map for legacy & template compatibility
        $aliases = [
            'company_phone'         => 'phone',
            'company_email'         => 'email',
            'company_address'       => 'address',
            'company_address_short' => 'address',
            'company_name'          => 'site_title',
            'brand_name'            => 'site_title',
            'site_name'             => 'site_title',
        ];

        if (isset($aliases[$key]) && array_key_exists($aliases[$key], $all) && $all[$aliases[$key]] !== null) {
            return (string) $all[$aliases[$key]];
        }

        return $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::flushCache();
    }

    public static function flushCache(): void
    {
        static::$settingsCache = null;
        Cache::forget('site_settings_all');
    }
}
