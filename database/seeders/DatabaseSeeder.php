<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Story;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        # HLD: Melhorar  
        $users = User::factory(10)->create();
        $categories = Category::factory(10)->create();
        Story::factory(10)->recycle($users)->create();

        $stories = Story::all();
        foreach ($stories as $story) {
            $story->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        }

        $this->call([
            CategorySeeder::class,
            PartnerSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
