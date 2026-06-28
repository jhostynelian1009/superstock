<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()->pluck('id', 'slug');

        $products = [
            [
                'name' => 'Muffin de Chocolate',
                'slug' => 'muffin-de-chocolate',
                'category' => 'dulces',
                'description' => 'Delicioso muffin de chocolate belga con chips extra. Horneado diariamente con ingredientes premium.',
                'price' => 3.50,
                'stock' => 24,
                'is_active' => true,
                'image' => 'muffin-de-chocolate.jpg',
            ],
            [
                'name' => 'Galletas de Avena',
                'slug' => 'galletas-de-avena',
                'category' => 'dulces',
                'description' => 'Crujientes galletas de avena con pasas y un toque de canela. Perfectas para acompañar tu café.',
                'price' => 2.75,
                'stock' => 30,
                'is_active' => true,
                'image' => 'galletas-de-avena.jpg',
            ],
            [
                'name' => 'Brownie Artesanal',
                'slug' => 'brownie-artesanal',
                'category' => 'dulces',
                'description' => 'Brownie denso y húmedo con nueces caramelizadas. Una experiencia de sabor intenso.',
                'price' => 4.00,
                'stock' => 18,
                'is_active' => true,
                'image' => 'brownie-artesanal.jpg',
            ],
            [
                'name' => 'Dona Glaseada',
                'slug' => 'dona-glaseada',
                'category' => 'dulces',
                'description' => 'Dona esponjosa con glaseado de vainilla y chispas de colores. Un clásico irresistible.',
                'price' => 2.50,
                'stock' => 20,
                'is_active' => true,
                'image' => 'dona-glaseada.jpg',
            ],
            [
                'name' => 'Chips de Plátano',
                'slug' => 'chips-de-platano',
                'category' => 'salados',
                'description' => 'Chips crujientes de plátano verde con sal marina. Snack ligero y adictivo.',
                'price' => 2.00,
                'stock' => 35,
                'is_active' => true,
                'image' => 'chips-de-platano.jpg',
            ],
            [
                'name' => 'Empanada de Queso',
                'slug' => 'empanada-de-queso',
                'category' => 'salados',
                'description' => 'Empanada horneada rellena de queso mozzarella fundido. Crujiente por fuera, suave por dentro.',
                'price' => 3.00,
                'stock' => 28,
                'is_active' => true,
                'image' => 'empanada-de-queso.jpg',
            ],
            [
                'name' => 'Nachos con Guacamole',
                'slug' => 'nachos-con-guacamole',
                'category' => 'salados',
                'description' => 'Nachos de maíz crujientes acompañados de guacamole fresco casero y pico de gallo.',
                'price' => 5.50,
                'stock' => 15,
                'is_active' => true,
                'image' => 'nachos-con-guacamole.jpg',
            ],
            [
                'name' => 'Palomitas Gourmet',
                'slug' => 'palomitas-gourmet',
                'category' => 'salados',
                'description' => 'Palomitas artesanales con mantequilla de trufa y sal del Himalaya.',
                'price' => 3.25,
                'stock' => 40,
                'is_active' => true,
                'image' => 'palomitas-gourmet.jpg',
            ],
            [
                'name' => 'Smoothie de Fresa',
                'slug' => 'smoothie-de-fresa',
                'category' => 'bebidas',
                'description' => 'Smoothie cremoso de fresas frescas con yogurt natural y un toque de miel.',
                'price' => 4.50,
                'stock' => 22,
                'is_active' => true,
                'image' => 'smoothie-de-fresa.jpg',
            ],
            [
                'name' => 'Café Latte',
                'slug' => 'cafe-latte',
                'category' => 'bebidas',
                'description' => 'Café espresso con leche vaporizada y arte latte. Preparado con granos de origen.',
                'price' => 3.75,
                'stock' => 50,
                'is_active' => true,
                'image' => 'cafe-latte.jpg',
            ],
            [
                'name' => 'Limonada Natural',
                'slug' => 'limonada-natural',
                'category' => 'bebidas',
                'description' => 'Limonada refrescante con hierbabuena fresca y el punto justo de dulzor.',
                'price' => 2.50,
                'stock' => 32,
                'is_active' => true,
                'image' => 'limonada-natural.jpg',
            ],
            [
                'name' => 'Té Helado de Durazno',
                'slug' => 'te-helado-de-durazno',
                'category' => 'bebidas',
                'description' => 'Té negro helado infusionado con duraznos maduros. Refrescante y aromático.',
                'price' => 3.00,
                'stock' => 26,
                'is_active' => true,
                'image' => 'te-helado-de-durazno.jpg',
            ],
            [
                'name' => 'Bowl de Açaí',
                'slug' => 'bowl-de-acai',
                'category' => 'saludables',
                'description' => 'Bowl de açaí con granola casera, banana fresca, frutos rojos y miel de abeja.',
                'price' => 6.50,
                'stock' => 12,
                'is_active' => true,
                'image' => 'bowl-de-acai.jpg',
            ],
            [
                'name' => 'Mix de Frutos Secos',
                'slug' => 'mix-de-frutos-secos',
                'category' => 'saludables',
                'description' => 'Mezcla premium de almendras, nueces, arándanos deshidratados y semillas de calabaza.',
                'price' => 4.25,
                'stock' => 25,
                'is_active' => true,
                'image' => 'mix-de-frutos-secos.jpg',
            ],
            [
                'name' => 'Barrita Energética',
                'slug' => 'barrita-energetica',
                'category' => 'saludables',
                'description' => 'Barrita de avena y miel con chispas de chocolate oscuro. Energía natural para tu día.',
                'price' => 2.75,
                'stock' => 38,
                'is_active' => true,
                'image' => 'barrita-energetica.jpg',
            ],
            [
                'name' => 'Yogurt con Granola',
                'slug' => 'yogurt-con-granola',
                'category' => 'saludables',
                'description' => 'Yogurt griego natural con granola artesanal y frutas de temporada.',
                'price' => 3.50,
                'stock' => 0,
                'is_active' => false,
                'image' => 'yogurt-con-granola.jpg',
            ],
        ];

        Storage::disk('public')->makeDirectory('products');

        $catalogSlugs = collect($products)->pluck('slug')->all();
        Product::query()->whereNotIn('slug', $catalogSlugs)->delete();

        foreach ($products as $product) {
            $categoryId = $categories[$product['category']] ?? null;

            if ($categoryId === null) {
                continue;
            }

            $imagePath = $this->publishProductImage($product['image']);

            Product::query()->updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'category_id' => $categoryId,
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'is_active' => $product['is_active'],
                    'image' => $imagePath,
                ]
            );
        }
    }

    private function publishProductImage(string $filename): ?string
    {
        $source = database_path('seeders/assets/products/'.$filename);
        $destination = 'products/'.$filename;

        if (! File::exists($source)) {
            return null;
        }

        Storage::disk('public')->put($destination, File::get($source));

        return $destination;
    }
}
