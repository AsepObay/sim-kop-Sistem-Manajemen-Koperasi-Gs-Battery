<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop vendor_trackings table if exists
        if (Schema::hasTable('vendor_trackings')) {
            Schema::dropIfExists('vendor_trackings');
        }

        // Remove tracking columns from invoices table if they exist
        if (Schema::hasTable('invoices')) {
            if (Schema::hasColumn('invoices', 'sudah_ditagihkan') || Schema::hasColumn('invoices', 'sudah_selesai')) {
                Schema::table('invoices', function (Blueprint $table) {
                    if (Schema::hasColumn('invoices', 'sudah_ditagihkan')) {
                        $table->dropColumn('sudah_ditagihkan');
                    }
                    if (Schema::hasColumn('invoices', 'sudah_selesai')) {
                        $table->dropColumn('sudah_selesai');
                    }
                });
            }
        }
    }

    public function down(): void
    {
        // Recreate tracking columns on invoices
        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                if (!Schema::hasColumn('invoices', 'sudah_ditagihkan')) {
                    $table->boolean('sudah_ditagihkan')->default(false)->after('tanggal_invoice');
                }
                if (!Schema::hasColumn('invoices', 'sudah_selesai')) {
                    $table->boolean('sudah_selesai')->default(false)->after('sudah_ditagihkan');
                }
            });
        }

        // Recreate vendor_trackings table
        if (!Schema::hasTable('vendor_trackings')) {
            Schema::create('vendor_trackings', function (Blueprint $table) {
                $table->id();
                $table->string('nama_vendor');
                $table->text('progress')->nullable();
                $table->dateTime('jadwal_janji_temu')->nullable();
                $table->boolean('checklist_mou')->default(false);
                $table->boolean('checklist_review_mou')->default(false);
                $table->boolean('ttd_mou')->default(false);
                $table->boolean('selesai')->default(false);
                $table->timestamps();
            });
        }
    }
};
