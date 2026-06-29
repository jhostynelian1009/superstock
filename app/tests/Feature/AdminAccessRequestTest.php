<?php

namespace Tests\Feature;

use App\Models\AdminAccessRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_guest_can_submit_admin_access_request(): void
    {
        $response = $this->post(route('register.admin'), [
            'name' => 'Nuevo Admin',
            'document_number' => '1723456789',
            'phone' => '0998123456',
            'email' => 'nuevo@admin.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('register.admin.verify'));
        $this->assertDatabaseHas('admin_access_requests', [
            'email' => 'nuevo@admin.com',
            'status' => AdminAccessRequest::STATUS_PENDING,
        ]);
    }

    public function test_primary_admin_can_approve_request_and_generate_code(): void
    {
        $primary = User::factory()->primaryAdmin()->create();
        $request = AdminAccessRequest::query()->create([
            'name' => 'Nuevo Admin',
            'document_number' => '1723456789',
            'phone' => '0998123456',
            'email' => 'nuevo@admin.com',
            'password' => bcrypt('password123'),
            'status' => AdminAccessRequest::STATUS_PENDING,
        ]);

        $response = $this->actingAs($primary)
            ->post(route('admin.solicitudes-admin.approve', $request));

        $response->assertRedirect();
        $response->assertSessionHas('generated_admin_code');

        $request->refresh();
        $this->assertEquals(AdminAccessRequest::STATUS_APPROVED, $request->status);
        $this->assertNotNull($request->verification_code);
    }

    public function test_non_primary_admin_cannot_manage_requests(): void
    {
        $admin = User::factory()->admin()->create();
        $request = AdminAccessRequest::query()->create([
            'name' => 'Nuevo Admin',
            'document_number' => '1723456789',
            'phone' => '0998123456',
            'email' => 'nuevo@admin.com',
            'password' => bcrypt('password123'),
            'status' => AdminAccessRequest::STATUS_PENDING,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.solicitudes-admin.index'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_guest_can_activate_admin_account_with_valid_code(): void
    {
        $plainCode = AdminAccessRequest::generatePlainCode();
        $request = AdminAccessRequest::query()->create([
            'name' => 'Nuevo Admin',
            'document_number' => '1723456789',
            'phone' => '0998123456',
            'email' => 'nuevo@admin.com',
            'password' => bcrypt('password123'),
            'status' => AdminAccessRequest::STATUS_PENDING,
        ]);

        $request->storeVerificationCode($plainCode);
        $request->update(['approved_by' => User::factory()->primaryAdmin()->create()->id]);

        $response = $this->post(route('register.admin.verify'), [
            'email' => 'nuevo@admin.com',
            'verification_code' => $plainCode,
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'nuevo@admin.com',
            'role' => User::ROLE_ADMIN,
            'is_primary_admin' => false,
        ]);
        $this->assertEquals(
            AdminAccessRequest::STATUS_COMPLETED,
            $request->fresh()->status
        );
    }

    public function test_primary_admin_can_resend_code_for_approved_request(): void
    {
        $primary = User::factory()->primaryAdmin()->create();
        $request = AdminAccessRequest::query()->create([
            'name' => 'Nuevo Admin',
            'document_number' => '1723456789',
            'phone' => '0998123456',
            'email' => 'nuevo@admin.com',
            'password' => bcrypt('password123'),
            'status' => AdminAccessRequest::STATUS_APPROVED,
            'verification_code' => bcrypt('OLDCODE'),
            'approved_by' => $primary->id,
            'expires_at' => now()->subHours(5), // expired
        ]);

        $response = $this->actingAs($primary)
            ->post(route('admin.solicitudes-admin.resend', $request));

        $response->assertRedirect();
        $response->assertSessionHas('generated_admin_code');

        $request->refresh();
        $this->assertEquals(AdminAccessRequest::STATUS_APPROVED, $request->status);
        $this->assertNotEquals(bcrypt('OLDCODE'), $request->verification_code);
        $this->assertTrue($request->expires_at->isFuture());
    }

    public function test_primary_admin_can_approve_request_with_permissions(): void
    {
        $primary = User::factory()->primaryAdmin()->create();
        $request = AdminAccessRequest::query()->create([
            'name' => 'Nuevo Admin Permisos',
            'document_number' => '1723456789',
            'phone' => '0998123456',
            'email' => 'nuevo_permisos@admin.com',
            'password' => bcrypt('password123'),
            'status' => AdminAccessRequest::STATUS_PENDING,
        ]);

        $response = $this->actingAs($primary)
            ->post(route('admin.solicitudes-admin.approve', $request), [
                'permissions' => ['productos', 'inventario']
            ]);

        $response->assertRedirect();
        $request->refresh();
        $this->assertEquals(AdminAccessRequest::STATUS_APPROVED, $request->status);
        $this->assertEquals(['productos', 'inventario'], $request->permissions);
    }

    public function test_user_created_with_approved_request_permissions(): void
    {
        $plainCode = AdminAccessRequest::generatePlainCode();
        $request = AdminAccessRequest::query()->create([
            'name' => 'Nuevo Admin Permisos',
            'document_number' => '1723456789',
            'phone' => '0998123456',
            'email' => 'nuevo_permisos@admin.com',
            'password' => bcrypt('password123'),
            'status' => AdminAccessRequest::STATUS_APPROVED,
            'permissions' => ['productos', 'inventario'],
        ]);

        $request->storeVerificationCode($plainCode);
        $request->update(['approved_by' => User::factory()->primaryAdmin()->create()->id]);

        $response = $this->post(route('register.admin.verify'), [
            'email' => 'nuevo_permisos@admin.com',
            'verification_code' => $plainCode,
        ]);

        $response->assertRedirect(route('login'));
        $user = User::where('email', 'nuevo_permisos@admin.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals(['productos', 'inventario'], $user->permissions);
    }

    public function test_non_authorized_user_is_redirected_away_from_forbidden_module(): void
    {
        // User has only 'productos' permission
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'permissions' => ['productos'],
        ]);

        // Allowed module access
        $response1 = $this->actingAs($user)
            ->get(route('admin.productos.index'));
        $response1->assertStatus(200);

        // Forbidden module access (should redirect to dashboard)
        $response2 = $this->actingAs($user)
            ->get(route('admin.proveedores.index'));
        $response2->assertRedirect(route('admin.dashboard'));
        $response2->assertSessionHas('error');
    }
}
