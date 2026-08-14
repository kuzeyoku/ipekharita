<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasTranslation;
use App\Models\Translations\ServiceTranslation;

class Service extends BaseModel
{
    use HasFactory, HasTranslation;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'icon',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function translations()
    {
        return $this->hasMany(ServiceTranslation::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'service_id')->where('is_active', true)->orderBy('order');
    }

    public function getTitleAttribute($value)
    {
        return $this->getTranslatedAttribute('title') ?: $value;
    }

    public function getSlugAttribute($value)
    {
        return $this->getTranslatedAttribute('slug') ?: $value;
    }

    public function getSummaryAttribute($value)
    {
        return $this->getTranslatedAttribute('summary') ?: $value;
    }

    public function getContentAttribute($value)
    {
        return $this->getTranslatedAttribute('content') ?: $value;
    }

    public function getMetaDescriptionAttribute($value)
    {
        if (!empty($value)) {
            return (string) $value;
        }
        $text = $this->summary ?: $this->content;
        return $text ? \Illuminate\Support\Str::limit(strip_tags($text), 160) : null;
    }

    protected static function booted()
    {
        static::saved(function ($service) {
            static::clearCache($service);
        });

        static::deleted(function ($service) {
            static::clearCache($service);
        });
    }

    public static function clearCache($service = null)
    {
        Cache::forget('cache_services_active');
        Cache::forget('cache_services_active_v2');
        Cache::forget('cache_services_all');
        Cache::forget('cache_header_services_v5_tr');
        Cache::forget('cache_header_services_v5_en');
        Cache::forget('cache_footer_services_v5_tr');
        Cache::forget('cache_footer_services_v5_en');
        if ($service && !empty($service->slug)) {
            Cache::forget('cache_service_detail_' . $service->slug);
        }
    }
}
