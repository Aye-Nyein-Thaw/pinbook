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
     * Realistic English trips: title, destination and description.
     *
     * @var array<int, array{title: string, destination: string, description: string}>
     */
    private const TRIPS = [
        ['title' => 'Three days in Lisbon', 'destination' => 'Lisbon, Portugal', 'description' => "We spent three slow days climbing the hills of Lisbon, riding the old yellow trams and eating custard tarts at every corner.\n\nThe evenings were for fado music in small bars, and the sunsets over the river were the best part of the whole trip."],
        ['title' => 'Cherry blossoms in Kyoto', 'destination' => 'Kyoto, Japan', 'description' => "We planned the whole trip around the cherry blossom season, and it was worth it. The temples, the quiet streets and the pink petals everywhere felt like a dream.\n\nTip: get up early, the famous places are almost empty before eight o'clock."],
        ['title' => 'A week on the Amalfi Coast', 'destination' => 'Amalfi, Italy', 'description' => "A week of steep stairs, lemon trees and the bluest sea we have ever seen. We moved from village to village by ferry, which is much more relaxing than the winding road.\n\nWe ate pasta with fresh seafood almost every day."],
        ['title' => 'Road trip through Iceland', 'destination' => 'Reykjavik, Iceland', 'description' => "Ten days in a small camper van around the ring road: waterfalls, black beaches, geysers and hot springs. The weather changed every hour, so we learned to always carry a rain jacket.\n\nDriving into the empty highlands was unforgettable."],
        ['title' => 'Street food in Bangkok', 'destination' => 'Bangkok, Thailand', 'description' => "Our goal was simple: eat as much as possible. Noodle soup for breakfast, mango sticky rice in the afternoon and grilled skewers at the night market.\n\nBetween meals we visited temples and took the river boat to avoid the traffic."],
        ['title' => 'Hiking in the Dolomites', 'destination' => "Cortina d'Ampezzo, Italy", 'description' => "Five days of hiking from mountain hut to mountain hut. The jagged peaks turn pink at sunset, and every hut served a hot dinner and a cold beer.\n\nThe views from the high passes made every tired step worth it."],
        ['title' => 'Weekend in Prague', 'destination' => 'Prague, Czechia', 'description' => "A short city break in a city that looks like a fairy tale. We walked across the old bridge at sunrise, climbed up to the castle and finished every day in a cosy beer hall.\n\nTwo days are enough to see the highlights."],
        ['title' => 'Exploring Marrakech', 'destination' => 'Marrakech, Morocco', 'description' => "Colours, smells and noise everywhere. We got lost in the souks on purpose, bargained for a lamp and drank a lot of mint tea on rooftop terraces.\n\nThe riad where we stayed was a calm oasis after the busy medina."],
        ['title' => 'Spring in Amsterdam', 'destination' => 'Amsterdam, Netherlands', 'description' => "We rented bikes and followed the canals, past tulip stalls and tiny cafes. The museums were great, but the best moments were simply sitting by the water with a coffee.\n\nBooking tickets in advance saves a lot of waiting."],
        ['title' => 'Wine and sunsets in Santorini', 'destination' => 'Santorini, Greece', 'description' => "White houses on a cliff, blue domes and a deep blue sea. We hiked between villages, tasted local wine on the volcanic soil and watched the sunset from the castle every evening.\n\nGo in early autumn, when the island is quieter."],
        ['title' => 'Temples of Bagan', 'destination' => 'Bagan, Myanmar', 'description' => "Thousands of ancient temples spread over a dry plain. We rented electric bikes, explored a different area every day and climbed an old pagoda to watch the sunrise over the mist.\n\nThe silence in the early morning is something special."],
        ['title' => 'Surfing in Bali', 'destination' => 'Ubud, Indonesia', 'description' => "Two weeks of learning to surf in the morning and relaxing in green rice fields in the afternoon. My first wave lasted three seconds, my last one almost thirty.\n\nThe food, the people and the temples made it even better."],
        ['title' => 'Northern lights in Tromso', 'destination' => 'Tromso, Norway', 'description' => "We came for the northern lights and were lucky on the second night: a green curtain moving across the sky. During the day we went husky sledding and warmed up with hot chocolate.\n\nDress in many layers, it gets really cold."],
        ['title' => 'Island hopping in Croatia', 'destination' => 'Split, Croatia', 'description' => "We took the ferry from island to island, swam in clear bays and walked through old stone towns. The old palace in Split is a city inside a building.\n\nWe ate grilled fish with a view of the harbour every evening."],
        ['title' => 'Balloons over Cappadocia', 'destination' => 'Goreme, Turkey', 'description' => "At dawn, hundreds of colourful balloons rose over the strange rock valleys. We slept in a hotel carved into the rock and hiked through valleys with hidden churches.\n\nBooking the balloon flight a few days ahead is a good idea in case of bad weather."],
    ];

    private static int $next = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // go through the list one by one, so that the seeded trips have different titles
        $trip = self::TRIPS[self::$next % count(self::TRIPS)];
        self::$next++;

        // a random date between last 2 years and last month
        $startDate = $this->faker->dateTimeBetween('-2 years', '-1 month');

        return [
            'user_id' => $this->faker->numberBetween(1, 8),
            'title' => $trip['title'],
            'description' => $trip['description'],
            'destination' => $trip['destination'],
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween($startDate, '+2 weeks')->format('Y-m-d'),
            'is_public' => $this->faker->boolean(80), // 80% of all trips
        ];
    }
}
