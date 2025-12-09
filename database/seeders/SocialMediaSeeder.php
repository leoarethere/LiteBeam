<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Dummy tapi terlihat Asli (Bisa kamu ganti dengan data real TVRI)
        SocialMedia::updateOrCreate(
            ['id' => 1], // Cek apakah ID 1 ada? Jika ada update, jika tidak create.
            [
                'email'     => 'humas@tvri.go.id',
                'phone'     => '(0274) 514402',
                'instagram' => 'https://www.instagram.com/tvriyogyakarta',
                'twitter'   => 'https://twitter.com/tvriyogyakarta',
                'facebook'  => 'https://www.facebook.com/TVRIJogja',
                'tiktok'    => 'https://www.tiktok.com/@tvriyogyakarta',
                'youtube'   => 'https://www.youtube.com/c/TVRIYogyakarta',
            ]
        );
    }
}