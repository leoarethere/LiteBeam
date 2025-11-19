<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mengambil paragraf untuk body dan excerpt
        $body = collect($this->faker->paragraphs(mt_rand(10, 20)))
            ->map(fn($p) => "<p>$p</p>")
            ->implode('');
        
        $excerpt = collect($this->faker->paragraphs(2))
            ->implode(' '); // Gabungkan paragraf hanya dengan spasi

        return [
            'title' => $this->faker->sentence(mt_rand(3, 8)),
            'slug' => $this->faker->unique()->slug(),
            
            // PERBAIKAN: Menggunakan user_id, bukan author_id
            // Mengambil user dan category yang sudah ada secara acak
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            
            'body' => $body,
            'excerpt' => $excerpt,
            
            // Menambahkan kolom baru agar sesuai dengan migrasi
            'featured_image' => null, // Biarkan null, atau atur path gambar default
            'status' => 'published',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'views' => $this->faker->numberBetween(100, 10000),
        ];
    }
}
