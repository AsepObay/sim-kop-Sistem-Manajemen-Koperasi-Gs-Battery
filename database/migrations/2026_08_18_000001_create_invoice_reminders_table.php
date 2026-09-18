<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_reminders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tagihan_id');
            $table->enum('jenis_tagihan', ['PO', 'NON_PO']);
            $table->timestamp('last_reminded_at')->nullable();
            $table->timestamps();

            $table->unique(['tagihan_id', 'jenis_tagihan'], 'invoice_reminders_tagihan_unique');
            $table->index(['jenis_tagihan', 'last_reminded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_reminders');
    }
};
