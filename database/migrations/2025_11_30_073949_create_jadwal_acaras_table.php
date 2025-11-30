<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_acaras', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama Acara
            $table->string('slug')->unique();
            $table->time('start_time'); // Pukul Penayangan
            // Relasi ke kategori penyiaran (agar jenis acaranya sama)
            $table->foreignId('broadcast_category_id')->constrained('broadcast_categories')->onDelete('cascade'); 
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_acaras');
    }
};