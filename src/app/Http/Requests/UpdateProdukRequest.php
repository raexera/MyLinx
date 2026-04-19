<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->tenant_id !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     */
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

    /**
     * Get custom attribute names for validator errors.
     */
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

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'gambar.max' => 'Ukuran foto produk maksimal 5MB.',
            'gambar.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
        ];
    }
}
