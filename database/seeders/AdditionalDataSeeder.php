<?php

namespace Database\Seeders;

use App\Models\BroadcastCategory;
use App\Models\InfoMagang;
use App\Models\JadwalAcara;
use App\Models\JadwalCategory;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdditionalDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // --- 1. Info Magang ---
        for ($i = 1; $i <= 3; $i++) {
            $randomString = Str::random(5);
            InfoMagang::create([
                'title' => 'Program Magang TVRI '.$randomString,
                'slug' => 'program-magang-tvri-'.$randomString,
                'description' => '<p>'.implode('</p><p>', $faker->paragraphs(2)).'</p>',
                'source_link' => 'https://tvriyogyakarta.co.id/magang',
                'is_active' => true,
            ]);
        }

        // --- 2. Jadwal Kategori (Hari) ---
        $days = [
            ['name' => 'Senin', 'order' => 1, 'color' => 'blue'],
            ['name' => 'Selasa', 'order' => 2, 'color' => 'green'],
            ['name' => 'Rabu', 'order' => 3, 'color' => 'yellow'],
            ['name' => 'Kamis', 'order' => 4, 'color' => 'purple'],
            ['name' => 'Jumat', 'order' => 5, 'color' => 'red'],
            ['name' => 'Sabtu', 'order' => 6, 'color' => 'gray'],
            ['name' => 'Minggu', 'order' => 7, 'color' => 'blue'],
        ];

        $jadwalCategories = [];
        foreach ($days as $day) {
            $jadwalCategories[] = JadwalCategory::firstOrCreate(
                ['name' => $day['name']],
                [
                    'slug' => Str::slug($day['name']),
                    'order' => $day['order'],
                    'color' => $day['color'],
                ]
            );
        }

        // --- 3. Jadwal Acara ---
        // Pastikan ada BroadcastCategory
        $broadcastCategory = BroadcastCategory::firstOrCreate(
            ['slug' => 'berita-nasional'],
            ['name' => 'Berita Nasional', 'color' => 'blue']
        );

        foreach ($jadwalCategories as $category) {
            // Buat 2 acara untuk masing-masing hari
            for ($j = 1; $j <= 2; $j++) {
                $randomString = Str::random(5);
                $startHour = rand(6, 18);
                $endHour = $startHour + rand(1, 2);

                JadwalAcara::create([
                    'title' => 'Acara TVRI '.$randomString,
                    'slug' => 'acara-tvri-'.$randomString,
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'broadcast_category_id' => $broadcastCategory->id,
                    'jadwal_category_id' => $category->id,
                    'is_active' => true,
                ]);
            }
        }
    }
}
