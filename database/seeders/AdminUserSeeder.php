<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'ADMIN11',
            'email' => 'admin@simkop.local',
            'email_verified_at' => now(),
            'password' => '$2y$10$2NDZlNSSWoQbEFPCe/H3feDnl/kWuGitcgQHRq/.I/tCjLEIvOKx6',
            'phone' => null,
            'address' => null,
            'position' => 'Administrator',
            'department' => 'IT',
            'status' => 'aktif',
            'profile_photo' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
