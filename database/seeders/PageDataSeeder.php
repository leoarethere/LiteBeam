<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\History;
use App\Models\Prestasi;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Banner Slider
        Banner::factory(3)->create();

        // 2. Prestasi
        Prestasi::factory(5)->create();

        // 3. Sejarah (History)
        History::create([
            'title' => 'Era Kelahiran (1962)',
            'content' => 'TVRI mengudara pertama kali pada perhelatan Asian Games IV.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        // 4. Info Magang (Manual Insert karena simpel)
        DB::table('info_magangs')->insert([
            'title' => 'Penerimaan Magang 2025',
            'slug' => 'penerimaan-magang-2025',
            'description' => 'Menerima mahasiswa jurusan DKV dan Jurnalistik.',
            'source_link' => 'https://drive.google.com/file/d/xxxx',
            'is_active' => true,
            'created_at' => now(),
        ]);

        // 5. PPID (Manual Insert)
        DB::table('ppids')->insert([
            'title' => 'Struktur Organisasi PPID',
            'description' => 'Berikut adalah bagan struktur organisasi...',
            'source_link' => '#',
            'is_active' => true,
            'created_at' => now(),
        ]);
        
        // 6. Info Kunjungan
         DB::table('info_kunjungans')->insert([
            'title' => 'Prosedur Kunjungan Studi',
            'slug' => 'prosedur-kunjungan-studi',
            'description' => 'Sekolah yang ingin berkunjung harap mengirim surat...',
            'source_link' => '#',
            'is_active' => true,
            'created_at' => now(),
        ]);
    }
}