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
}
