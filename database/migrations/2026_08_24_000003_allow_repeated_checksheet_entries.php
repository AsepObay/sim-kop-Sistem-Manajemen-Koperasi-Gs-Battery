<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checksheet_masters', function ($table) {
            $table->dropUnique(['category', 'name']);
        });
    }

    public function down(): void
    {
        Schema::table('checksheet_masters', function ($table) {
            $table->unique(['category', 'name']);
        });
    }
};
