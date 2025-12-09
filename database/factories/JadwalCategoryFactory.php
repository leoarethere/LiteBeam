<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->dayOfWeek(); 
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'color' => 'blue',
            'order' => $this->faker->numberBetween(1, 7),
        ];
    }
}