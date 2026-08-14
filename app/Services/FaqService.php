<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class FaqService extends BaseService
{
    protected string $modelClass = Faq::class;

    /**
     * Create FAQ with multilingual support.
     */
    public function create(array $data, ?UploadedFile $imageFile = null): Model
    {
        $trData = $data['tr'] ?? [];
        $enData = $data['en'] ?? [];

        if (!empty($trData['question']) && empty($data['question'])) {
            $data['question'] = $trData['question'];
        }
        if (!empty($trData['answer']) && empty($data['answer'])) {
            $data['answer'] = $trData['answer'];
        }

        // Clean module entity associations
        if (($data['module_type'] ?? 'general') !== 'service') {
            $data['service_id'] = null;
        }
        if (($data['module_type'] ?? 'general') !== 'project') {
            $data['project_id'] = null;
        }

        $model = $this->model()::create($data);

        if (method_exists($model, 'syncTranslations')) {
            $model->syncTranslations([
                'tr' => $trData,
                'en' => $enData,
            ]);
        }

        return $model;
    }

    /**
     * Update FAQ with multilingual support.
     */
    public function update(Model $model, array $data, ?UploadedFile $imageFile = null, bool $removeImage = false): Model
    {
        $trData = $data['tr'] ?? [];
        $enData = $data['en'] ?? [];

        if (!empty($trData['question'])) {
            $data['question'] = $trData['question'];
        }
        if (!empty($trData['answer'])) {
            $data['answer'] = $trData['answer'];
        }

        if (($data['module_type'] ?? 'general') !== 'service') {
            $data['service_id'] = null;
        }
        if (($data['module_type'] ?? 'general') !== 'project') {
            $data['project_id'] = null;
        }

        $model->update($data);

        if (method_exists($model, 'syncTranslations')) {
            $model->syncTranslations([
                'tr' => $trData,
                'en' => $enData,
            ]);
        }

        return $model;
    }
}
