<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Lácteos',
                'description' => 'Leche, quesos, yogures y derivados lácteos.',
            ],
            [
                'name' => 'Bebidas',
                'description' => 'Agua, refrescos, jugos y bebidas energéticas.',
            ],
            [
                'name' => 'Limpieza',
                'description' => 'Artículos de aseo hogar y desinfectantes.',
            ],
            [
                'name' => 'Carnes',
                'description' => 'Carnes rojas, pollo, cerdo y embutidos.',
            ],
            [
                'name' => 'Frutas',
                'description' => 'Frutas frescas locales e importadas.',
            ],
            [
                'name' => 'Verduras',
                'description' => 'Vegetales, hortalizas y legumbres frescas.',
            ],
            [
                'name' => 'Dulces',
                'description' => 'Productos dulces disponibles en el catálogo.',
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
