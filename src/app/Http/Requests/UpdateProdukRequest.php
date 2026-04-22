<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->tenant_id !== null;
    }

    protected function prepareForValidation()
    {
        if ($this->has('variants') && is_array($this->variants)) {
            $variants = collect($this->variants)->filter(function ($variant) {
                return ! empty($variant['label']) && ! empty($variant['options']);
            })->values()->toArray();

            $this->merge([
                'variants' => empty($variants) ? null : $variants,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'harga' => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'stok' => ['required', 'integer', 'min:0', 'max:999999'],
            'gambar' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120',
                'dimensions:max_width=4000,max_height=4000',
            ],
            'status' => ['nullable', 'boolean'],
            'variants' => ['nullable', 'array', 'max:3'],
            'variants.*.label' => ['required', 'string', 'max:50'],
            'variants.*.options' => ['required', 'string', 'max:500'],
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
            'variants' => 'grup varian',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 2000 karakter.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'harga.max' => 'Harga melebihi batas maksimal.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'stok.max' => 'Stok maksimal 999.999 unit.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran foto produk maksimal 5MB.',
            'gambar.dimensions' => 'Dimensi foto maksimal 4000x4000 pixel.',
            'variants.max' => 'Maksimal 3 grup varian.',
            'variants.*.label.required' => 'Nama grup varian wajib diisi.',
            'variants.*.options.required' => 'Opsi varian wajib diisi.',
        ];
    }
}
