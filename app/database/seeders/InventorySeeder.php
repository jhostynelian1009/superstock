<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            'SKU-LACT-001' => [
                'current_stock' => 120.000,
                'minimum_stock' => 20.000,
            ],
            'SKU-BEBI-001' => [
                'current_stock' => 80.000,
                'minimum_stock' => 15.000,
            ],
            'SKU-LIMP-001' => [
                'current_stock' => 50.000,
                'minimum_stock' => 10.000,
            ],
            'SKU-CARN-001' => [
                'current_stock' => 45.500,
                'minimum_stock' => 10.000,
            ],
            'SKU-FRUT-001' => [
                'current_stock' => 12.300,
                'minimum_stock' => 15.000,
            ],
            'SKU-VERD-001' => [
                'current_stock' => 0.000,
                'minimum_stock' => 10.000,
            ],
        ];

        foreach ($products as $sku => $stockData) {
            $product = Product::query()->where('sku', $sku)->first();

            if ($product === null) {
                continue;
            }

            Inventory::query()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'current_stock' => $stockData['current_stock'],
                    'minimum_stock' => $stockData['minimum_stock'],
                ]
            );
        }
    }
}
