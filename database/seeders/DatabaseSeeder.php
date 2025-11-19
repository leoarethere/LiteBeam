<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Hapus seeder individual yang tidak perlu lagi dipanggil di sini.
        // $this->call([CategorySeeder::class, UserSeeder::class]);

        // 2. Buat Kategori terlebih dahulu.
        // Kita bisa langsung membuatnya di sini atau memanggil factory.
        Category::factory()->create(['name' => 'Web Programming', 'slug' => 'web-programming', 'color' => 'red']);
        Category::factory()->create(['name' => 'Web Design', 'slug' => 'web-design', 'color' => 'blue']);
        Category::factory()->create(['name' => 'Personal', 'slug' => 'personal', 'color' => 'green']);
        Category::factory()->create(['name' => 'Travel', 'slug' => 'travel', 'color' => 'yellow']);
        
        // 3. Buat User terlebih dahulu, termasuk admin.
        User::factory()->create([
            'name' => 'Beam Admin',
            'username' => 'litebeam',
            'email' => 'litebeam@gmail.com',
        ]);
        User::factory(5)->create(); // Buat 5 user tambahan.

        // 4. Setelah User dan Category PASTI ada, baru buat Post.
        // Metode recycle() sekarang akan selalu menemukan data yang valid.
        Post::factory(100)->recycle([
            Category::all(),
            User::all()
        ])->create();
    }
}