<?php

namespace App\Services;

use App\Models\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

abstract class BaseService
{
    protected string $modelClass;
    protected string $imageDirectory = 'uploads';
    protected string $imageColumn = 'image';
    protected int $imageWidth = 1200;
    protected int $imageHeight = 800;

    /**
     * Get instance of the model.
     */
    protected function model(): Model
    {
        return new $this->modelClass();
    }

    /**
     * Get paginated records with N+1 relation protection.
     */
    public function getPaginated(int $perPage = 10, array $with = [], array $orderBy = ['id' => 'desc']): LengthAwarePaginator
    {
        $query = $this->model()::query();

        if (!empty($with)) {
            $query->with($with);
        }

        if (method_exists($this->model(), 'scopeOrdered')) {
            $query->ordered();
        } else {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }

        return $query->paginate($perPage);
    }

    /**
     * Get all records with N+1 relation protection.
     */
    public function getAll(array $with = []): Collection
    {
        $query = $this->model()::query();

        if (!empty($with)) {
            $query->with($with);
        }

        if (method_exists($this->model(), 'scopeOrdered')) {
            $query->ordered();
        }

        return $query->get();
    }

    /**
     * Find model by ID with optional relations.
     */
    public function findById(int $id, array $with = []): ?Model
    {
        $query = $this->model()::query();

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->find($id);
    }

    /**
     * Create record with automatic WebP image handling and multilingual support.
     */
    public function create(array $data, ?UploadedFile $imageFile = null): Model
    {
        $trData = $data['tr'] ?? [];
        $enData = $data['en'] ?? [];

        // Fallback main table values
        if (!empty($trData['title']) && empty($data['title'])) {
            $data['title'] = $trData['title'];
        }
        if (!empty($trData['summary']) && empty($data['summary'])) {
            $data['summary'] = $trData['summary'];
        }
        if (!empty($trData['content']) && empty($data['content'])) {
            $data['content'] = $trData['content'];
        }
        if (!empty($trData['description']) && empty($data['description'])) {
            $data['description'] = $trData['description'];
        }

        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($imageFile) {
            $data[$this->imageColumn] = ImageService::uploadAndConvert(
                $imageFile,
                $this->imageDirectory,
                $this->imageWidth,
                $this->imageHeight
            );
        }

        $model = $this->model()::create($data);

        if (method_exists($model, 'syncTranslations')) {
            // Ensure TR translation has title/slug if given directly
            if (empty($trData['title']) && !empty($data['title'])) {
                $trData['title'] = $data['title'];
                $trData['slug'] = $data['slug'] ?? Str::slug($data['title']);
                $trData['summary'] = $data['summary'] ?? null;
                $trData['content'] = $data['content'] ?? ($data['description'] ?? null);
            }
            $model->syncTranslations([
                'tr' => $trData,
                'en' => $enData,
            ]);
        }

        return $model;
    }

    /**
     * Update record with automatic WebP image conversion and multilingual support.
     */
    public function update(Model $model, array $data, ?UploadedFile $imageFile = null, bool $removeImage = false): Model
    {
        $trData = $data['tr'] ?? [];
        $enData = $data['en'] ?? [];

        if (!empty($trData['title'])) {
            $data['title'] = $trData['title'];
            $data['slug'] = Str::slug($trData['title']);
        }

        $currentImage = $model->{$this->imageColumn} ?? null;

        // Handle image removal
        if ($removeImage && $currentImage) {
            ImageService::deleteOldImage($currentImage);
            $data[$this->imageColumn] = null;
        }

        // Handle new image upload
        if ($imageFile) {
            $data[$this->imageColumn] = ImageService::uploadAndConvert(
                $imageFile,
                $this->imageDirectory,
                $this->imageWidth,
                $this->imageHeight,
                $currentImage
            );
        }

        $model->update($data);

        if (method_exists($model, 'syncTranslations')) {
            if (empty($trData['title']) && !empty($data['title'])) {
                $trData['title'] = $data['title'];
                $trData['slug'] = $data['slug'] ?? Str::slug($data['title']);
                $trData['summary'] = $data['summary'] ?? null;
                $trData['content'] = $data['content'] ?? ($data['description'] ?? null);
            }
            $model->syncTranslations([
                'tr' => $trData,
                'en' => $enData,
            ]);
        }

        return $model;
    }

    /**
     * Delete record and cleanup image file.
     */
    public function delete(Model $model): bool
    {
        if (isset($model->image)) {
            ImageService::deleteOldImage($model->image);
        }

        return (bool) $model->delete();
    }
}
