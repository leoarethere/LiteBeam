<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_categories', function (Blueprint $table) {
            // Menambahkan kolom order dengan default 0
            $table->integer('order')->default(0)->after('slug'); 
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_categories', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};