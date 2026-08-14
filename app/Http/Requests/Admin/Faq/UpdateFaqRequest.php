<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Faq;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tr.question' => 'required_without:question|nullable|string|max:500',
            'tr.answer'   => 'required_without:answer|nullable|string',
            'module_type' => 'required|string|in:general,service,project',
            'service_id'  => 'nullable|exists:services,id',
            'project_id'  => 'nullable|exists:projects,id',
            'order'       => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'tr.question.required_without' => 'Türkçe soru alanını doldurunuz.',
            'tr.answer.required_without'   => 'Türkçe cevap alanını doldurunuz.',
            'module_type.required'         => 'Modül türü seçiniz.',
        ];
    }
}
