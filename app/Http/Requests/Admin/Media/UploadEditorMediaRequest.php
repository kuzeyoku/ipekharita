<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Media;

use Illuminate\Foundation\Http\FormRequest;

class UploadEditorMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ];
    }
}
