<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\MenuItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => 'required|string|max:255',
            'icon'      => 'nullable|string|max:100',
            'url'       => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order'     => 'nullable|integer',
            'target'    => 'nullable|string|in:_self,_blank',
            'is_active' => 'nullable|boolean',
        ];
    }
}
