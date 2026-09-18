<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checksheet_masters', function (Blueprint $table) {
            $table->date('tanggal_kedatangan')->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('checksheet_masters', function (Blueprint $table) {
            $table->dropColumn('tanggal_kedatangan');
        });
    }
};
