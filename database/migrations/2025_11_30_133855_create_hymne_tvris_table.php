<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hymne_tvris', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('info')->nullable();
            $table->string('poster')->nullable();
            $table->text('synopsis');
            $table->string('link');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hymne_tvris');
    }
};