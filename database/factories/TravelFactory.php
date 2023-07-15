<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(15),
            'slug' => fake()->slug(15),
            'isPublic' => fake()->boolean(),
            'description' => fake()->text(100),
            'numberOfDays' => rand(1, 14),
            'nature' => rand(1, 10) * 10,
            'relax' => rand(1, 10) * 10,
            'history' => rand(1, 10) * 10,
            'culture' => rand(1, 10) * 10,
            'party' => rand(1, 10) * 10,
        ];
    }
}
