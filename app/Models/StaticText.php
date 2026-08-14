<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StaticText extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'label',
        'value',
    ];

    public static function get($key, $default = '', $group = 'common', $label = null)
    {
        $cacheKey = 'static_text_' . md5($key);

        return Cache::rememberForever($cacheKey, function () use ($key, $default, $group, $label) {
            try {
                $record = static::where('key', $key)->first();
                if ($record) {
                    return $record->value ?? $default;
                }

                // Auto-seed missing key with default text
                static::create([
                    'group' => $group,
                    'key' => $key,
                    'label' => $label ?: \Illuminate\Support\Str::title(str_replace('_', ' ', $key)),
                    'value' => $default,
                ]);

                return $default;
            } catch (\Throwable $e) {
                return $default;
            }
        });
    }

    public static function set($key, $value, $group = 'common', $label = null)
    {
        try {
            $record = static::updateOrCreate(
                ['key' => $key],
                [
                    'group' => $group,
                    'label' => $label ?: \Illuminate\Support\Str::title(str_replace('_', ' ', $key)),
                    'value' => $value,
                ]
            );

            Cache::forget('static_text_' . md5($key));
            return $record;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
