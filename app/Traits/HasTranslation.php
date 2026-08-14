<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

trait HasTranslation
{
    /**
     * Scope query to find model by slug in main table or translation tables.
     */
    public function scopeWhereSlug($query, string $slug)
    {
        return $query->where(function ($q) use ($slug) {
            $q->where($this->getTable() . '.slug', $slug)
              ->orWhereHas('translations', function ($tq) use ($slug) {
                  $tq->where('slug', $slug);
              });
        });
    }

    /**
     * Helper to retrieve and cache translations collection on model instance.
     */
    protected function getLoadedTranslations()
    {
        if (!$this->relationLoaded('translations')) {
            $this->setRelation('translations', $this->translations()->get());
        }
        return $this->translations;
    }

    /**
     * Get exact translation for locale or null.
     */
    public function translation(?string $locale = null)
    {
        $locale = $locale ?: App::getLocale();
        return $this->getLoadedTranslations()->firstWhere('locale', $locale);
    }

    /**
     * Get translation instance for specified locale or fallback to 'tr'.
     */
    public function translateOrDefault(?string $locale = null)
    {
        $locale = $locale ?: App::getLocale();
        $translations = $this->getLoadedTranslations();

        // 1. Try exact locale match
        $match = $translations->firstWhere('locale', $locale);
        if ($match) {
            return $match;
        }

        // 2. Fallback to 'tr'
        $fallback = $translations->firstWhere('locale', 'tr');
        if ($fallback) {
            return $fallback;
        }

        // 3. First available translation
        return $translations->first();
    }

    /**
     * Helper to get translated attribute value with fallback chain.
     */
    public function getTranslatedAttribute(string $attribute, ?string $locale = null)
    {
        $translation = $this->translateOrDefault($locale);
        if ($translation && !empty($translation->{$attribute})) {
            return $translation->{$attribute};
        }

        // If the exact translation exists but has an empty attribute, fallback to 'tr' attribute
        $fallback = $this->getLoadedTranslations()->firstWhere('locale', 'tr');
        if ($fallback && !empty($fallback->{$attribute})) {
            return $fallback->{$attribute};
        }

        // Fall back to main table attribute if exists
        return $this->attributes[$attribute] ?? null;
    }

    /**
     * Sync multi-locale translations array (e.g. ['tr' => [...], 'en' => [...]]).
     */
    public function syncTranslations(array $localesData)
    {
        foreach ($localesData as $locale => $fields) {
            if (!is_array($fields)) continue;

            // Check if any field is filled
            $hasData = array_filter($fields, fn($val) => !is_null($val) && $val !== '');
            if (!empty($hasData)) {
                if (isset($fields['title']) && empty($fields['slug']) && !empty($fields['title'])) {
                    $fields['slug'] = Str::slug($fields['title']);
                }
                $this->translations()->updateOrCreate(
                    ['locale' => $locale],
                    $fields
                );
            }
        }
    }
}
