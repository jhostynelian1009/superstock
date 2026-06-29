<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryMovementModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_admin_can_view_inventory_movements_index(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        InventoryMovement::factory()->create([
            'product_id' => $product->id,
            'user_id' => $admin->id,
            'movement_type' => InventoryMovement::TYPE_INPUT,
            'quantity' => 10,
            'reason' => 'Compra inicial',
            'reference' => 'REF-001',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.movimientos.index'));

        $response->assertOk();
        $response->assertSeeText('Movimientos');
        $response->assertSeeText('Compra inicial');
        $response->assertSeeText('REF-001');
    }

    public function test_admin_can_view_inventory_movement_detail(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $movement = InventoryMovement::factory()->create([
            'product_id' => $product->id,
            'user_id' => $admin->id,
            'movement_type' => InventoryMovement::TYPE_OUTPUT,
            'quantity' => 3,
            'reason' => 'Venta',
            'reference' => 'REF-002',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.movimientos.show', $movement));

        $response->assertOk();
        $response->assertSeeText('Detalle del movimiento');
        $response->assertSeeText('REF-002');
    }
}
