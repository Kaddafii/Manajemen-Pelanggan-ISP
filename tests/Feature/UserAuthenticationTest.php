<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan halaman login dapat dirender dengan sukses.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk Akun');
        $response->assertSee('Manajemen Pelanggan ISP');
    }

    /**
     * Memastikan pengguna dapat login menggunakan kredensial yang valid.
     */
    public function test_user_can_authenticate_using_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@isp.com',
            'role' => 'Administrator',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@isp.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard.index'));
    }

    /**
     * Memastikan pengguna gagal login jika kata sandi salah.
     */
    public function test_user_cannot_authenticate_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'admin@isp.com',
            'role' => 'Administrator',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@isp.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    /**
     * Memastikan pengguna dapat melakukan logout dan mengakhiri sesi.
     */
    public function test_user_can_logout_and_terminate_session(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@isp.com',
            'role' => 'Administrator',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login.form'));
    }
}
