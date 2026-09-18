<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checksheet_masters', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('name');
            $table->unsignedInteger('quantity')->default(0)->after('tanggal');
            $table->boolean('is_archived')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('checksheet_masters', function (Blueprint $table) {
            $table->dropColumn(['tanggal', 'quantity', 'is_archived']);
        });
    }
};
