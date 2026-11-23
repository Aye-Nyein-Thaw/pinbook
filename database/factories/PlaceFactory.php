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
     * Real places, each in its own trip (trip_id = position in TripFactory::TRIPS), with approximate coordinates and a short story.
     *
     * @var array<int, array{trip_id: int, name: string, latitude: float, longitude: float, story: string}>
     */
    private const PLACES = [
        ['trip_id' => 1, 'name' => 'Belem Tower', 'latitude' => 38.6916, 'longitude' => -9.2160, 'story' => 'A small fortress on the edge of the river. The queue was long, but the view from the top was worth the wait.'],
        ['trip_id' => 1, 'name' => 'Alfama district', 'latitude' => 38.7110, 'longitude' => -9.1301, 'story' => 'A maze of narrow streets with laundry hanging above our heads. We got lost twice and found the best little restaurant of the trip.'],
        ['trip_id' => 2, 'name' => 'Fushimi Inari Shrine', 'latitude' => 34.9671, 'longitude' => 135.7727, 'story' => 'Thousands of red gates that lead up the mountain. We walked all the way to the top early in the morning and had the path almost to ourselves.'],
        ['trip_id' => 2, 'name' => 'Kinkaku-ji, the Golden Pavilion', 'latitude' => 35.0394, 'longitude' => 135.7292, 'story' => 'The golden temple shines even more when it is reflected in the pond. It is busy, but still beautiful.'],
        ['trip_id' => 3, 'name' => 'Positano beach', 'latitude' => 40.6280, 'longitude' => 14.4850, 'story' => 'Colourful houses stacked on the hill above a pebble beach. We rented two chairs and did absolutely nothing for an afternoon.'],
        ['trip_id' => 3, 'name' => 'The Path of the Gods', 'latitude' => 40.6330, 'longitude' => 14.5000, 'story' => 'A hiking trail high above the sea with views all the way to Capri. Bring water, there is almost no shade.'],
        ['trip_id' => 4, 'name' => 'Blue Lagoon', 'latitude' => 63.8804, 'longitude' => -22.4495, 'story' => 'Milky blue warm water in the middle of a black lava field. Perfect after a long flight, but book your ticket early.'],
        ['trip_id' => 4, 'name' => 'Gullfoss waterfall', 'latitude' => 64.3271, 'longitude' => -20.1199, 'story' => 'A huge, powerful waterfall in two steps. We were soaked by the spray and did not mind at all.'],
        ['trip_id' => 5, 'name' => 'Chatuchak Weekend Market', 'latitude' => 13.7999, 'longitude' => 100.5503, 'story' => 'One of the largest markets in the world. We bought far too many souvenirs and drank a coconut ice cream in every corner.'],
        ['trip_id' => 5, 'name' => 'Wat Pho', 'latitude' => 13.7465, 'longitude' => 100.4927, 'story' => 'Home of the giant reclining Buddha. It is calm, shiny and surprisingly big, and the foot massage school next door is great.'],
        ['trip_id' => 6, 'name' => 'Tre Cime di Lavaredo', 'latitude' => 46.6186, 'longitude' => 12.3027, 'story' => 'Three famous rock towers and an easy circular walk around them. We did it in four hours with many photo stops.'],
        ['trip_id' => 7, 'name' => 'Charles Bridge', 'latitude' => 50.0865, 'longitude' => 14.4114, 'story' => 'A stone bridge full of statues and street musicians. Go at sunrise if you want a picture without people.'],
        ['trip_id' => 7, 'name' => 'Prague Castle', 'latitude' => 50.0909, 'longitude' => 14.4005, 'story' => 'A huge castle complex above the river with a beautiful cathedral inside. We spent a whole morning here.'],
        ['trip_id' => 8, 'name' => 'Jemaa el-Fnaa square', 'latitude' => 31.6258, 'longitude' => -7.9891, 'story' => 'The heart of Marrakech. At night the square fills with food stalls, storytellers and music, and the smoke makes it magical.'],
        ['trip_id' => 8, 'name' => 'Majorelle Garden', 'latitude' => 31.6417, 'longitude' => -8.0033, 'story' => 'A garden with cactuses, bamboo and bright blue walls. A quiet escape from the busy medina.'],
        ['trip_id' => 9, 'name' => 'Anne Frank House', 'latitude' => 52.3752, 'longitude' => 4.8840, 'story' => 'A moving visit that stays with you. Tickets must be booked weeks in advance.'],
        ['trip_id' => 9, 'name' => 'Vondelpark', 'latitude' => 52.3579, 'longitude' => 4.8686, 'story' => 'A big green park where everybody seems to have a picnic. We rested here after a long museum day.'],
        ['trip_id' => 10, 'name' => 'Oia sunset point', 'latitude' => 36.4618, 'longitude' => 25.3753, 'story' => 'Everybody gathers here for the sunset. Arrive an hour early to get a good spot on the old castle wall.'],
        ['trip_id' => 10, 'name' => 'Red Beach', 'latitude' => 36.3489, 'longitude' => 25.3957, 'story' => 'A beach with red volcanic cliffs and dark sand. A short but rocky walk from the parking lot.'],
        ['trip_id' => 11, 'name' => 'Ananda Temple', 'latitude' => 21.1717, 'longitude' => 94.8675, 'story' => 'A white and gold temple with four giant standing Buddhas. The light inside in the afternoon is very special.'],
        ['trip_id' => 11, 'name' => 'Shwesandaw Pagoda', 'latitude' => 21.1740, 'longitude' => 94.8606, 'story' => 'A tall pagoda with steps up to a terrace. From the top you can see hundreds of temples in the evening light.'],
        ['trip_id' => 12, 'name' => 'Uluwatu Temple', 'latitude' => -8.8291, 'longitude' => 115.0849, 'story' => 'A temple on a cliff above the ocean. At sunset there is a traditional dance performance, and the monkeys will steal your sunglasses.'],
        ['trip_id' => 12, 'name' => 'Tegallalang rice terraces', 'latitude' => -8.4312, 'longitude' => 115.2793, 'story' => 'Green rice fields that go down the hill like stairs. We walked between the fields and had a fresh coconut at a small cafe.'],
        ['trip_id' => 13, 'name' => 'Arctic Cathedral', 'latitude' => 69.6409, 'longitude' => 18.9560, 'story' => 'A white triangular church in the north of Norway. We went to a candlelit concert in the evening.'],
        ['trip_id' => 14, 'name' => "Diocletian's Palace", 'latitude' => 43.5081, 'longitude' => 16.4402, 'story' => 'An ancient Roman palace that is now the old town of Split. People still live, eat and shop between the old walls.'],
        ['trip_id' => 14, 'name' => 'Krka waterfalls', 'latitude' => 43.8039, 'longitude' => 15.9712, 'story' => 'A national park with waterfalls and wooden walkways. You can swim in some parts in summer.'],
        ['trip_id' => 15, 'name' => 'Goreme Open Air Museum', 'latitude' => 38.6431, 'longitude' => 34.8289, 'story' => 'Rock churches with faded paintings from a thousand years ago. Fascinating and well kept.'],
        ['trip_id' => 15, 'name' => 'Love Valley', 'latitude' => 38.6560, 'longitude' => 34.8350, 'story' => 'A valley full of tall rock formations. We walked through it at sunrise, with balloons floating above.'],
        ['trip_id' => 14, 'name' => 'Old Town harbour', 'latitude' => 43.5086, 'longitude' => 16.4392, 'story' => 'A small harbour with colourful boats and cafes. A perfect place for a slow breakfast with a view.'],
        ['trip_id' => 4, 'name' => 'Hallgrimskirkja church', 'latitude' => 64.1417, 'longitude' => -21.9266, 'story' => 'A striking church with a tower. The ride up the tower gives a great view of the colourful roofs of Reykjavik.'],
    ];

    private static int $next = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // go through the list one by one, so that every place is seeded once
        $place = self::PLACES[self::$next % count(self::PLACES)];
        self::$next++;

        return [
            'trip_id' => $place['trip_id'],
            'name' => $place['name'],
            'story' => $place['story'],
            'latitude' => $place['latitude'],
            'longitude' => $place['longitude'],
            'visited_on' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
        ];
    }
}
