<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Ad soyad alanı zorunludur.',
            'email.required'     => 'E-posta adresi zorunludur.',
            'email.email'        => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique'       => 'Bu e-posta adresi zaten kullanılmaktadır.',
            'password.required'  => 'Şifre alanı zorunludur.',
            'password.min'       => 'Şifre en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
        ];
    }
}
