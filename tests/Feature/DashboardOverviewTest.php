<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardOverviewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan Dashboard menampilkan 5 metrik statistik dan grafik tagihan bulanan secara akurat.
     */
    public function test_dashboard_displays_correct_business_metrics_and_monthly_chart(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        // Buat data pelanggan dengan status beragam
        $activeCustomer = Customer::factory()->create(['status' => 'Aktif']);
        $suspendedCustomer = Customer::factory()->create(['status' => 'Suspend']);
        $terminatedCustomer = Customer::factory()->create(['status' => 'Putus']);

        // Buat tagihan Belum Bayar dan Lunas
        Invoice::create([
            'customer_id' => $activeCustomer->id,
            'billing_period' => 'Januari 2026',
            'billing_amount' => 200000,
            'payment_status' => 'Lunas',
            'payment_date' => now(),
        ]);

        Invoice::create([
            'customer_id' => $suspendedCustomer->id,
            'billing_period' => 'Februari 2026',
            'billing_amount' => 300000,
            'payment_status' => 'Belum Bayar',
            'payment_date' => null,
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);

        // Verifikasi 5 metrik statistik
        $response->assertSee('Total Pelanggan');
        $response->assertSee('Pelanggan Aktif');
        $response->assertSee('Pelanggan Suspend');
        $response->assertSee('Pelanggan Putus');
        $response->assertSee('Tagihan Belum Bayar');

        // Verifikasi grafik jumlah tagihan bulanan
        $response->assertSee('Grafik Jumlah Tagihan Per Bulan');
        $response->assertSee('Januari 2026');
        $response->assertSee('Februari 2026');
    }
}
