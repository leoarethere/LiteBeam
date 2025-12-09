<?php

namespace Database\Seeders;

use App\Models\JadwalAcara;
use Illuminate\Support\Str;
use App\Models\JadwalCategory;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kategori Jadwal (Hari)
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        foreach ($days as $index => $day) {
            $cat = JadwalCategory::firstOrCreate(
                ['slug' => Str::slug($day)],
                [
                    'name' => $day, 
                    'order' => $index + 1,
                    'color' => 'blue'
                ]
            );

            // 2. Buat Dummy Acara untuk setiap hari
            JadwalAcara::factory(3)->create([
                'jadwal_category_id' => $cat->id
            ]);
        }
    }
}