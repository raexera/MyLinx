<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdukRequest extends FormRequest
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
            'stok' => ['required', 'integer', 'min:0', 'max:999999'],
            'gambar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
                'dimensions:max_width=4000,max_height=4000',
            ],
            'status' => ['nullable', 'boolean'],
            'varian_label' => ['nullable', 'string', 'max:50', 'required_with:varian_opsi'],
            'varian_opsi' => ['nullable', 'string', 'max:500', 'required_with:varian_label'],
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
            'varian_label.max' => 'Nama varian maksimal 50 karakter.',
            'varian_label.required_with' => 'Nama varian wajib diisi jika opsi varian diisi.',
            'varian_opsi.max' => 'Opsi varian maksimal 500 karakter.',
            'varian_opsi.required_with' => 'Opsi varian wajib diisi jika nama varian diisi.',
        ];
    }
}
