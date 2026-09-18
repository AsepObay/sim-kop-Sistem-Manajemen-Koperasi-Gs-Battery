<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE invoices MODIFY COLUMN tipe ENUM('PO', 'NON_PO', 'PASCABAYAR', 'MESIN_VENDING', 'PULSA_MODEM', 'VOUCHER') NOT NULL DEFAULT 'PO'");
    }

    public function down(): void
    {
        DB::statement("UPDATE invoices SET tipe = 'NON_PO' WHERE tipe = 'VOUCHER'");
        DB::statement("ALTER TABLE invoices MODIFY COLUMN tipe ENUM('PO', 'NON_PO', 'PASCABAYAR', 'MESIN_VENDING', 'PULSA_MODEM') NOT NULL DEFAULT 'PO'");
    }
};
