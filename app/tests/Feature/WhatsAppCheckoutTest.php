<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class WhatsAppCheckoutTest extends TestCase
{
    use RefreshDatabase;

    private Product $muffin;

    private User $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $this->muffin = Product::query()->where('slug', 'muffin-de-chocolate')->firstOrFail();
        $this->client = User::factory()->client()->create();
    }

    public function test_cart_page_loads_successfully()
    {
        $response = $this->get(route('cart.show'));

        $response->assertStatus(200);
        $response->assertViewHas('products');
        $response->assertSee('Muffin de Chocolate');
    }

    public function test_add_item_to_cart_via_json()
    {
        $response = $this->from(route('catalogo.index'))
            ->withHeaders(['Accept' => 'application/json'])
            ->post(route('cart.add', $this->muffin->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'cart_count' => 1,
        ]);

        $cart = Session::get('cart');
        $this->assertArrayHasKey($this->muffin->id, $cart);
        $this->assertEquals(1, $cart[$this->muffin->id]['quantity']);
    }

    public function test_add_item_to_cart()
    {
        $response = $this->from(route('catalogo.index'))
            ->post(route('cart.add', $this->muffin->id));

        $response->assertRedirect(route('catalogo.index'));
        $response->assertSessionHas('cart');
        $response->assertSessionHas('cart_toast');
    }

    public function test_remove_or_decrease_item_in_cart()
    {
        $cart = [
            $this->muffin->id => [
                'id' => $this->muffin->id,
                'name' => 'Muffin de Chocolate',
                'price' => 3.50,
                'image' => 'products/muffin-de-chocolate.jpg',
                'quantity' => 2,
            ],
        ];
        Session::put('cart', $cart);

        $response = $this->post(route('cart.remove', $this->muffin->id));
        $response->assertRedirect(route('cart.show'));
        $updatedCart = Session::get('cart');
        $this->assertEquals(1, $updatedCart[$this->muffin->id]['quantity']);

        $response = $this->post(route('cart.remove', $this->muffin->id));
        $finalCart = Session::get('cart');
        $this->assertArrayNotHasKey($this->muffin->id, $finalCart);
    }

    public function test_clear_cart()
    {
        $tea = Product::query()->where('slug', 'te-helado-de-durazno')->firstOrFail();

        $cart = [
            $this->muffin->id => ['id' => $this->muffin->id, 'name' => 'Muffin de Chocolate', 'price' => 3.50, 'image' => 'products/muffin-de-chocolate.jpg', 'quantity' => 1],
            $tea->id => ['id' => $tea->id, 'name' => 'Té Helado de Durazno', 'price' => 3.00, 'image' => 'products/te-helado-de-durazno.jpg', 'quantity' => 3],
        ];
        Session::put('cart', $cart);

        $response = $this->post(route('cart.clear'));
        $response->assertRedirect(route('cart.show'));
        $this->assertNull(Session::get('cart'));
    }

    public function test_guest_checkout_requires_authentication()
    {
        $cart = [
            $this->muffin->id => ['id' => $this->muffin->id, 'name' => 'Muffin de Chocolate', 'price' => 3.50, 'image' => 'products/muffin-de-chocolate.jpg', 'quantity' => 1],
        ];
        Session::put('cart', $cart);

        $response = $this->post(route('checkout.whatsapp'), [
            'delivery_type' => 'local',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_checkout_validation_requires_delivery_type()
    {
        $cart = [
            $this->muffin->id => ['id' => $this->muffin->id, 'name' => 'Muffin de Chocolate', 'price' => 3.50, 'image' => 'products/muffin-de-chocolate.jpg', 'quantity' => 1],
        ];
        Session::put('cart', $cart);

        $response = $this->actingAs($this->client)->post(route('checkout.whatsapp'), [
            'delivery_type' => '',
        ]);

        $response->assertSessionHasErrors(['delivery_type']);
    }

    public function test_checkout_validation_requires_address_for_delivery()
    {
        $cart = [
            $this->muffin->id => ['id' => $this->muffin->id, 'name' => 'Muffin de Chocolate', 'price' => 3.50, 'image' => 'products/muffin-de-chocolate.jpg', 'quantity' => 1],
        ];
        Session::put('cart', $cart);

        $response = $this->actingAs($this->client)->post(route('checkout.whatsapp'), [
            'delivery_type' => 'llevar',
            'address_neighborhood' => '',
            'address_main_street' => '',
            'address_secondary_street' => '',
            'address_reference' => '',
        ]);

        $response->assertSessionHasErrors([
            'address_neighborhood',
            'address_main_street',
            'address_secondary_street',
            'address_reference',
        ]);
    }

    public function test_successful_whatsapp_checkout_redirection_and_session_clear()
    {
        $tea = Product::query()->where('slug', 'te-helado-de-durazno')->firstOrFail();

        $cart = [
            $this->muffin->id => ['id' => $this->muffin->id, 'name' => 'Muffin de Chocolate', 'price' => 3.50, 'image' => 'products/muffin-de-chocolate.jpg', 'quantity' => 2],
            $tea->id => ['id' => $tea->id, 'name' => 'Té Helado de Durazno', 'price' => 3.00, 'image' => 'products/te-helado-de-durazno.jpg', 'quantity' => 1],
        ];
        Session::put('cart', $cart);

        $response = $this->actingAs($this->client)->post(route('checkout.whatsapp'), [
            'delivery_type' => 'llevar',
            'address_neighborhood' => 'La Floresta',
            'address_main_street' => 'Av. de los Shyris',
            'address_secondary_street' => 'Calle El Universo',
            'address_reference' => 'Casa blanca, portón negro',
        ]);

        $response->assertRedirect(route('checkout.success'));
        $response->assertSessionHas('whatsapp_redirect_url');
        $response->assertSessionHas('order_number');

        $whatsappUrl = session('whatsapp_redirect_url');
        $this->assertStringContainsString('https://api.whatsapp.com/send', $whatsappUrl);
        $this->assertNull(Session::get('cart'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->client->id,
            'customer_name' => $this->client->name,
        ]);

        $successPage = $this->actingAs($this->client)->get(route('checkout.success'));
        $successPage->assertStatus(200);
        $successPage->assertSee('Pedido realizado con éxito');
        $successPage->assertSee('Abrir WhatsApp ahora', false);
    }
}
