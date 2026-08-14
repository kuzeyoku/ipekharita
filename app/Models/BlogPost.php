<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasTranslation;
use App\Models\Translations\BlogPostTranslation;

class BlogPost extends BaseModel
{
    use HasFactory, HasTranslation;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'summary',
        'content',
        'author',
        'image',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function translations()
    {
        return $this->hasMany(BlogPostTranslation::class, 'blog_post_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_post_id');
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class, 'blog_post_id')->where('is_approved', true)->latest();
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
        static::saved(function ($post) {
            static::clearCache($post);
        });

        static::deleted(function ($post) {
            static::clearCache($post);
        });
    }

    public static function clearCache($post = null)
    {
        Cache::forget('cache_blog_latest');
        Cache::forget('cache_blog_latest_v2');
        Cache::forget('cache_blog_all');
        Cache::forget('cache_blog_all_v2');
        if ($post && !empty($post->slug)) {
            Cache::forget('cache_blog_detail_' . $post->slug);
        }
    }
}
