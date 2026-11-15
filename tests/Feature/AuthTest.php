<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_register_pages_render(): void
    {
        $this->get('/login')->assertOk()->assertSee('Sign in');
        $this->get('/register')->assertOk()->assertSee('Sign up');
    }

    public function test_register_creates_vendor_and_logs_in(): void
    {
        $this->post('/register', [
            'name' => 'Toko Beku',
            'email' => 'toko@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => '1',
            'role' => 'admin', // harus diabaikan
        ])->assertRedirect(route('vendor.dashboard'));

        $this->assertAuthenticated();
        $this->assertSame('vendor', User::where('email', 'toko@example.com')->value('role'));
    }

    public function test_register_validates_input(): void
    {
        $this->post('/register', ['email' => 'x'])
            ->assertSessionHasErrors(['name', 'email', 'password', 'terms']);
    }

    public function test_login_redirects_by_role(): void
    {
        User::factory()->admin()->create(['email' => 'a@example.com']);
        User::factory()->create(['email' => 'v@example.com']);

        $this->post('/login', ['email' => 'a@example.com', 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));
        $this->post('/logout')->assertRedirect(route('login'));

        $this->post('/login', ['email' => 'v@example.com', 'password' => 'password'])
            ->assertRedirect(route('vendor.dashboard'));
    }

    public function test_wrong_password_fails(): void
    {
        User::factory()->create(['email' => 'v@example.com']);

        $this->from('/login')->post('/login', ['email' => 'v@example.com', 'password' => 'salah'])
            ->assertRedirect('/login')->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_dashboards_require_correct_role(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('login'));

        $vendor = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($vendor)->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($vendor)->get('/vendor/dashboard')->assertOk();
        $this->actingAs($admin)->get('/admin/dashboard')->assertOk();
        $this->actingAs($admin)->get('/login')->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_user_crud(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $this->get('/admin/users')->assertOk();
        $this->get('/admin/users/create')->assertOk();

        $this->post('/admin/users', [
            'name' => 'Baru', 'email' => 'baru@example.com', 'role' => 'vendor',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertRedirect('/admin/users');

        $u = User::where('email', 'baru@example.com')->firstOrFail();
        $this->get("/admin/users/{$u->id}/edit")->assertOk();
        $this->put("/admin/users/{$u->id}", ['name' => 'Ubah', 'email' => 'baru@example.com', 'role' => 'admin'])
            ->assertRedirect('/admin/users');
        $this->assertSame('admin', $u->fresh()->role);

        $this->delete("/admin/users/{$u->id}")->assertRedirect('/admin/users');
        $this->assertModelMissing($u);

        $this->delete("/admin/users/{$admin->id}")->assertSessionHas('error');
        $this->assertModelExists($admin);
    }
}
