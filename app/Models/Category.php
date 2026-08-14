<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Traits\HasTranslation;
use App\Models\Translations\CategoryTranslation;

class Category extends BaseModel
{
    use HasFactory, HasTranslation;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'description',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function getTitleAttribute($value)
    {
        return $this->getTranslatedAttribute('title') ?: $value;
    }

    public function getSlugAttribute($value)
    {
        return $this->getTranslatedAttribute('slug') ?: $value;
    }

    public function getDescriptionAttribute($value)
    {
        return $this->getTranslatedAttribute('description') ?: $value;
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('title') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'blog' => 'Blog & Haber',
            'project' => 'Proje',
            'service' => 'Hizmet',
            default => ucfirst($this->type),
        };
    }
}
