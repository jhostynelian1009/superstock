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
                'name' => 'Dulces',
                'slug' => 'dulces',
                'description' => 'Snacks y postres dulces para todos los gustos.',
            ],
            [
                'name' => 'Salados',
                'slug' => 'salados',
                'description' => 'Papas, nachos y botanas saladas.',
            ],
            [
                'name' => 'Bebidas',
                'slug' => 'bebidas',
                'description' => 'Refrescos, jugos y bebidas frías o calientes.',
            ],
            [
                'name' => 'Saludables',
                'slug' => 'saludables',
                'description' => 'Opciones más ligeras y nutritivas.',
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
