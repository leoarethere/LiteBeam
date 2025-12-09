<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialMedia>
 */
class SocialMediaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email'     => fake()->companyEmail(),
            'phone'     => fake()->phoneNumber(),
            'instagram' => 'https://instagram.com/' . fake()->userName(),
            'twitter'   => 'https://x.com/' . fake()->userName(), // X / Twitter
            'facebook'  => 'https://facebook.com/' . fake()->userName(),
            'tiktok'    => 'https://tiktok.com/@' . fake()->userName(),
            'youtube'   => 'https://youtube.com/@' . fake()->userName(),
        ];
    }
}