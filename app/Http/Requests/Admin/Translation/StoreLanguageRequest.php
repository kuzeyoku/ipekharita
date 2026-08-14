<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Translation;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'locale' => 'required|string|min:2|max:5|alpha_dash',
        ];
    }

    public function messages(): array
    {
        return [
            'locale.required' => 'Dil kodu zorunludur (örneğin: de, fr, ar).',
            'locale.alpha_dash' => 'Geçerli bir dil kodu giriniz.',
        ];
    }
}
