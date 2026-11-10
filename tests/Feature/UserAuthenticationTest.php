<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
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
            'remember_token' => null,
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
     * Memastikan token dan cookie "ingat saya" aktif saat checkbox dicentang.
     */
    public function test_user_is_remembered_when_remember_me_is_checked(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@isp.com',
            'role' => 'Administrator',
            'remember_token' => null,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@isp.com',
            'password' => 'password',
            'remember' => '1',
        ]);

        $this->assertAuthenticatedAs($user);

        // Memastikan cookie remember dibuat oleh sistem
        $recallerCookieName = Auth::getRecallerName();
        $response->assertCookie($recallerCookieName);

        // Memastikan token remember_token tersimpan di tabel database pengguna
        $user->refresh();
        $this->assertNotNull($user->remember_token);
        $this->assertNotEmpty($user->remember_token);
    }

    /**
     * Memastikan token dan cookie "ingat saya" tidak aktif jika checkbox tidak dicentang.
     */
    public function test_user_is_not_remembered_when_remember_me_is_unchecked(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@isp.com',
            'role' => 'Administrator',
            'remember_token' => null,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@isp.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);

        // Memastikan cookie remember tidak disertakan pada respon
        $recallerCookieName = Auth::getRecallerName();
        $response->assertCookieMissing($recallerCookieName);

        // Memastikan token di database tetap kosong/null
        $user->refresh();
        $this->assertNull($user->remember_token);
    }

    /**
     * Memastikan sesi pengguna dapat dipulihkan otomatis melalui cookie "ingat saya" saat sesi browser berakhir.
     */
    public function test_user_session_is_automatically_restored_via_remember_cookie(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@isp.com',
            'role' => 'Administrator',
            'remember_token' => null,
        ]);

        $loginResponse = $this->post('/login', [
            'email' => 'admin@isp.com',
            'password' => 'password',
            'remember' => '1',
        ]);

        $recallerCookieName = Auth::getRecallerName();
        $recallerCookie = $loginResponse->getCookie($recallerCookieName);

        $this->assertNotNull($recallerCookie);

        // Bersihkan sesi aktif saat ini untuk mensimulasikan browser ditutup / sesi habis
        $this->flushSession();

        // Kunjungi halaman yang dilindungi middleware 'auth' hanya dengan menyertakan cookie recaller
        $response = $this->withUnencryptedCookie($recallerCookieName, $recallerCookie->getValue())
            ->get('/dashboard');

        // Pengguna otomatis terotentikasi kembali
        $this->assertAuthenticatedAs($user);
        $response->assertStatus(200);
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

    /**
     * Memastikan percobaan login dibatasi setelah gagal 5 kali berturut-turut.
     */
    public function test_login_attempts_are_throttled_after_too_many_failures(): void
    {
        User::factory()->create([
            'email' => 'admin@isp.com',
            'password' => 'password',
            'role' => 'Administrator',
        ]);

        // Melakukan 5 kali percobaan login dengan password salah
        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $response = $this->from('/login')->post('/login', [
                'email' => 'admin@isp.com',
                'password' => 'wrong-password',
            ]);

            $response->assertSessionHasErrors('email');
            $this->assertGuest();
        }

        // Percobaan ke-6 harus diblokir oleh Rate Limiter
        $blockedResponse = $this->from('/login')->post('/login', [
            'email' => 'admin@isp.com',
            'password' => 'wrong-password',
        ]);

        $blockedResponse->assertRedirect('/login');
        $blockedResponse->assertSessionHasErrors(['email']);
        $this->assertTrue(
            session('errors')->first('email') !== 'Kombinasi alamat email dan kata sandi tidak sesuai dengan catatan kami.'
        );
        $this->assertStringContainsString('Terlalu banyak percobaan login', session('errors')->first('email'));
    }

    /**
     * Memastikan rate limiter dibersihkan saat login berhasil.
     */
    public function test_login_rate_limiter_is_cleared_after_successful_authentication(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@isp.com',
            'password' => 'password',
            'role' => 'Administrator',
        ]);

        // 2 kali gagal
        $this->post('/login', [
            'email' => 'admin@isp.com',
            'password' => 'wrong-password',
        ]);
        $this->post('/login', [
            'email' => 'admin@isp.com',
            'password' => 'wrong-password',
        ]);

        // Berhasil login
        $successResponse = $this->post('/login', [
            'email' => 'admin@isp.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $successResponse->assertRedirect(route('dashboard.index'));
    }
}
