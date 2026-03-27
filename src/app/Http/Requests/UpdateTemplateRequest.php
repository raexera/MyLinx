<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->tenant_id !== null;
    }

    public function rules(): array
    {
        return [
            'template_id' => ['required', 'uuid', 'exists:templates,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'template_id' => 'template',
        ];
    }

    public function messages(): array
    {
        return [
            'template_id.exists' => 'Template yang dipilih tidak ditemukan.',
        ];
    }
}
