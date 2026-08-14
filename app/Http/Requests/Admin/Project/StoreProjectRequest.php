<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tr.title'    => 'required_without:title|nullable|string|max:255',
            'title'       => 'required_without:tr.title|nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'order'       => 'nullable|integer',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
    }
}
