<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Menjalankan seeding data awal aplikasi.
     */
    public function run(): void
    {
        // Pengguna dengan role Administrator
        User::firstOrCreate(
            ['email' => 'admin@isp.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'Administrator',
            ]
        );

        // Pengguna dengan role Staff
        User::firstOrCreate(
            ['email' => 'staff@isp.com'],
            [
                'name' => 'Staff Operasional',
                'password' => Hash::make('password123'),
                'role' => 'Staff',
            ]
        );
    }
}
