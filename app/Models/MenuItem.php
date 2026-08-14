<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'title',
        'icon',
        'url',
        'order',
        'target',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function activeChildren()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->where('is_active', true)->orderBy('order');
    }

    /**
     * Clear menu cache on saved or deleted.
     */
    protected static function booted()
    {
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });
    }

    public static function clearCache()
    {
        Cache::forget('header_menu_tree_v3_tr');
        Cache::forget('header_menu_tree_v3_en');
        Cache::forget('header_menu_tree_v2');
        Cache::forget('header_menu_tree');
    }

    /**
     * Get active menu tree for frontend header.
     */
    public static function getTree()
    {
        $cacheKey = 'header_menu_tree_v3_' . app()->getLocale();
        $tree = Cache::rememberForever($cacheKey, function () {
            try {
                return static::whereNull('parent_id')
                    ->where('is_active', true)
                    ->with(['translations', 'activeChildren.translations'])
                    ->orderBy('order')
                    ->get();
            } catch (\Throwable $e) {
                return collect([]);
            }
        });

        if ($tree instanceof \__PHP_Incomplete_Class || !is_countable($tree)) {
            Cache::forget($cacheKey);
            try {
                $tree = static::whereNull('parent_id')
                    ->where('is_active', true)
                    ->with(['translations', 'activeChildren.translations'])
                    ->orderBy('order')
                    ->get();
            } catch (\Throwable $e) {
                $tree = collect([]);
            }
        }

        return $tree;
    }
}
