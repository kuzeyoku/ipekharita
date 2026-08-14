<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Reference;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'url'          => 'nullable|url|max:255',
            'order'        => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'remove_image' => 'nullable|boolean',
        ];
    }
}
