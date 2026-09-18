<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
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

    public function down(): void
    {
        Schema::dropIfExists('vendor_trackings');
    }
};
