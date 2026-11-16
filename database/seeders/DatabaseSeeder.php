<?php

namespace Database\Seeders;

use App\Models\Category;
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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
