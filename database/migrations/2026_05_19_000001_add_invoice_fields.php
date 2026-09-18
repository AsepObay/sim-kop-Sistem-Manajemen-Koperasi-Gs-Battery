<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (! Schema::hasColumn('invoices', 'no_po_manual')) {
                $table->string('no_po_manual')->nullable()->after('no_invoice');
            }

            if (! Schema::hasColumn('invoices', 'no_so')) {
                $table->string('no_so')->nullable()->after('no_po_manual');
            }

            if (! Schema::hasColumn('invoices', 'tipe_bisnis')) {
                $table->string('tipe_bisnis')->nullable()->after('no_so');
            }

            if (! Schema::hasColumn('invoices', 'sudah_ditagihkan')) {
                $table->boolean('sudah_ditagihkan')->default(false)->after('tipe_bisnis');
            }

            if (! Schema::hasColumn('invoices', 'sudah_selesai')) {
                $table->boolean('sudah_selesai')->default(false)->after('sudah_ditagihkan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'sudah_selesai')) {
                $table->dropColumn('sudah_selesai');
            }

            if (Schema::hasColumn('invoices', 'sudah_ditagihkan')) {
                $table->dropColumn('sudah_ditagihkan');
            }

            if (Schema::hasColumn('invoices', 'tipe_bisnis')) {
                $table->dropColumn('tipe_bisnis');
            }

            if (Schema::hasColumn('invoices', 'no_so')) {
                $table->dropColumn('no_so');
            }

            if (Schema::hasColumn('invoices', 'no_po_manual')) {
                $table->dropColumn('no_po_manual');
            }
        });
    }
};
