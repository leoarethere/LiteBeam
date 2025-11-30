<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('broadcasts', function (Blueprint $table) {
            // Menambahkan kolom is_active setelah kolom status
            // Default true artinya saat dibuat dianggap sedang produksi
            $table->boolean('is_active')->default(true)->after('status')->comment('1=Sedang Produksi, 0=Selesai');
        });
    }

    public function down(): void
    {
        Schema::table('broadcasts', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};