<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
{
    public function authorize(): bool
    {

        return auth()->check() && auth()->user()->tenant_id !== null;
    }

    public function rules(): array
    {
        return [
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'harga' => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'stok' => ['required', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'status' => ['sometimes', 'boolean'],
            'varian_label' => ['nullable', 'string', 'max:50'],
            'varian_opsi' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_produk' => 'nama produk',
            'deskripsi' => 'deskripsi',
            'harga' => 'harga',
            'stok' => 'stok',
            'gambar' => 'foto produk',
        ];
    }

    public function messages(): array
    {
        return [
            'gambar.max' => 'Ukuran foto produk maksimal 5MB.',
            'gambar.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
        ];
    }
}
