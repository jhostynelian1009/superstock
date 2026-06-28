<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ClientProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);
    }

    public function test_client_can_view_profile_edit_page(): void
    {
        $client = User::factory()->client()->create();

        $response = $this->actingAs($client)->get(route('client.perfil.edit'));

        $response->assertStatus(200);
        $response->assertSee('Editar perfil');
        $response->assertSee('Ubicación de entrega');
    }

    public function test_client_can_update_profile_and_delivery_address(): void
    {
        $client = User::factory()->client()->create([
            'email' => 'cliente@test.com',
        ]);

        $response = $this->actingAs($client)->put(route('client.perfil.update'), [
            'name' => 'Cliente Actualizado',
            'document_number' => $client->document_number,
            'phone' => '0999999999',
            'email' => 'cliente@test.com',
            'default_delivery_type' => 'llevar',
            'address_neighborhood' => 'La Floresta',
            'address_main_street' => 'Av. Principal',
            'address_secondary_street' => 'Calle Secundaria',
            'address_reference' => 'Casa azul',
        ]);

        $response->assertRedirect(route('client.perfil.edit'));
        $response->assertSessionHas('success');

        $client->refresh();
        $this->assertEquals('Cliente Actualizado', $client->name);
        $this->assertEquals('La Floresta', $client->address_neighborhood);
        $this->assertTrue($client->hasSavedDeliveryAddress());
    }

    public function test_cart_prefills_saved_delivery_address_for_client(): void
    {
        $client = User::factory()->client()->create([
            'default_delivery_type' => 'llevar',
            'address_neighborhood' => 'La Floresta',
            'address_main_street' => 'Av. Principal',
            'address_secondary_street' => 'Calle Secundaria',
            'address_reference' => 'Casa azul',
        ]);

        $product = Product::query()->where('is_active', true)->firstOrFail();
        Session::put('cart', [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ],
        ]);

        $response = $this->actingAs($client)->get(route('cart.show'));

        $response->assertStatus(200);
        $response->assertSee('La Floresta', false);
        $response->assertSee('Av. Principal', false);
        $response->assertSee('Editar en perfil', false);
    }
}
