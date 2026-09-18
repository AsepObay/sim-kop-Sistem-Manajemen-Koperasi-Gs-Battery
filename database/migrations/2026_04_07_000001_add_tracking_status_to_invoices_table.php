<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('sudah_ditagihkan')->default(false)->after('tanggal_invoice');
            $table->boolean('sudah_selesai')->default(false)->after('sudah_ditagihkan');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['sudah_ditagihkan', 'sudah_selesai']);
        });
    }
};