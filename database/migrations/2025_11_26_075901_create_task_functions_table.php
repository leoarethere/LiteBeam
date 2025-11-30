<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_functions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['tugas', 'fungsi']); // Pembeda: Tugas atau Fungsi
            $table->integer('order')->default(0);       // Urutan
            $table->string('image')->nullable();        // Gambar/Ikon
            $table->text('content');                    // Isi Konten
            $table->boolean('is_active')->default(true);// Status Aktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_functions');
    }
};