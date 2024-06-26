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
            'title' => $this->faker->word(3),
            'subtitle' => $this->faker->sentence,
            'summary' => $this->faker->paragraph,
            'image' => '/img/hero1.jpg',
            'date' => $this->faker->date(),
            'user_id' => User::factory(),
        ];        

    }
}
