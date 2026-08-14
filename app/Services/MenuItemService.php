<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class MenuItemService extends BaseService
{
    protected string $modelClass = MenuItem::class;

    /**
     * Get top-level menu items with children relations.
     */
    public function getTopMenus(): Collection
    {
        return MenuItem::whereNull('parent_id')->with('children')->orderBy('order')->get();
    }

    /**
     * Get all potential parent menu items.
     */
    public function getAllParents(): Collection
    {
        return MenuItem::whereNull('parent_id')->orderBy('order')->get();
    }

    /**
     * Create menu item and clear caches.
     */
    public function create(array $data, ?UploadedFile $imageFile = null): Model
    {
        $item = MenuItem::create($data);
        MenuItem::clearCache();
        return $item;
    }

    /**
     * Update menu item and clear caches.
     */
    public function update(Model $model, array $data, ?UploadedFile $imageFile = null, bool $removeImage = false): Model
    {
        $model->update($data);
        MenuItem::clearCache();
        return $model;
    }

    /**
     * Delete menu item and clear caches.
     */
    public function delete(Model $model): bool
    {
        $result = (bool) $model->delete();
        MenuItem::clearCache();
        return $result;
    }
}
