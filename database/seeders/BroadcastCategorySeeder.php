<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\BroadcastCategory;

class BroadcastCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Berita TVRI', 'Dokumenter', 'Talkshow', 'Anak-anak', 'Agama'];
        
        foreach ($categories as $cat) {
            BroadcastCategory::firstOrCreate(
                ['slug' => Str::slug($cat)],
                [
                    'name' => $cat,
                    'color' => 'red'
                ]
            );
        }
    }
}