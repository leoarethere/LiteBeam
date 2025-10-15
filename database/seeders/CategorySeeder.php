<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Web Programming',
            'slug' => 'web-programming',
            'color' => 'red'
        ]);
        Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design',
            'color' => 'blue'
        ]);
        Category::create([
            'name' => 'Personal',
            'slug' => 'personal',
            'color' => 'green'
        ]);
        Category::create([
            'name' => 'Travel',
            'slug' => 'travel',
            'color' => 'yellow'
        ]);
    }
}
