<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Aktifkan UserSeeder untuk membuat user default
        $this->call([
            UserSeeder::class,
            // CategorySeeder::class, // Uncomment jika ada
        ]);
    }
}