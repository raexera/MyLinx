<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePortofolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->tenant_id !== null;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:5000'],
            'gambar' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
                'dimensions:max_width=4000,max_height=4000',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'judul' => 'judul portofolio',
            'deskripsi' => 'deskripsi',
            'gambar' => 'gambar cover',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul portofolio wajib diisi.',
            'judul.max' => 'Judul portofolio maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 5000 karakter.',
            'gambar.required' => 'Gambar cover wajib diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 5MB.',
            'gambar.dimensions' => 'Dimensi gambar maksimal 4000x4000 pixel.',
        ];
    }
}
