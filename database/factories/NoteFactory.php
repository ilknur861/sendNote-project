<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'id'=> Str::uuid()->toString(),
            'user_id'=>User::factory(),
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'recipient' => $this->faker->email(),
            'send_date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'is_published' => $this->faker->boolean(),
            'heart_count' => $this->faker->randomDigit(),
        ];
    }
}
