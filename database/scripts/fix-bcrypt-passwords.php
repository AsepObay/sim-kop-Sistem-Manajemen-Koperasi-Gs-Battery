<?php
/**
 * Script untuk fix password Bcrypt issue
 * Jalankan di Laravel Tinker: php artisan tinker
 * Lalu copy-paste kode di bawah
 */

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Cek daftar user saat ini
$users = User::all();
echo "Total user: " . $users->count() . "\n";

// Fix semua password dengan Bcrypt
foreach ($users as $user) {
    // Cek apakah password sudah Bcrypt (dimulai dengan $2y$ atau $2b$ atau $2a$)
    if (!str_starts_with($user->password, '$2')) {
        echo "Update password untuk user: " . $user->name . " (id: " . $user->id . ")\n";
        
        // Hash password baru dengan Bcrypt
        // Default password: password123 (ubah sesuai kebutuhan)
        $user->password = Hash::make('password123');
        $user->save();
        echo "✓ Password berhasil di-hash untuk: " . $user->name . "\n";
    } else {
        echo "✓ Password sudah Bcrypt untuk: " . $user->name . "\n";
    }
}

echo "\nSelesai! Semua password sudah di-hash dengan Bcrypt.\n";
echo "Coba login dengan password: password123\n";
