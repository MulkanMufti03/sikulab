<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sikulab.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Petugas User
        User::create([
            'name' => 'Petugas Lab',
            'email' => 'petugas@sikulab.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'email_verified_at' => now(),
        ]);
    }
}