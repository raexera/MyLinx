<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantOrderRequest extends FormRequest
{
    /**
     * This is a PUBLIC checkout form — no authentication required.
     * Any visitor to the tenant's storefront can place an order.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for the checkout form.
     *
     * Note: We intentionally do NOT validate 'harga' or 'total_harga'
     * from the form. The controller calculates pricing from the database
     * to prevent price manipulation.
     */
    public function rules(): array
    {
        return [
            'nama_pembeli' => ['required', 'string', 'max:100'],
            'email_pembeli' => ['required', 'email', 'max:150'],
            'no_hp_pembeli' => ['required', 'string', 'regex:/^[\+\d\s\-\(\)]+$/', 'max:30'],
            'alamat_pengiriman' => ['required', 'string', 'min:10', 'max:500'],
            'catatan_pembeli' => ['nullable', 'string', 'max:500'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'varian' => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_pembeli' => 'nama lengkap',
            'email_pembeli' => 'email',
            'jumlah' => 'jumlah pesanan',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'no_hp_pembeli.required' => 'Nomor WhatsApp wajib diisi untuk konfirmasi pesanan.',
            'no_hp_pembeli.regex' => 'Format nomor WhatsApp tidak valid.',
            'alamat_pengiriman.required' => 'Alamat pengiriman wajib diisi.',
            'alamat_pengiriman.min' => 'Alamat pengiriman terlalu pendek. Isi dengan detail lengkap.',
        ];
    }
}
