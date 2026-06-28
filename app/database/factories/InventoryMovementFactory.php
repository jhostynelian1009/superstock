<?php

namespace Database\Factories;

use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryMovement>
 */
class InventoryMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement([InventoryMovement::TYPE_INPUT, InventoryMovement::TYPE_OUTPUT]);

        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'supplier_id' => $type === InventoryMovement::TYPE_INPUT ? Supplier::factory() : null,
            'movement_type' => $type,
            'quantity' => fake()->randomFloat(3, 1, 100),
            'occurred_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'reason' => $type === InventoryMovement::TYPE_INPUT
                ? fake()->randomElement(['Compra a proveedor', 'Ingreso por devolución', 'Ajuste de inventario'])
                : fake()->randomElement(['Venta', 'Pérdida por merma', 'Consumo interno', 'Ajuste de inventario']),
            'reference' => fake()->bothify('REF-#####'),
            'created_at' => now(),
        ];
    }

    public function input(): static
    {
        return $this->state(fn () => [
            'movement_type' => InventoryMovement::TYPE_INPUT,
            'supplier_id' => Supplier::factory(),
            'reason' => fake()->randomElement(['Compra a proveedor', 'Ingreso por devolución', 'Ajuste de inventario']),
        ]);
    }

    public function output(): static
    {
        return $this->state(fn () => [
            'movement_type' => InventoryMovement::TYPE_OUTPUT,
            'supplier_id' => null,
            'reason' => fake()->randomElement(['Venta', 'Pérdida por merma', 'Consumo interno', 'Ajuste de inventario']),
        ]);
    }
}
