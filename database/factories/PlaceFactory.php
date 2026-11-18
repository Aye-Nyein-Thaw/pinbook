<?php

namespace Database\Factories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Place>
 */
class PlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trip_id' => $this->faker->numberBetween(1, 15),
            'name' => $this->faker->words(3, true),
            'story' => $this->faker->paragraphs(2, true),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'visited_on' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
        ];
    }
}
