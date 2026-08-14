<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Translation;

use Illuminate\Foundation\Http\FormRequest;

class DeleteLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'locale' => 'required|string|min:2|max:5|not_in:tr',
        ];
    }

    public function messages(): array
    {
        return [
            'locale.required' => 'Silinecek dil kodu zorunludur.',
            'locale.not_in'   => 'Varsayılan Türkçe (tr) dili silinemez.',
        ];
    }
}
