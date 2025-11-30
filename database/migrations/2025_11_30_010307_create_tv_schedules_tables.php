<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat Tabel Link Sumber (Untuk menyimpan referensi link streaming/berita)
        Schema::create('link_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Youtube, Vidio, Website Resmi
            $table->string('url');  // Contoh: https://youtube.com/...
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Buat Tabel Jadwal TV
        Schema::create('tv_schedules', function (Blueprint $table) {
            $table->id();
            $table->enum('day', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('time'); // Jam Tayang (Format 00:00:00)
            $table->string('program_name'); // Nama Acara
            
            // Relasi ke tabel link_sources (Boleh kosong/null jika tidak ada link)
            $table->foreignId('link_source_id')
                  ->nullable()
                  ->constrained('link_sources')
                  ->nullOnDelete(); 
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel jadwal dulu karena dia punya ketergantungan ke link_sources
        Schema::dropIfExists('tv_schedules');
        Schema::dropIfExists('link_sources');
    }
};