<?php

namespace Database\Seeders;

use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class InventoryMovementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@superstock.com')->first();
        $empleado = User::query()->where('email', 'empleado1@superstock.com')->first();

        $condor = Supplier::query()->where('business_name', 'Distribuidora El Cóndor')->first();
        $alimentos = Supplier::query()->where('business_name', 'Alimentos Ecuador')->first();
        $superProv = Supplier::query()->where('business_name', 'Super Proveedores')->first();

        $productsData = [
            'SKU-LACT-001' => [
                'product' => Product::query()->where('sku', 'SKU-LACT-001')->first(),
                'movements' => [
                    [
                        'user_id' => $admin?->id,
                        'supplier_id' => $condor?->id,
                        'movement_type' => InventoryMovement::TYPE_INPUT,
                        'quantity' => 150.000,
                        'occurred_at' => now()->subDays(10),
                        'reason' => 'Compra a proveedor',
                        'reference' => 'FAC-00123',
                    ],
                    [
                        'user_id' => $empleado?->id,
                        'supplier_id' => null,
                        'movement_type' => InventoryMovement::TYPE_OUTPUT,
                        'quantity' => 30.000,
                        'occurred_at' => now()->subDays(2),
                        'reason' => 'Venta a consumidor final',
                        'reference' => 'NV-00892',
                    ],
                ]
            ],
            'SKU-BEBI-001' => [
                'product' => Product::query()->where('sku', 'SKU-BEBI-001')->first(),
                'movements' => [
                    [
                        'user_id' => $admin?->id,
                        'supplier_id' => $superProv?->id,
                        'movement_type' => InventoryMovement::TYPE_INPUT,
                        'quantity' => 100.000,
                        'occurred_at' => now()->subDays(8),
                        'reason' => 'Compra a proveedor',
                        'reference' => 'FAC-00981',
                    ],
                    [
                        'user_id' => $empleado?->id,
                        'supplier_id' => null,
                        'movement_type' => InventoryMovement::TYPE_OUTPUT,
                        'quantity' => 20.000,
                        'occurred_at' => now()->subDays(1),
                        'reason' => 'Venta a consumidor final',
                        'reference' => 'NV-00910',
                    ],
                ]
            ],
            'SKU-LIMP-001' => [
                'product' => Product::query()->where('sku', 'SKU-LIMP-001')->first(),
                'movements' => [
                    [
                        'user_id' => $empleado?->id,
                        'supplier_id' => $condor?->id,
                        'movement_type' => InventoryMovement::TYPE_INPUT,
                        'quantity' => 50.000,
                        'occurred_at' => now()->subDays(5),
                        'reason' => 'Compra a proveedor',
                        'reference' => 'FAC-00135',
                    ],
                ]
            ],
            'SKU-CARN-001' => [
                'product' => Product::query()->where('sku', 'SKU-CARN-001')->first(),
                'movements' => [
                    [
                        'user_id' => $admin?->id,
                        'supplier_id' => $alimentos?->id,
                        'movement_type' => InventoryMovement::TYPE_INPUT,
                        'quantity' => 50.000,
                        'occurred_at' => now()->subDays(4),
                        'reason' => 'Compra a proveedor',
                        'reference' => 'FAC-05541',
                    ],
                    [
                        'user_id' => $empleado?->id,
                        'supplier_id' => null,
                        'movement_type' => InventoryMovement::TYPE_OUTPUT,
                        'quantity' => 4.500,
                        'occurred_at' => now()->subDays(1),
                        'reason' => 'Venta a consumidor final',
                        'reference' => 'NV-00915',
                    ],
                ]
            ],
            'SKU-FRUT-001' => [
                'product' => Product::query()->where('sku', 'SKU-FRUT-001')->first(),
                'movements' => [
                    [
                        'user_id' => $empleado?->id,
                        'supplier_id' => $alimentos?->id,
                        'movement_type' => InventoryMovement::TYPE_INPUT,
                        'quantity' => 30.000,
                        'occurred_at' => now()->subDays(6),
                        'reason' => 'Compra a proveedor',
                        'reference' => 'FAC-05530',
                    ],
                    [
                        'user_id' => $empleado?->id,
                        'supplier_id' => null,
                        'movement_type' => InventoryMovement::TYPE_OUTPUT,
                        'quantity' => 17.700,
                        'occurred_at' => now()->subDays(2),
                        'reason' => 'Venta a consumidor final',
                        'reference' => 'NV-00899',
                    ],
                ]
            ],
            'SKU-VERD-001' => [
                'product' => Product::query()->where('sku', 'SKU-VERD-001')->first(),
                'movements' => [
                    [
                        'user_id' => $admin?->id,
                        'supplier_id' => $alimentos?->id,
                        'movement_type' => InventoryMovement::TYPE_INPUT,
                        'quantity' => 20.000,
                        'occurred_at' => now()->subDays(12),
                        'reason' => 'Compra a proveedor',
                        'reference' => 'FAC-05512',
                    ],
                    [
                        'user_id' => $empleado?->id,
                        'supplier_id' => null,
                        'movement_type' => InventoryMovement::TYPE_OUTPUT,
                        'quantity' => 20.000,
                        'occurred_at' => now()->subDays(3),
                        'reason' => 'Pérdida por merma',
                        'reference' => 'MEMO-0012',
                    ],
                ]
            ],
        ];

        foreach ($productsData as $sku => $data) {
            $product = $data['product'];
            if ($product === null) {
                continue;
            }

            foreach ($data['movements'] as $movement) {
                if ($movement['user_id'] === null) {
                    continue;
                }

                InventoryMovement::query()->create([
                    'product_id' => $product->id,
                    'user_id' => $movement['user_id'],
                    'supplier_id' => $movement['supplier_id'],
                    'movement_type' => $movement['movement_type'],
                    'quantity' => $movement['quantity'],
                    'occurred_at' => $movement['occurred_at'],
                    'reason' => $movement['reason'],
                    'reference' => $movement['reference'],
                ]);
            }
        }
    }
}
