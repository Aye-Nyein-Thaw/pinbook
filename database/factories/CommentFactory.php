<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Realistic English comments.
     *
     * @var array<int, string>
     */
    private const COMMENTS = [
        'Great photos! This is now on my list.',
        'I was there two years ago and loved it too. Thanks for the memories!',
        'Thanks for sharing. How many days would you recommend?',
        'Beautiful place. Did you need to book anything in advance?',
        'I would love to go there next spring. Any tips for the weather?',
        'What a lovely story, it made me smile.',
        'Did you find the food expensive? We are travelling on a small budget.',
        'This looks amazing! Which month did you go?',
        'Thank you for the honest tips, especially about getting up early.',
        'We are planning almost the same route in the summer. Very useful!',
        'The view from there is unforgettable, I totally agree.',
        'Wow, I did not know this place. Adding it to my wish list.',
        'Great write-up! Was it easy to get around without a car?',
        'Love the details about the small restaurants.',
        'I went last year and had a very similar experience.',
        'Which hotel did you stay in? It looks perfect.',
        'Super helpful, thank you. We will bring a rain jacket!',
        'Such a nice trip. I hope you take more of these.',
        'Can you share the name of the hiking trail?',
        'This place deserves more visitors. Thanks for the inspiration!',
        'Lovely pictures, you have a good eye.',
        'We went in winter and it was almost empty. Highly recommended.',
        'Did you travel alone or with friends?',
        'I laughed at the part about getting lost. Same thing happened to us!',
        'Thanks, I will definitely try this itinerary.',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trip_id' => $this->faker->numberBetween(1, 12),
            'user_id' => $this->faker->numberBetween(1, 8),
            'content' => $this->faker->randomElement(self::COMMENTS),
            'approved_at' => now(),
        ];
    }

    public function unapproved(): static
    {
        return $this->state(fn (array $attributes) => [
            'approved_at' => null,
        ]);
    }
}
