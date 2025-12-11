<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\JadwalSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PageDataSeeder;
use Database\Seeders\BroadcastSeeder;
use Database\Seeders\FixedDataSeeder;
use Database\Seeders\ContactInfoSeeder;
use Database\Seeders\BroadcastCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. User & Kategori (Pondasi Utama)
        $this->call([
            UserSeeder::class,              // User harus ada sebelum Post/Broadcast
            CategorySeeder::class,          // Kategori Berita/Post
            BroadcastCategorySeeder::class, // Kategori Siaran (Wajib sebelum Jadwal & Broadcast)
        ]);

        // 2. Data Referensi/Jadwal (Butuh BroadcastCategory)
        $this->call([
            JadwalSeeder::class,            // Mengisi Jadwal Kategori & Jadwal Acara
            FixedDataSeeder::class,         // Visi Misi, Sosmed, Tugas Fungsi, Hymne
        ]);

        // 3. Data Transaksional/Konten (Butuh User & Kategori)
        $this->call([
            PostSeeder::class,              // Berita/Artikel
            BroadcastSeeder::class,         // Program Siaran
            PageDataSeeder::class,          // Data Halaman (History, Prestasi, Banner, dll)
            ContactInfoSeeder::class,       // Informasi Kontak
        ]);
    }
}