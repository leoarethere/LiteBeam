<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('broadcasts', function (Blueprint $table) {
            // 1. Hapus foreign key lama yang ke tabel 'categories'
            $table->dropForeign(['category_id']);
            
            // 2. Ganti nama kolomnya
            $table->renameColumn('category_id', 'broadcast_category_id');

            // 3. Buat foreign key baru ke tabel 'broadcast_categories'
            $table->foreign('broadcast_category_id')
                ->references('id')
                ->on('broadcast_categories')
                // SEBELUM: ->onDelete('cascade');
                ->onDelete('restrict'); // SESUDAH: Ubah ke restrict
        });
    }

    public function down(): void
    {
        Schema::table('broadcasts', function (Blueprint $table) {
            // Logika rollback (kebalikan dari 'up')
            $table->dropForeign(['broadcast_category_id']);
            $table->renameColumn('broadcast_category_id', 'category_id');
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }
};