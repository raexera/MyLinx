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
        return [
            'nama_tenant' => ['required', 'string', 'max:100'],
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                'lowercase',
                'min:3',
                'max:50',
                Rule::unique('tenants', 'slug')->ignore(auth()->user()->tenant_id),
                Rule::notIn(['admin', 'api', 'login', 'logout', 'register', 'dashboard',
                    'profile', 'settings', 'order', 'produk', 'portfolio',
                    'profil-usaha', 'invoice', 'checkout', 'payment']),
            ],

            'accent_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'background_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'content_order' => ['required', Rule::in(['products_first', 'portfolio_first', 'products_only', 'portfolio_only'])],
            'product_layout' => ['required', Rule::in(['grid', 'list'])],
            'hero_style' => ['required', Rule::in(['banner', 'minimal'])],
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
            'nama_tenant.required'   => 'Nama toko wajib diisi.',
            'nama_tenant.max'        => 'Nama toko maksimal 100 karakter.',
            'slug.required'          => 'URL toko wajib diisi.',
            'slug.max'               => 'URL toko maksimal 50 karakter.',
            'background_color.regex' => 'Warna background harus format hex (contoh: #FFFFFF).',
            'hero_style.in'          => 'Gaya hero tidak valid.',
        ];
    }
}
