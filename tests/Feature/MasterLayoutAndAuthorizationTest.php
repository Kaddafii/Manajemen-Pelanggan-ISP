<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterLayoutAndAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan Administrator dapat mengakses seluruh modul.
     */
    public function test_administrator_can_access_all_routes(): void
    {
        $admin = User::factory()->create([
            'role' => 'Administrator',
        ]);

        $this->actingAs($admin)->get('/dashboard')->assertStatus(200);
        $this->actingAs($admin)->get('/users')->assertStatus(200);
        $this->actingAs($admin)->get('/customers')->assertStatus(200);
        $this->actingAs($admin)->get('/invoices')->assertStatus(200);
    }

    /**
     * Memastikan Staff dapat mengakses modul Pelanggan dan Tagihan.
     */
    public function test_staff_can_access_customer_and_invoice_routes(): void
    {
        $staff = User::factory()->create([
            'role' => 'Staff',
        ]);

        $this->actingAs($staff)->get('/customers')->assertStatus(200);
        $this->actingAs($staff)->get('/invoices')->assertStatus(200);
    }

    /**
     * Memastikan Staff ditolak (403) saat mencoba mengakses modul User dan Dashboard Administrator.
     */
    public function test_staff_cannot_access_administrator_restricted_routes(): void
    {
        $staff = User::factory()->create([
            'role' => 'Staff',
        ]);

        $this->actingAs($staff)->get('/dashboard')->assertStatus(403);
        $this->actingAs($staff)->get('/users')->assertStatus(403);
    }

    /**
     * Memastikan navigasi sidebar menampilkan menu sesuai hak akses Administrator.
     */
    public function test_sidebar_displays_full_navigation_for_administrator(): void
    {
        $admin = User::factory()->create([
            'role' => 'Administrator',
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertSee('Dashboard');
        $response->assertSee('Pelanggan');
        $response->assertSee('Tagihan');
        $response->assertSee('Kelola User');
    }

    /**
     * Memastikan navigasi sidebar menyembunyikan menu Kelola User untuk Staff.
     */
    public function test_sidebar_hides_user_management_for_staff(): void
    {
        $staff = User::factory()->create([
            'role' => 'Staff',
        ]);

        $response = $this->actingAs($staff)->get('/customers');

        $response->assertSee('Pelanggan');
        $response->assertSee('Tagihan');
        $response->assertDontSee('Kelola User');
    }
}
