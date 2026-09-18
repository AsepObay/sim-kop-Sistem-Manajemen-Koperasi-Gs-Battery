<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumns('users', [
            'phone',
            'address',
            'position',
            'department',
            'status',
            'profile_photo',
        ])) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'phone')) {
                    $table->string('phone', 50)->nullable()->after('password');
                }
                if (!Schema::hasColumn('users', 'address')) {
                    $table->string('address')->nullable()->after('phone');
                }
                if (!Schema::hasColumn('users', 'position')) {
                    $table->string('position', 100)->nullable()->after('address');
                }
                if (!Schema::hasColumn('users', 'department')) {
                    $table->string('department', 100)->nullable()->after('position');
                }
                if (!Schema::hasColumn('users', 'status')) {
                    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('department');
                }
                if (!Schema::hasColumn('users', 'profile_photo')) {
                    $table->string('profile_photo')->nullable()->after('status');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'address',
                'position',
                'department',
                'status',
                'profile_photo',
            ]);
        });
    }
};
