<?php

namespace App\Http\Requests;

use App\Services\QrisValidator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilUsahaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->tenant_id !== null;
    }

    public function rules(): array
    {
        return [
            'nama_usaha' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'alamat' => ['required', 'string', 'max:500'],
            'no_hp' => ['required', 'string', 'regex:/^[\+\d\s\-\(\)]+$/', 'max:30'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            // QRIS image: optional (may already have one stored); if provided, must be valid
            'qris_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
                $this->qrisValidationRule(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'qris_image.max' => 'Ukuran gambar QRIS maksimal 2MB.',
            'no_hp.regex' => 'Format nomor WhatsApp tidak valid.',
        ];
    }

    /**
     * Custom closure-based rule that runs our QrisValidator on the uploaded image.
     */
    private function qrisValidationRule(): ValidationRule
    {
        return new class implements ValidationRule
        {
            public function validate(string $attribute, mixed $value, \Closure $fail): void
            {
                if (! $value) {
                    return;
                }

                $result = app(QrisValidator::class)->validate($value);

                if ($result['status'] !== QrisValidator::RESULT_OK) {
                    $fail($result['message']);
                }
            }
        };
    }
}
