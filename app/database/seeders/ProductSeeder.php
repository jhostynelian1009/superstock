<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $lacteos = Category::query()->where('name', 'Lácteos')->first();
        $bebidas = Category::query()->where('name', 'Bebidas')->first();
        $limpieza = Category::query()->where('name', 'Limpieza')->first();
        $carnes = Category::query()->where('name', 'Carnes')->first();
        $frutas = Category::query()->where('name', 'Frutas')->first();
        $verduras = Category::query()->where('name', 'Verduras')->first();
        $dulces = Category::query()->where('name', 'Dulces')->first();

        $products = [
            [
                'category_id' => $lacteos?->id,
                'sku' => 'SKU-LACT-001',
                'barcode' => '7861000100018',
                'name' => 'Leche Entera 1L',
                'description' => 'Leche entera pasteurizada, presentación en tetrapak de 1 Litro.',
                'unit_of_measure' => 'Litro',
                'is_active' => true,
            ],
            [
                'category_id' => $bebidas?->id,
                'sku' => 'SKU-BEBI-001',
                'barcode' => '7861000100025',
                'name' => 'Coca-Cola 2L',
                'description' => 'Refresco de cola sabor original, presentación retornable de 2 Litros.',
                'unit_of_measure' => 'Unidad',
                'is_active' => true,
            ],
            [
                'category_id' => $limpieza?->id,
                'sku' => 'SKU-LIMP-001',
                'barcode' => '7861000100032',
                'name' => 'Cloro Multiuso 1L',
                'description' => 'Desinfectante y blanqueador para superficies de cocina y baño.',
                'unit_of_measure' => 'Litro',
                'is_active' => true,
            ],
            [
                'category_id' => $carnes?->id,
                'sku' => 'SKU-CARN-001',
                'barcode' => '7861000100049',
                'name' => 'Lomo de Res',
                'description' => 'Corte premium de lomo fino de res por kilogramo.',
                'unit_of_measure' => 'Kilogramo',
                'is_active' => true,
            ],
            [
                'category_id' => $frutas?->id,
                'sku' => 'SKU-FRUT-001',
                'barcode' => '7861000100056',
                'name' => 'Manzanas Rojas',
                'description' => 'Manzana roja tipo Gala, fresca e importada.',
                'unit_of_measure' => 'Kilogramo',
                'is_active' => true,
            ],
            [
                'category_id' => $verduras?->id,
                'sku' => 'SKU-VERD-001',
                'barcode' => '7861000100063',
                'name' => 'Zanahorias',
                'description' => 'Zanahoria fresca de cultivo local, seleccionada por kilogramo.',
                'unit_of_measure' => 'Kilogramo',
                'is_active' => true,
            ],
            [
                'category_id' => $dulces?->id,
                'sku' => 'SKU-DULC-001',
                'barcode' => '7861000100070',
                'name' => 'Muffin de Chocolate',
                'slug' => 'muffin-de-chocolate',
                'description' => 'Muffin de chocolate disponible para pedidos.',
                'unit_of_measure' => 'Unidad',
                'price' => 3.50,
                'image' => 'products/muffin-de-chocolate.jpg',
                'is_active' => true,
            ],
            [
                'category_id' => $bebidas?->id,
                'sku' => 'SKU-BEBI-002',
                'barcode' => '7861000100087',
                'name' => 'Té Helado de Durazno',
                'slug' => 'te-helado-de-durazno',
                'description' => 'Té negro helado con sabor a durazno.',
                'unit_of_measure' => 'Unidad',
                'price' => 3.00,
                'image' => 'products/te-helado-de-durazno.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            if ($product['category_id'] === null) {
                continue;
            }

            Product::query()->updateOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }
    }
}
