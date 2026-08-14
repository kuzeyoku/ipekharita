<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Translation;

use Illuminate\Foundation\Http\FormRequest;

class StoreTranslationKeyRequest extends FormRequest
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
            'key'    => 'required|string|max:255',
            'value'  => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'key.required' => 'Çeviri anahtarı adı zorunludur (örneğin: hero_title veya title).',
        ];
    }
}
