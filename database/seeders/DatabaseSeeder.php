<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Person;
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

        $this->call([
            CategorySeeder::class,
            StorySeeder::class,
            PartnerSeeder::class,
            PersonSeeder::class,
            ProductSeeder::class,
            NeedSeeder::class,
            DonationSeeder::class,
            EventSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'David Freitas',
            'email' => 'dvdfreitas@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // geral@narotadospovos.org
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'geral@narotadospovos.org',
            'password' => bcrypt('bazar2026'),
        ]);
    }
}
