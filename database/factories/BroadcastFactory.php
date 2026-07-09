<?php

namespace Database\Factories;

use App\Models\Broadcast;
use App\Models\BroadcastCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BroadcastFactory extends Factory
{
    protected $model = Broadcast::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'user_id' => User::factory(),
            'broadcast_category_id' => BroadcastCategory::factory(),
            'synopsis' => fake()->paragraph(),
            'youtube_link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'status' => 'published',
            'published_at' => now(),
        ];
    }
}
