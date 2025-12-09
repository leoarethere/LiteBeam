<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PrestasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Juara ' . $this->faker->numberBetween(1, 3) . ' Lomba ' . $this->faker->word(),
            'award_name' => 'Piala ' . $this->faker->word(),
            'type' => $this->faker->randomElement(['Emas', 'Perak', 'Perunggu', 'Juara 1']),
            'category' => $this->faker->randomElement(['Nasional', 'Internasional', 'Regional']),
            'year' => $this->faker->year(),
            'description' => $this->faker->paragraph(),
            'image' => null, 
            'is_active' => true,
        ];
    }
}