<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_login_page_renders(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Ingresa a tu cuenta');
        $response->assertSee('Administrador');
        $response->assertSee('Cliente');
    }

    public function test_register_page_renders(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Crea tu cuenta de cliente');
        $response->assertSee('Número de cédula');
    }

    public function test_successful_client_registration(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'document_number' => '1723456789',
            'phone' => '0998123456',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('client.dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => User::ROLE_CLIENT,
            'document_number' => '1723456789',
        ]);
        $this->assertAuthenticated();
    }

    public function test_failed_registration(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'document_number' => '',
            'phone' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $response->assertSessionHasErrors(['name', 'document_number', 'phone', 'email', 'password']);
        $this->assertGuest();
    }

    public function test_successful_admin_login(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login_as' => User::ROLE_ADMIN,
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_successful_client_login(): void
    {
        $user = User::factory()->client()->create([
            'email' => 'client@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login_as' => User::ROLE_CLIENT,
            'email' => 'client@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('client.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_rejects_wrong_role_selection(): void
    {
        User::factory()->client()->create([
            'email' => 'client@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login_as' => User::ROLE_ADMIN,
            'email' => 'client@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['login_as']);
        $this->assertGuest();
    }

    public function test_failed_login(): void
    {
        User::factory()->client()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login_as' => User::ROLE_CLIENT,
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_successful_logout(): void
    {
        $user = User::factory()->client()->create();

        $response = $this->actingAs($user)->get('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
