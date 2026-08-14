<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasTranslation;
use App\Models\Translations\ProjectTranslation;

class Project extends BaseModel
{
    use HasFactory, HasTranslation;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'category',
        'location',
        'client',
        'year',
        'summary',
        'description',
        'image',
        'order',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'order' => 'integer',
    ];

    public function translations()
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'project_id')->where('is_active', true)->orderBy('order');
    }

    public function categoryRel()
    {
        return $this->belongsTo(Category::class, 'category_id');
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

    public function getDescriptionAttribute($value)
    {
        return $this->getTranslatedAttribute('description') ?: $value;
    }

    public function getLocationAttribute($value)
    {
        return $this->getTranslatedAttribute('location') ?: $value;
    }

    public function getClientAttribute($value)
    {
        return $this->getTranslatedAttribute('client') ?: $value;
    }

    public function getMetaDescriptionAttribute($value)
    {
        if (!empty($value)) {
            return (string) $value;
        }
        $text = $this->summary ?: $this->description;
        return $text ? \Illuminate\Support\Str::limit(strip_tags($text), 160) : null;
    }

    protected static function booted()
    {
        static::saved(function ($project) {
            static::clearCache($project);
        });

        static::deleted(function ($project) {
            static::clearCache($project);
        });
    }

    public static function clearCache($project = null)
    {
        Cache::forget('cache_projects_featured');
        Cache::forget('cache_projects_featured_v2');
        Cache::forget('cache_projects_all');
        Cache::forget('cache_projects_all_v2');
        if ($project && !empty($project->slug)) {
            Cache::forget('cache_project_detail_' . $project->slug);
        }
    }
}
