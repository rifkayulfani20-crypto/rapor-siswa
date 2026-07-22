<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_bisa_login_dan_masuk_dashboard(): void
    {
        $user = User::factory()->create([
            'role'     => 'admin',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'role'     => 'admin',
            'email'    => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_gagal_kalau_role_dropdown_tidak_sesuai(): void
    {
        $user = User::factory()->create([
            'role'     => 'siswa',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'role'     => 'admin', // salah pilih role
            'email'    => $user->email,
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_guest_tidak_bisa_akses_dashboard_admin(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect(route('login'));
    }
}