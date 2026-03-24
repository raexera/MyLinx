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
            'nama_pembeli'  => ['required', 'string', 'max:255'],
            'email_pembeli' => ['required', 'email', 'max:255'],
            'jumlah'        => ['required', 'integer', 'min:1', 'max:999'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_pembeli'  => 'nama lengkap',
            'email_pembeli' => 'email',
            'jumlah'        => 'jumlah pesanan',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'nama_pembeli.required'  => 'Mohon isi nama lengkap Anda.',
            'email_pembeli.required' => 'Mohon isi alamat email Anda.',
            'email_pembeli.email'    => 'Format email tidak valid.',
            'jumlah.required'        => 'Mohon tentukan jumlah pesanan.',
            'jumlah.min'             => 'Jumlah pesanan minimal 1.',
        ];
    }
}
