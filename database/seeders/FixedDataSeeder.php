<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixedDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Visi Misi
        DB::table('visi_misis')->insert([
            ['type' => 'visi', 'content' => 'Menjadi Lembaga Penyiaran Kelas Dunia.', 'order' => 1, 'is_active' => true],
            ['type' => 'misi', 'content' => 'Menyajikan informasi terpercaya.', 'order' => 1, 'is_active' => true],
            ['type' => 'misi', 'content' => 'Melestarikan budaya bangsa.', 'order' => 2, 'is_active' => true],
        ]);

        // 2. Tugas & Fungsi
        DB::table('tugas_fungsis')->insert([
            ['type' => 'tugas', 'content' => 'Memberikan pelayanan informasi.', 'order' => 1, 'is_active' => true],
            ['type' => 'fungsi', 'content' => 'Pelaksanaan produksi siaran.', 'order' => 1, 'is_active' => true],
        ]);

        // 3. Social Media (Single Row)
        DB::table('social_medias')->insert([
            [
                'email' => 'info@tvri.go.id',
                'instagram' => 'https://instagram.com/tvri',
                'twitter' => 'https://x.com/tvri',
                'facebook' => 'https://facebook.com/tvri',
                'youtube' => 'https://youtube.com/tvri',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 4. Hymne
        DB::table('hymne_tvris')->insert([
            [
                'title' => 'Hymne TVRI',
                'info' => 'Ciptaan: R. Soetedjo',
                'synopsis' => 'Lagu kebanggaan Televisi Republik Indonesia.',
                'link' => 'https://youtube.com/...',
                'is_active' => true,
                'created_at' => now(),
            ]
        ]);
    }
}