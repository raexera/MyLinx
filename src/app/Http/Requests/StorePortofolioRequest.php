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
            'judul'     => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:5000'],
            'gambar'    => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function attributes(): array
    {
        return [
            'judul'     => 'judul portofolio',
            'deskripsi' => 'deskripsi',
            'gambar'    => 'gambar cover',
        ];
    }

    public function messages(): array
    {
        return [
            'gambar.required' => 'Gambar cover wajib diunggah.',
            'gambar.max'      => 'Ukuran gambar maksimal 5MB.',
            'gambar.mimes'    => 'Format gambar harus JPG, JPEG, atau PNG.',
        ];
    }
}
