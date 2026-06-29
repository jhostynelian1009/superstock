<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('producto')?->id ?? $this->route('producto');

        return [
            'sku' => ['required', 'string', 'max:60', Rule::unique('products', 'sku')->ignore($productId)],
            'barcode' => ['nullable', 'string', 'max:50', Rule::unique('products', 'barcode')->ignore($productId)],
            'name' => ['required', 'string', 'max:180'],
            'category_id' => ['required', 'exists:categories,id'],
            'unit_of_measure' => ['required', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'sku.required' => 'El SKU es obligatorio.',
            'sku.unique' => 'El SKU ya está en uso.',
            'sku.max' => 'El SKU no puede superar los 60 caracteres.',
            'barcode.unique' => 'El código de barras ya está en uso.',
            'barcode.max' => 'El código de barras no puede superar los 50 caracteres.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede superar los 180 caracteres.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
            'unit_of_measure.required' => 'La unidad de medida es obligatoria.',
            'unit_of_measure.max' => 'La unidad de medida no puede superar los 30 caracteres.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
