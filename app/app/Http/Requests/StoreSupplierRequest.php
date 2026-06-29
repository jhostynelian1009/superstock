<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'business_name'  => ['required', 'string', 'max:180'],
            'tax_identifier' => ['nullable', 'string', 'max:30', Rule::unique('suppliers', 'tax_identifier')],
            'contact_name'   => ['nullable', 'string', 'max:150'],
            'phone'          => ['nullable', 'string', 'max:30'],
            'email'          => ['nullable', 'email', 'max:255'],
            'is_active'      => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'business_name.required' => 'La razón social es obligatoria.',
            'business_name.max'      => 'La razón social no puede superar 180 caracteres.',
            'tax_identifier.unique'  => 'El RUC/identificador tributario ya está registrado.',
            'email.email'            => 'El correo electrónico no tiene un formato válido.',
        ];
    }
}
