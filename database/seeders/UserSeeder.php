<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@isp.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role' => 'Administrator',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@isp.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password'),
                'role' => 'Staff',
            ]
        );

        User::firstOrCreate(
            ['email' => 'michael.brown@isp.com'],
            [
                'name' => 'Michael Brown',
                'password' => Hash::make('password'),
                'role' => 'Staff',
            ]
        );

        User::firstOrCreate(
            ['email' => 'emily.davis@isp.com'],
            [
                'name' => 'Emily Davis',
                'password' => Hash::make('password'),
                'role' => 'Administrator',
            ]
        );
    }
}
