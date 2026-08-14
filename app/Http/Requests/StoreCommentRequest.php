<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'comment' => 'required|string|min:5|max:2000',
            // Invisible honeypot field
            'website' => 'nullable|max:0',
        ];
    }

    /**
     * Custom validation error messages in Turkish.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'    => __('Adınız alanını doldurunuz.'),
            'email.required'   => __('E-posta alanını doldurunuz.'),
            'email.email'      => __('Geçerli bir e-posta adresi giriniz.'),
            'comment.required' => __('Yorumunuzu yazınız.'),
            'comment.min'      => __('Yorum en az 5 karakter olmalıdır.'),
            'comment.max'      => __('Yorum en fazla 2000 karakter olabilir.'),
            'website.max'      => __('Spam koruması algılandı.'),
        ];
    }

    /**
     * Sanitize inputs to prevent Stored XSS attacks.
     */
    public function validatedClean(): array
    {
        $data = $this->validated();
        unset($data['website']);

        $data['name'] = strip_tags(trim((string) ($data['name'] ?? '')));
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));
        $data['comment'] = strip_tags(trim((string) ($data['comment'] ?? '')));

        return $data;
    }
}
