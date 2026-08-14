<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\SiteModal;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteModalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tr.title'   => 'required_without:title|nullable|string|max:255',
            'title'      => 'required_without:tr.title|nullable|string|max:255',
            'btn_url'    => 'nullable|string|max:255',
            'show_delay' => 'nullable|integer|min:0|max:60',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
    }
}
