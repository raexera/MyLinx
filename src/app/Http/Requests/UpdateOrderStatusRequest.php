<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->tenant_id !== null;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                Rule::in([
                    'pending',
                    'confirmed',
                    'processing',
                    'completed',
                    'cancelled',
                ]),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'status' => 'status order',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status order wajib dipilih.',
            'status.in'       => 'Status order tidak valid. Harus salah satu dari: pending, confirmed, processing, completed, atau cancelled.',
        ];
    }
}
