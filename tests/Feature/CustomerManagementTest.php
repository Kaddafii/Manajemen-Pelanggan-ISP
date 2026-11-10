<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan Administrator dan Staff dapat melihat daftar pelanggan.
     */
    public function test_authenticated_users_can_view_customer_list(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $staff = User::factory()->create(['role' => 'Staff']);

        Customer::factory()->count(3)->create();

        $this->actingAs($admin)->get('/customers')
            ->assertStatus(200)
            ->assertSee('Kelola Pelanggan');

        $this->actingAs($staff)->get('/customers')
            ->assertStatus(200)
            ->assertSee('Kelola Pelanggan');
    }

    /**
     * Memastikan fitur pencarian pelanggan berfungsi dengan baik.
     */
    public function test_customer_list_supports_searching(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        Customer::factory()->create(['name' => 'Budi Santoso', 'phone_number' => '0811111111']);
        Customer::factory()->create(['name' => 'Siti Rahma', 'phone_number' => '0822222222']);

        $response = $this->actingAs($admin)->get('/customers?search=Budi');

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertDontSee('Siti Rahma');
    }

    /**
     * Memastikan fitur sorting pelanggan dapat mengurutkan data dengan benar.
     */
    public function test_customer_list_supports_sorting(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        Customer::factory()->create(['name' => 'Anton', 'package_price' => 100000]);
        Customer::factory()->create(['name' => 'Zainal', 'package_price' => 500000]);

        $response = $this->actingAs($admin)->get('/customers?sort=name&direction=desc');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Zainal', 'Anton']);
    }

    /**
     * Memastikan pengguna dapat menambahkan data pelanggan baru dengan validasi data.
     */
    public function test_user_can_create_new_customer(): void
    {
        $user = User::factory()->create(['role' => 'Staff']);

        $customerData = [
            'name' => 'Ahmad Fauzi',
            'phone_number' => '08123456789',
            'address' => 'Jl. Merdeka No. 10 Jakarta',
            'internet_package' => 'Fiber 50 Mbps',
            'package_price' => 350000,
            'status' => 'Aktif',
        ];

        $response = $this->actingAs($user)->post('/customers', $customerData);

        $response->assertRedirect(route('customers.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('customers', [
            'name' => 'Ahmad Fauzi',
            'phone_number' => '08123456789',
            'status' => 'Aktif',
        ]);
    }

    /**
     * Memastikan penambahan pelanggan gagal bila data tidak valid.
     */
    public function test_customer_creation_requires_valid_data(): void
    {
        $user = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($user)->post('/customers', [
            'name' => '',
            'phone_number' => '',
            'address' => '',
            'internet_package' => '',
            'package_price' => -500,
            'status' => 'StatusTidakValid',
        ]);

        $response->assertSessionHasErrors([
            'name',
            'phone_number',
            'address',
            'internet_package',
            'package_price',
            'status',
        ]);
    }

    /**
     * Memastikan data pelanggan dapat diubah.
     */
    public function test_user_can_update_existing_customer(): void
    {
        $user = User::factory()->create(['role' => 'Staff']);
        $customer = Customer::factory()->create([
            'name' => 'Nama Lama',
            'status' => 'Aktif',
        ]);

        $response = $this->actingAs($user)->put("/customers/{$customer->id}", [
            'name' => 'Nama Baru Diperbarui',
            'phone_number' => $customer->phone_number,
            'address' => $customer->address,
            'internet_package' => $customer->internet_package,
            'package_price' => $customer->package_price,
            'status' => 'Suspend',
        ]);

        $response->assertRedirect(route('customers.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Nama Baru Diperbarui',
            'status' => 'Suspend',
        ]);
    }

    /**
     * Memastikan Administrator dapat menghapus pelanggan menggunakan Soft Delete.
     */
    public function test_administrator_can_delete_customer_using_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $customer = Customer::factory()->create();

        $response = $this->actingAs($admin)->delete("/customers/{$customer->id}");

        $response->assertRedirect(route('customers.index'));
        $response->assertSessionHas('success');

        // Memastikan data terhapus secara lunak (Soft Delete)
        $this->assertSoftDeleted('customers', [
            'id' => $customer->id,
        ]);
    }

    /**
     * Memastikan Staff TIDAK DAPAT menghapus pelanggan (Akses Ditolak 403).
     */
    public function test_staff_cannot_delete_customer(): void
    {
        $staff = User::factory()->create(['role' => 'Staff']);
        $customer = Customer::factory()->create();

        $response = $this->actingAs($staff)->delete("/customers/{$customer->id}");

        $response->assertStatus(403);

        // Memastikan data tetap ada di database dan tidak ter-soft-delete
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'deleted_at' => null,
        ]);
    }
}
