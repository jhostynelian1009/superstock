<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->admin = User::factory()->admin()->create();
        $this->category = Category::query()->create([
            'name' => 'Bebidas',
            'description' => 'Todo tipo de bebidas',
        ]);
    }

    public function test_admin_can_view_product_list(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Coca Cola 1L',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.productos.index'));

        $response->assertStatus(200);
        $response->assertSee($product->sku);
        $response->assertSee('Coca Cola 1L');
    }

    public function test_admin_can_search_products_by_name_or_sku_or_barcode(): void
    {
        Product::factory()->create([
            'category_id' => $this->category->id,
            'sku' => 'SKU-COCA1L',
            'barcode' => '7891234567890',
            'name' => 'Coca Cola 1L',
        ]);

        Product::factory()->create([
            'category_id' => $this->category->id,
            'sku' => 'SKU-PEPSI1L',
            'barcode' => '7891234567891',
            'name' => 'Pepsi Cola 1L',
        ]);

        // Search by name
        $response = $this->actingAs($this->admin)
            ->get(route('admin.productos.index', ['search' => 'Pepsi']));
        $response->assertStatus(200);
        $response->assertSee('Pepsi Cola 1L');
        $response->assertDontSee('Coca Cola 1L');

        // Search by SKU
        $response = $this->actingAs($this->admin)
            ->get(route('admin.productos.index', ['search' => 'COCA1L']));
        $response->assertStatus(200);
        $response->assertSee('Coca Cola 1L');
        $response->assertDontSee('Pepsi Cola 1L');

        // Search by Barcode
        $response = $this->actingAs($this->admin)
            ->get(route('admin.productos.index', ['search' => '7891234567891']));
        $response->assertStatus(200);
        $response->assertSee('Pepsi Cola 1L');
        $response->assertDontSee('Coca Cola 1L');
    }

    public function test_admin_can_create_product_with_valid_data(): void
    {
        $productData = [
            'sku' => 'SKU-NEW123',
            'barcode' => '1234567890123',
            'name' => 'Nuevo Producto de Prueba',
            'category_id' => $this->category->id,
            'unit_of_measure' => 'Unidad',
            'description' => 'Una descripción de prueba.',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.productos.store'), $productData);

        $response->assertRedirect(route('admin.productos.index'));
        $this->assertDatabaseHas('products', [
            'sku' => 'SKU-NEW123',
            'name' => 'Nuevo Producto de Prueba',
        ]);
    }

    public function test_create_product_validation_fails_for_duplicate_sku_or_barcode(): void
    {
        Product::factory()->create([
            'category_id' => $this->category->id,
            'sku' => 'SKU-DUP',
            'barcode' => '1111111111111',
        ]);

        // Duplicate SKU
        $response = $this->actingAs($this->admin)
            ->post(route('admin.productos.store'), [
                'sku' => 'SKU-DUP',
                'name' => 'Otro Nombre',
                'category_id' => $this->category->id,
                'unit_of_measure' => 'Unidad',
            ]);

        $response->assertSessionHasErrors(['sku']);

        // Duplicate Barcode
        $response = $this->actingAs($this->admin)
            ->post(route('admin.productos.store'), [
                'sku' => 'SKU-NEW',
                'barcode' => '1111111111111',
                'name' => 'Otro Nombre',
                'category_id' => $this->category->id,
                'unit_of_measure' => 'Unidad',
            ]);

        $response->assertSessionHasErrors(['barcode']);
    }

    public function test_admin_can_edit_product_with_valid_data(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'sku' => 'SKU-ORIGINAL',
            'name' => 'Nombre Original',
        ]);

        $updateData = [
            'sku' => 'SKU-UPDATED',
            'name' => 'Nombre Actualizado',
            'category_id' => $this->category->id,
            'unit_of_measure' => 'Kilogramo',
            'description' => 'Nueva descripción.',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.productos.update', $product), $updateData);

        $response->assertRedirect(route('admin.productos.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'sku' => 'SKU-UPDATED',
            'name' => 'Nombre Actualizado',
            'unit_of_measure' => 'Kilogramo',
            'is_active' => false,
        ]);
    }

    public function test_admin_can_delete_product_without_inventory_or_movements(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.productos.destroy', $product));

        $response->assertRedirect(route('admin.productos.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_cannot_delete_product_with_associated_inventory(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);

        // Create associated inventory
        Inventory::query()->create([
            'product_id' => $product->id,
            'current_stock' => 10,
            'minimum_stock' => 2,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.productos.destroy', $product));

        $response->assertRedirect(route('admin.productos.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_admin_cannot_delete_product_with_associated_movements(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);

        // Create associated inventory movement
        InventoryMovement::query()->create([
            'product_id' => $product->id,
            'user_id' => $this->admin->id,
            'movement_type' => InventoryMovement::TYPE_INPUT,
            'quantity' => 5,
            'occurred_at' => now(),
            'reason' => 'Prueba',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.productos.destroy', $product));

        $response->assertRedirect(route('admin.productos.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }
}
