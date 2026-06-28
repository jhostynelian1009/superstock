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

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $productId = $this->route('producto')?->id ?? $this->route('producto');

        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'gt:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
            'price.required' => 'El precio es obligatorio.',
            'price.gt' => 'El precio debe ser mayor que cero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'La imagen debe ser JPEG, PNG o WEBP.',
            'image.max' => 'La imagen no puede superar 2MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
