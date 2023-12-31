<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(20),
            'startingDate' => now()->addDays(rand(1, 10)),
            'endingDate' => now()->addDays(rand(11, 20)),
            'price' => fake()->randomFloat(2, 1000, 2999),
        ];
    }
}
