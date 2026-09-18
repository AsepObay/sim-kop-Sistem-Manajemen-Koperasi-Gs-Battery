<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE invoices MODIFY COLUMN tipe ENUM('PO', 'NON_PO', 'PASCABAYAR', 'MESIN_VENDING', 'PULSA_MODEM') NOT NULL DEFAULT 'PO'");
    }

    public function down(): void
    {
        DB::statement("UPDATE invoices SET tipe = 'NON_PO' WHERE tipe = 'PULSA_MODEM'");
        DB::statement("ALTER TABLE invoices MODIFY COLUMN tipe ENUM('PO', 'NON_PO', 'PASCABAYAR', 'MESIN_VENDING') NOT NULL DEFAULT 'PO'");
    }
};
