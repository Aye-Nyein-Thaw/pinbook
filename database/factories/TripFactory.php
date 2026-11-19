<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // a random date between last 2 years and last month
        $startDate = $this->faker->dateTimeBetween('-2 years', '-1 month');

        return [
            'user_id' => $this->faker->numberBetween(1, 7),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs(3, true),
            'destination' => $this->faker->city(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween($startDate, '+2 weeks')->format('Y-m-d'),
            'is_public' => $this->faker->boolean(80), // 80% of all trips
        ];
    }
}
