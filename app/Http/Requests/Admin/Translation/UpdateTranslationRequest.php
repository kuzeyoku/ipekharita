<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Translation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'locale' => 'required|string|max:10',
            'file'   => 'required|string|max:50',
            'keys'   => 'nullable|array',
        ];
    }
}
