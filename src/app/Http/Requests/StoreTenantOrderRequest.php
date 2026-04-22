<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_pembeli' => ['required', 'string', 'max:100'],
            'email_pembeli' => ['required', 'email', 'max:150'],
            'no_hp_pembeli' => ['required', 'string', 'regex:/^\+62\d{8,13}$/', 'max:16'],
            'alamat_pengiriman' => ['required', 'string', 'min:10', 'max:500'],
            'catatan_pembeli' => ['nullable', 'string', 'max:500'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:9999'],
            'varian' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_pembeli' => 'nama lengkap',
            'email_pembeli' => 'email',
            'no_hp_pembeli' => 'nomor WhatsApp',
            'alamat_pengiriman' => 'alamat pengiriman',
            'catatan_pembeli' => 'catatan',
            'jumlah' => 'jumlah pesanan',
            'varian' => 'varian produk',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pembeli.required' => 'Nama lengkap wajib diisi.',
            'nama_pembeli.max' => 'Nama maksimal 100 karakter.',
            'email_pembeli.required' => 'Email wajib diisi untuk menerima invoice.',
            'email_pembeli.email' => 'Format email tidak valid.',
            'no_hp_pembeli.required' => 'Nomor WhatsApp wajib diisi untuk konfirmasi pesanan.',
            'no_hp_pembeli.regex' => 'Nomor WhatsApp tidak valid. Masukkan tanpa angka 0 atau +62 di depan.',
            'no_hp_pembeli.max' => 'Nomor WhatsApp maksimal 16 karakter.',
            'alamat_pengiriman.required' => 'Alamat pengiriman wajib diisi.',
            'alamat_pengiriman.min' => 'Alamat pengiriman terlalu pendek. Isi dengan detail lengkap.',
            'alamat_pengiriman.max' => 'Alamat pengiriman maksimal 500 karakter.',
            'catatan_pembeli.max' => 'Catatan maksimal 500 karakter.',
            'jumlah.required' => 'Jumlah pesanan wajib diisi.',
            'jumlah.integer' => 'Jumlah pesanan harus berupa angka.',
            'jumlah.min' => 'Jumlah pesanan minimal 1.',
            'jumlah.max' => 'Jumlah pesanan maksimal 9999 per order.',
            'varian.max' => 'Varian maksimal 100 karakter.',
        ];
    }
}
