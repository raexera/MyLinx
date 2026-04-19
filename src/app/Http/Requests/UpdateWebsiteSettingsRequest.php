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
                'required', 'string', 'min:3', 'max:100',
                'alpha_dash', 'lowercase',
                Rule::unique('tenants', 'slug')->ignore($tenantId),
                Rule::notIn([
                    'login', 'register', 'dashboard', 'admin', 'api', 'produk',
                    'order', 'payment', 'settings', 'profile', 'profil-usaha',
                    'portfolio', 'checkout', 'logout', 'landing',
                ]),
            ],
            'accent_color' => [
                'required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
            'content_order' => [
                'required', 'string',
                Rule::in(['products_first', 'portfolio_first', 'products_only', 'portfolio_only']),
            ],
            'product_layout' => [
                'required', 'string',
                Rule::in(['grid', 'list']),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_tenant' => 'nama toko',
            'slug' => 'URL toko',
            'accent_color' => 'warna aksen',
            'content_order' => 'urutan konten',
            'product_layout' => 'tata letak produk',
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique' => 'URL ini sudah digunakan oleh toko lain.',
            'slug.alpha_dash' => 'URL hanya boleh huruf, angka, strip, dan garis bawah.',
            'slug.lowercase' => 'URL harus huruf kecil.',
            'slug.min' => 'URL minimal 3 karakter.',
            'slug.not_in' => 'URL ini digunakan oleh sistem. Pilih yang lain.',
            'accent_color.regex' => 'Warna aksen harus format hex (contoh: #2E5136).',
            'content_order.in' => 'Urutan konten tidak valid.',
            'product_layout.in' => 'Tata letak produk tidak valid.',
        ];
    }
}
