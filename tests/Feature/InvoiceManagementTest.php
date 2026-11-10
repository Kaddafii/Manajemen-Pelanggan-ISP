<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan Administrator dan Staff dapat melihat daftar tagihan.
     */
    public function test_authenticated_users_can_view_invoice_list(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $staff = User::factory()->create(['role' => 'Staff']);

        $customer = Customer::factory()->create();
        Invoice::create([
            'customer_id' => $customer->id,
            'billing_period' => 'Maret 2026',
            'billing_amount' => 300000,
            'payment_status' => 'Belum Bayar',
            'payment_date' => null,
        ]);

        $this->actingAs($admin)->get('/invoices')
            ->assertStatus(200)
            ->assertSee('Kelola Tagihan')
            ->assertSee('Maret 2026');

        $this->actingAs($staff)->get('/invoices')
            ->assertStatus(200)
            ->assertSee('Kelola Tagihan')
            ->assertSee('Maret 2026');
    }

    /**
     * Memastikan daftar tagihan mendukung pencarian kata kunci pelanggan atau periode.
     */
    public function test_invoice_list_supports_searching(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $customer1 = Customer::factory()->create(['name' => 'Bambang Sudirman']);
        $customer2 = Customer::factory()->create(['name' => 'Dewi Sartika']);

        Invoice::create([
            'customer_id' => $customer1->id,
            'billing_period' => 'Januari 2026',
            'billing_amount' => 250000,
            'payment_status' => 'Lunas',
            'payment_date' => now(),
        ]);

        Invoice::create([
            'customer_id' => $customer2->id,
            'billing_period' => 'Februari 2026',
            'billing_amount' => 450000,
            'payment_status' => 'Belum Bayar',
            'payment_date' => null,
        ]);

        $response = $this->actingAs($admin)->get('/invoices?search=Bambang');
        $response->assertStatus(200);
        $response->assertSee('Bambang Sudirman');
        $response->assertDontSee('Dewi Sartika');

        $responsePeriod = $this->actingAs($admin)->get('/invoices?search=Februari');
        $responsePeriod->assertStatus(200);
        $responsePeriod->assertSee('Dewi Sartika');
        $responsePeriod->assertDontSee('Bambang Sudirman');
    }

    /**
     * Memastikan daftar tagihan mendukung filter status pembayaran.
     */
    public function test_invoice_list_supports_status_filtering(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $customer = Customer::factory()->create();

        Invoice::create([
            'customer_id' => $customer->id,
            'billing_period' => 'Periode Lunas',
            'billing_amount' => 200000,
            'payment_status' => 'Lunas',
            'payment_date' => now(),
        ]);

        Invoice::create([
            'customer_id' => $customer->id,
            'billing_period' => 'Periode Belum Bayar',
            'billing_amount' => 300000,
            'payment_status' => 'Belum Bayar',
            'payment_date' => null,
        ]);

        $response = $this->actingAs($admin)->get('/invoices?status=Belum Bayar');
        $response->assertStatus(200);
        $response->assertSee('Periode Belum Bayar');
        $response->assertDontSee('Periode Lunas');
    }

    /**
     * Memastikan Administrator dapat mengakses formulir pembuatan tagihan baru.
     */
    public function test_administrator_can_access_invoice_creation_form(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $this->actingAs($admin)->get('/invoices/create')
            ->assertStatus(200)
            ->assertSee('Tambah Tagihan Baru');
    }

    /**
     * Memastikan Staff TIDAK DAPAT mengakses formulir pembuatan tagihan (403 Forbidden).
     */
    public function test_staff_cannot_access_invoice_creation_form(): void
    {
        $staff = User::factory()->create(['role' => 'Staff']);

        $this->actingAs($staff)->get('/invoices/create')
            ->assertStatus(403);
    }

    /**
     * Memastikan Administrator dapat menyimpan data tagihan baru dengan validasi data.
     */
    public function test_administrator_can_store_new_invoice(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $customer = Customer::factory()->create();

        $invoiceData = [
            'customer_id' => $customer->id,
            'billing_period' => 'April 2026',
            'billing_amount' => 350000,
            'payment_status' => 'Belum Bayar',
        ];

        $response = $this->actingAs($admin)->post('/invoices', $invoiceData);

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('invoices', [
            'customer_id' => $customer->id,
            'billing_period' => 'April 2026',
            'billing_amount' => 350000,
            'payment_status' => 'Belum Bayar',
            'payment_date' => null,
        ]);
    }

    /**
     * Memastikan pembuatan tagihan baru gagal bila input tidak valid.
     */
    public function test_invoice_creation_requires_valid_data(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin)->post('/invoices', [
            'customer_id' => 999999, // Customer tidak ada
            'billing_period' => '',
            'billing_amount' => -10000,
            'payment_status' => 'StatusPalsu',
        ]);

        $response->assertSessionHasErrors([
            'customer_id',
            'billing_period',
            'billing_amount',
            'payment_status',
        ]);
    }

    /**
     * Memastikan Administrator dapat melakukan pembayaran tagihan ("Bayar").
     * Status otomatis berubah menjadi Lunas dan tanggal pembayaran tersimpan.
     */
    public function test_administrator_can_mark_invoice_as_paid(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $customer = Customer::factory()->create();

        $invoice = Invoice::create([
            'customer_id' => $customer->id,
            'billing_period' => 'Maret 2026',
            'billing_amount' => 300000,
            'payment_status' => 'Belum Bayar',
            'payment_date' => null,
        ]);

        $response = $this->actingAs($admin)->patch("/invoices/{$invoice->id}/pay");

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHas('success');

        $invoice->refresh();

        $this->assertTrue($invoice->isPaidStatus());
        $this->assertNotNull($invoice->payment_date);
    }

    /**
     * Memastikan Staff TIDAK DAPAT melakukan pembayaran tagihan (403 Forbidden).
     */
    public function test_staff_cannot_mark_invoice_as_paid(): void
    {
        $staff = User::factory()->create(['role' => 'Staff']);
        $customer = Customer::factory()->create();

        $invoice = Invoice::create([
            'customer_id' => $customer->id,
            'billing_period' => 'Maret 2026',
            'billing_amount' => 300000,
            'payment_status' => 'Belum Bayar',
            'payment_date' => null,
        ]);

        $response = $this->actingAs($staff)->patch("/invoices/{$invoice->id}/pay");

        $response->assertStatus(403);

        $invoice->refresh();
        $this->assertTrue($invoice->isUnpaidStatus());
        $this->assertNull($invoice->payment_date);
    }
}
