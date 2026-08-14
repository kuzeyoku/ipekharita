<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseModel extends Model
{
    protected static array $columnCache = [];

    protected function hasTableColumn(string $column): bool
    {
        $key = $this->getTable() . '.' . $column;
        if (!isset(static::$columnCache[$key])) {
            static::$columnCache[$key] = \Schema::hasColumn($this->getTable(), $column);
        }
        return static::$columnCache[$key];
    }

    /**
     * Scope to filter active records.
     */
    public function scopeActive(Builder $query): Builder
    {
        if ($this->hasTableColumn('is_active')) {
            return $query->where('is_active', true);
        }
        return $query;
    }

    /**
     * Scope to order by 'order' or 'id'.
     */
    public function scopeOrdered(Builder $query, string $direction = 'asc'): Builder
    {
        if ($this->hasTableColumn('order')) {
            $query->orderBy('order', $direction);
        }
        return $query->orderBy('id', 'desc');
    }

    /**
     * Scope for quick keyword search.
     */
    public function scopeSearch(Builder $query, string $column, ?string $term): Builder
    {
        if ($term) {
            return $query->where($column, 'LIKE', "%{$term}%");
        }
        return $query;
    }
}
