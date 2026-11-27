<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Place;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        User::factory()->admin()->create([
            'name' => 'Admin 2',
            'email' => 'admin@admin.com',
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => false,
        ]);
        User::factory(5)->create();

        Category::factory()->create(['name' => 'Food']);
        Category::factory()->create(['name' => 'Nature']);
        Category::factory()->create(['name' => 'Culture']);
        Category::factory()->create(['name' => 'Stay']);
        Category::factory()->create(['name' => 'Transport']);
        Category::factory()->create(['name' => 'Nightlife']);
        Category::factory()->create(['name' => 'Shopping']);
        Category::factory()->create(['name' => 'Other']);

        Trip::factory(15)->create();
        $places = Place::factory(30)->create();

        // full paths of the seed photos, sorted by name: place-01.jpg, place-02.jpg, ...
        $photos = glob(storage_path('seedings/places/*.jpg'));

        foreach ($places as $index => $place) {
            $subset = Category::inRandomOrder()->take(rand(0, 3))->pluck('id')->toArray();
            $place->categories()->attach($subset);

            // photo N belongs to place N (same order as in PlaceFactory); % starts again at the first photo if there are fewer photos
            if (count($photos) > 0) {
                $place->addMedia($photos[$index % count($photos)])
                    ->preservingOriginal() // copy the file, keep the original in storage/seedings
                    ->toMediaCollection('photos');
            }
        }

        Comment::factory(105)->create();
        Comment::factory(15)->unapproved()->create();
    }
}
