<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'nullable|string|max:100',
            'subject'       => 'nullable|string|max:255',
            'service_title' => 'nullable|string|max:255',
            'message'       => 'required|string|min:5|max:5000',
            // Invisible honeypot field to block automated spam bots
            'website'       => 'nullable|max:0',
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
            'name.required'    => __('Lütfen adınızı ve soyadınızı giriniz.'),
            'name.max'         => __('Ad alanı en fazla 255 karakter olabilir.'),
            'email.required'   => __('Lütfen e-posta adresinizi giriniz.'),
            'email.email'      => __('Lütfen geçerli bir e-posta adresi giriniz.'),
            'message.required' => __('Lütfen mesajınızı yazınız.'),
            'message.min'      => __('Mesajınız en az 5 karakter olmalıdır.'),
            'message.max'      => __('Mesajınız en fazla 5000 karakter olabilir.'),
            'website.max'      => __('Spam koruması algılandı.'),
        ];
    }

    /**
     * Sanitize inputs before passing to controller/service.
     */
    public function validatedClean(): array
    {
        $data = $this->validated();
        unset($data['website']);

        $data['name'] = strip_tags(trim((string) ($data['name'] ?? '')));
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));
        $data['phone'] = strip_tags(trim((string) ($data['phone'] ?? '')));
        $data['subject'] = strip_tags(trim((string) ($data['subject'] ?? '')));
        $data['service_title'] = strip_tags(trim((string) ($data['service_title'] ?? '')));
        $data['message'] = strip_tags(trim((string) ($data['message'] ?? '')));

        return $data;
    }
}
