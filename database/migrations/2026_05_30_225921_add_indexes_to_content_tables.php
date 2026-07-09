<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
            $table->index('views');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
            $table->index('views');
        });

        Schema::table('broadcasts', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex('views');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex('views');
        });

        Schema::table('broadcasts', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
        });
    }
};
