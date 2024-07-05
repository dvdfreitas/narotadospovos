<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(10, true),
            'subtitle' => $this->faker->sentence(20),
            'summary' => $this->faker->paragraph(40),
            'image' => '/img/hero1.jpg',
            'date' => $this->faker->dateTimeThisMonth(),
            'user_id' => User::factory()
        ];
    }
}
