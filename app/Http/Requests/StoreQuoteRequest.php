<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
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
            'service_title' => 'nullable|string|max:255',
            'project_type'  => 'nullable|string|max:255',
            'message'       => 'required|string|min:5|max:5000',
            // Invisible honeypot field
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
            'name.required'    => __('Lütfen kurum veya yetkili adınızı giriniz.'),
            'email.required'   => __('Lütfen e-posta adresinizi giriniz.'),
            'email.email'      => __('Lütfen geçerli bir e-posta adresi giriniz.'),
            'message.required' => __('Lütfen proje detaylarını veya teklif talebinizi belirtiniz.'),
            'message.min'      => __('Mesajınız en az 5 karakter olmalıdır.'),
            'website.max'      => __('Spam koruması algılandı.'),
        ];
    }

    /**
     * Sanitize inputs before passing to model/service.
     */
    public function validatedClean(): array
    {
        $data = $this->validated();
        unset($data['website']);

        $data['name'] = strip_tags(trim((string) ($data['name'] ?? '')));
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));
        $data['phone'] = strip_tags(trim((string) ($data['phone'] ?? '')));
        $data['service_title'] = strip_tags(trim((string) ($data['service_title'] ?? $data['project_type'] ?? '')));
        $data['subject'] = 'Teklif Talebi: ' . ($data['service_title'] ?: 'Genel');
        $data['message'] = strip_tags(trim((string) ($data['message'] ?? '')));

        return $data;
    }
}
