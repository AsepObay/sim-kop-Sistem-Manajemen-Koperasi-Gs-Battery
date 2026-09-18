<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'kopkar123@simkop.local'],
            [
                'name' => 'Kopkar123',
                'password' => Hash::make('Kopkar123'),
                'status' => 'aktif',
            ]
        );

        // Call Dashboard Seeder
        $this->call([
            SuperAdminSeeder::class,
            DashboardSeeder::class,
            ChecksheetMasterSeeder::class,
        ]);
    }
}
