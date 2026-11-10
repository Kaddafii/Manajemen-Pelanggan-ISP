<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan Administrator dapat mengakses daftar pengguna.
     */
    public function test_administrator_can_view_user_list(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $staff = User::factory()->create(['name' => 'Staff Uji', 'role' => 'Staff']);

        $response = $this->actingAs($admin)->get('/users');

        $response->assertStatus(200);
        $response->assertSee('Kelola Pengguna');
        $response->assertSee('Staff Uji');
        $response->assertSee('Staff');
    }

    /**
     * Memastikan Staff TIDAK DAPAT mengakses daftar pengguna (403 Forbidden).
     */
    public function test_staff_cannot_access_user_list(): void
    {
        $staff = User::factory()->create(['role' => 'Staff']);

        $response = $this->actingAs($staff)->get('/users');

        $response->assertStatus(403);
    }

    /**
     * Memastikan daftar pengguna mendukung fitur pencarian kata kunci nama atau email.
     */
    public function test_user_list_supports_searching(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        User::factory()->create(['name' => 'Fajar Pratama', 'email' => 'fajar@isp.com']);
        User::factory()->create(['name' => 'Indah Permata', 'email' => 'indah@isp.com']);

        $response = $this->actingAs($admin)->get('/users?search=Fajar');

        $response->assertStatus(200);
        $response->assertSee('Fajar Pratama');
        $response->assertDontSee('Indah Permata');
    }

    /**
     * Memastikan daftar pengguna mendukung filter berdasarkan role.
     */
    public function test_user_list_supports_role_filtering(): void
    {
        $admin = User::factory()->create(['name' => 'Super Admin', 'role' => 'Administrator']);
        User::factory()->create(['name' => 'Target Admin Khusus', 'role' => 'Administrator']);
        User::factory()->create(['name' => 'Staff Lapangan', 'role' => 'Staff']);

        $response = $this->actingAs($admin)->get('/users?role=Staff');

        $response->assertStatus(200);
        $response->assertSee('Staff Lapangan');
        $response->assertDontSee('Target Admin Khusus');
    }

    /**
     * Memastikan Administrator dapat mengakses formulir penambahan pengguna baru.
     */
    public function test_administrator_can_access_user_creation_form(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin)->get('/users/create');

        $response->assertStatus(200);
        $response->assertSee('Tambah Pengguna Baru');
    }

    /**
     * Memastikan Staff TIDAK DAPAT mengakses formulir penambahan pengguna (403 Forbidden).
     */
    public function test_staff_cannot_access_user_creation_form(): void
    {
        $staff = User::factory()->create(['role' => 'Staff']);

        $response = $this->actingAs($staff)->get('/users/create');

        $response->assertStatus(403);
    }

    /**
     * Memastikan Administrator dapat menyimpan pengguna baru dengan data valid.
     */
    public function test_administrator_can_store_new_user(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $userData = [
            'name' => 'Rendra Wijaya',
            'email' => 'rendra@isp.com',
            'password' => 'secret123',
            'role' => 'Staff',
        ];

        $response = $this->actingAs($admin)->post('/users', $userData);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Rendra Wijaya',
            'email' => 'rendra@isp.com',
            'role' => 'Staff',
        ]);

        $createdUser = User::where('email', 'rendra@isp.com')->first();
        $this->assertTrue(Hash::check('secret123', $createdUser->password));
    }

    /**
     * Memastikan penambahan pengguna baru gagal jika validasi tidak terpenuhi.
     */
    public function test_user_creation_requires_valid_data(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin)->post('/users', [
            'name' => '',
            'email' => 'bukan-email',
            'password' => '123', // Kurang dari 6 karakter
            'role' => 'RolePalsu',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'role']);
    }

    /**
     * Memastikan Administrator dapat memperbarui data pengguna lain.
     */
    public function test_administrator_can_update_existing_user(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $user = User::factory()->create([
            'name' => 'Nama Sebelum Update',
            'email' => 'lama@isp.com',
            'role' => 'Staff',
        ]);

        $response = $this->actingAs($admin)->put("/users/{$user->id}", [
            'name' => 'Nama Setelah Update',
            'email' => 'baru@isp.com',
            'role' => 'Administrator',
            'password' => '', // Password tidak diubah
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Setelah Update',
            'email' => 'baru@isp.com',
            'role' => 'Administrator',
        ]);
    }

    /**
     * Memastikan Administrator dapat mengubah password pengguna jika field password diisi.
     */
    public function test_administrator_can_update_user_password(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $user = User::factory()->create([
            'role' => 'Staff',
            'password' => Hash::make('passwordLama'),
        ]);

        $response = $this->actingAs($admin)->put("/users/{$user->id}", [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 'Staff',
            'password' => 'passwordBaru123',
        ]);

        $response->assertRedirect(route('users.index'));

        $user->refresh();
        $this->assertTrue(Hash::check('passwordBaru123', $user->password));
    }

    /**
     * Memastikan Administrator dapat menghapus pengguna lain.
     */
    public function test_administrator_can_delete_other_user(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $otherUser = User::factory()->create(['role' => 'Staff']);

        $response = $this->actingAs($admin)->delete("/users/{$otherUser->id}");

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $otherUser->id,
        ]);
    }

    /**
     * Memastikan Administrator TIDAK DAPAT menghapus akunnya sendiri yang sedang aktif digunakan.
     */
    public function test_administrator_cannot_delete_own_account(): void
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin)->delete("/users/{$admin->id}");

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }

    /**
     * Memastikan Staff TIDAK DAPAT menghapus pengguna (403 Forbidden).
     */
    public function test_staff_cannot_delete_user(): void
    {
        $staff = User::factory()->create(['role' => 'Staff']);
        $otherUser = User::factory()->create(['role' => 'Staff']);

        $response = $this->actingAs($staff)->delete("/users/{$otherUser->id}");

        $response->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $otherUser->id,
        ]);
    }
}
