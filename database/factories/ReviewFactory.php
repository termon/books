<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->name(),
            'rating'      => $this->faker->numberBetween(0, 5),
            'comment'     => $this->faker->sentence(),
            'created_at'  => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
