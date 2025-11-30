<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppids', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description'); // Trix Editor output HTML
            $table->string('source_link'); // Link Google Drive/Dropbox/Website
            $table->string('cover_image')->nullable(); // Gambar cover (opsional)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppids');
    }
};