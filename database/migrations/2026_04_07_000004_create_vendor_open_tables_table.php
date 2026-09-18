<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vendor_open_tables', function (Blueprint $table) {
            $table->id();
            $table->string('nama_vendor');
            $table->json('tanggal_open_table');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_open_tables');
    }
};
