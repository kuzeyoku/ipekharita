<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Traits\HasTranslation;
use App\Models\Translations\PageTranslation;

class Page extends BaseModel
{
    use HasFactory, HasTranslation;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'meta_description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
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
        $desc = $this->getTranslatedAttribute('meta_description') ?: $value;
        if (!empty($desc)) {
            return (string) $desc;
        }
        $text = $this->summary ?: $this->content;
        return $text ? Str::limit(strip_tags($text), 160) : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }
}
