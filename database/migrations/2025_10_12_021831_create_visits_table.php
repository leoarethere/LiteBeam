<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // PASTIKAN DI SINI TERTULIS 'visits' (Bukan 'visitors')
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('method')->nullable();
            $table->mediumText('request')->nullable();
            $table->mediumText('url')->nullable();
            $table->mediumText('referer')->nullable();
            $table->text('languages')->nullable();
            $table->text('useragent')->nullable();
            $table->text('headers')->nullable();
            $table->text('device')->nullable();
            $table->text('platform')->nullable();
            $table->text('browser')->nullable();
            $table->string('ip')->nullable();
            $table->nullableMorphs('visitor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Pastikan ini juga 'visits'
        Schema::dropIfExists('visits');
    }
};