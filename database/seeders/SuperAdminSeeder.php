<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin123'),
                'role' => 'SUPER_ADMIN',
                'status' => 'aktif',
            ]
        );

        // Create a regular admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin123'),
                'role' => 'ADMIN',
                'status' => 'aktif',
            ]
        );

        // Create a demo admin user
        User::updateOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'demo',
                'password' => Hash::make('demo'),
                'role' => 'ADMIN',
                'status' => 'aktif',
            ]
        );
    }
}
