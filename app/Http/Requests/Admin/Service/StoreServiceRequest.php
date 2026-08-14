<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'icon'     => 'nullable|string|max:255',
            'order'    => 'nullable|integer',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
    }
}
