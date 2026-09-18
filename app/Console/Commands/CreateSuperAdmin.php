<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:superadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super admin user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Check if super admin already exists
        if (User::where('email', 'superadmin123@example.com')->exists()) {
            $this->info('Super admin user already exists');
            return;
        }

        $user = User::create([
            'name' => 'Superadmin123',
            'email' => 'superadmin123@example.com',
            'password' => Hash::make('Admin123'),
            'role' => 'SUPER_ADMIN',
            'status' => 'aktif',
        ]);

        $this->info('Super admin user created successfully!');
        $this->info('Username/Email: superadmin123@example.com');
        $this->info('Password: Admin123');
    }
}
