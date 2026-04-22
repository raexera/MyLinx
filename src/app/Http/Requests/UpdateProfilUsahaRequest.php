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
            'no_hp' => ['required', 'string', 'regex:/^\+62\d{8,13}$/', 'max:16'],
            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
                'dimensions:max_width=2000,max_height=2000',
            ],
            'qris_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
                'dimensions:max_width=2000,max_height=2000',
                $this->qrisValidationRule(),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_usaha' => 'nama usaha',
            'deskripsi' => 'deskripsi',
            'alamat' => 'alamat',
            'no_hp' => 'nomor WhatsApp',
            'logo' => 'logo usaha',
            'qris_image' => 'gambar QRIS',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_usaha.required' => 'Nama usaha wajib diisi.',
            'nama_usaha.max' => 'Nama usaha maksimal 150 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 2000 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'no_hp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_hp.regex' => 'Nomor WhatsApp tidak valid. Masukkan tanpa angka 0 atau +62 di depan.',
            'no_hp.max' => 'Nomor WhatsApp maksimal 16 karakter.',
            'logo.image' => 'Logo harus berupa file gambar.',
            'logo.mimes' => 'Format logo harus JPG, JPEG, atau PNG.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'logo.dimensions' => 'Dimensi logo maksimal 2000x2000 pixel.',
            'qris_image.image' => 'QRIS harus berupa file gambar.',
            'qris_image.mimes' => 'Format QRIS harus JPG, JPEG, atau PNG.',
            'qris_image.max' => 'Ukuran gambar QRIS maksimal 2MB.',
            'qris_image.dimensions' => 'Dimensi QRIS maksimal 2000x2000 pixel.',
        ];
    }

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
