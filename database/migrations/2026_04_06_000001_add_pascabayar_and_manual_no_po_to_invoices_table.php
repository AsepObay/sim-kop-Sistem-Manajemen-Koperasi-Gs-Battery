<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('no_po_manual')->nullable()->after('no_invoice');
        });

        DB::statement("ALTER TABLE invoices MODIFY COLUMN tipe ENUM('PO', 'NON_PO', 'PASCABAYAR') NOT NULL DEFAULT 'PO'");
    }

    public function down(): void
    {
        DB::statement("UPDATE invoices SET tipe = 'NON_PO' WHERE tipe = 'PASCABAYAR'");
        DB::statement("ALTER TABLE invoices MODIFY COLUMN tipe ENUM('PO', 'NON_PO') NOT NULL DEFAULT 'PO'");

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('no_po_manual');
        });
    }
};
