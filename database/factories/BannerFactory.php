<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'subtitle' => $this->faker->sentence(6),
            // Gunakan URL placeholder
            'image_path' => 'https://placehold.co/1200x400/000000/FFFFFF/png?text=Banner+TVRI', 
            'link' => '#',
            'button_text' => 'Selengkapnya',
            'order' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}