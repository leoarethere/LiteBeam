<?php

namespace Database\Factories;

use App\Models\JadwalCategory;
use App\Models\BroadcastCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalAcaraFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->time('H:i');
        // Hack sederhana untuk end_time 1 jam setelah start
        $end = date('H:i', strtotime($start) + 3600);

        return [
            'title' => $this->faker->sentence(2),
            'slug' => $this->faker->unique()->slug(),
            'start_time' => $start,
            'end_time' => $end,
            'broadcast_category_id' => BroadcastCategory::inRandomOrder()->first()->id ?? BroadcastCategory::factory(),
            'jadwal_category_id' => JadwalCategory::inRandomOrder()->first()->id ?? JadwalCategory::factory(),
            'is_active' => true,
        ];
    }
}