<?php

namespace App\Http\Requests;

use App\Models\InventoryMovement;
use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryMovementRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
            'movement_type' => ['required', 'in:'.InventoryMovement::TYPE_INPUT.','.InventoryMovement::TYPE_OUTPUT],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'reason' => ['required', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'El producto es obligatorio.',
            'product_id.exists' => 'El producto seleccionado no es válido.',
            'movement_type.required' => 'El tipo de movimiento es obligatorio.',
            'movement_type.in' => 'El tipo de movimiento no es válido.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.numeric' => 'La cantidad debe ser un número.',
            'quantity.gt' => 'La cantidad debe ser mayor que cero.',
            'supplier_id.exists' => 'El proveedor seleccionado no es válido.',
            'reason.required' => 'El motivo es obligatorio.',
            'reason.max' => 'El motivo no puede superar 255 caracteres.',
            'reference.max' => 'La referencia no puede superar 100 caracteres.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'occurred_at' => now(),
            'user_id' => auth()->id(),
        ]);
    }
}
