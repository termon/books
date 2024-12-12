<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucwords($this->faker->words($this->faker->numberBetween(3, 8), true)),
            'year' => $this->faker->numberBetween(2010, 2023),
            'rating' => $this->faker->randomFloat(1, 0, 5),
            'description' => ucwords($this->faker->sentences($this->faker->numberBetween(1, 5), true)),
            'category_id' => Category::factory()->create()->id,
            'image' =>  null
        ];
    }
}
