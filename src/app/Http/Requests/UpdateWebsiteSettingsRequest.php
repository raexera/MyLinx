<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWebsiteSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->tenant_id !== null;
    }

    public function rules(): array
    {
        $tenantId = auth()->user()->tenant_id;

        return [
            'nama_tenant' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:100',
                'alpha_dash',   // Only allows letters, numbers, dashes, underscores
                'lowercase',
                Rule::unique('tenants', 'slug')->ignore($tenantId),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_tenant' => 'nama toko',
            'slug'        => 'URL toko',
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique'     => 'URL ini sudah digunakan oleh toko lain. Silakan pilih yang berbeda.',
            'slug.alpha_dash' => 'URL toko hanya boleh berisi huruf, angka, strip (-), dan garis bawah (_).',
            'slug.lowercase'  => 'URL toko harus menggunakan huruf kecil.',
        ];
    }
}
