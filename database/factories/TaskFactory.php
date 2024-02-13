<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(30),
            'description' => $this->faker->text,
            'user_id' => User::all()->random(1)->first()->id,
            'category_id' => Category::all()->random(1)->first()->id,
            'due_date' => $this->faker->dateTimeBetween('now', '+7 days'),
            'status' => $this->faker->randomElement(['complete', 'processing', 'pending']),
            'priority' => $this->faker->boolean,
            'creation_date' => now(),
            'update_date' => now(),
        ];
    }
}
