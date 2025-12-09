<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\BroadcastCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BroadcastFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'broadcast_category_id' => BroadcastCategory::inRandomOrder()->first()->id ?? BroadcastCategory::factory(),
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(),
            'synopsis' => $this->faker->paragraph(),
            'poster' => null, // Atau 'posters/dummy.jpg'
            'youtube_link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Link dummy
            'status' => $this->faker->randomElement(['published', 'draft']),
            'published_at' => now(),
            'is_active' => true,
        ];
    }
}