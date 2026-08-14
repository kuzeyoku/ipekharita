<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tr.title' => 'required_without:title|nullable|string|max:255',
            'title'    => 'required_without:tr.title|nullable|string|max:255',
            'type'     => 'required|string|in:blog,project,service',
            'order'    => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Modül türü seçiniz.',
        ];
    }
}
