<?php

namespace Database\Factories;

use App\Enums\BlogCategoryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
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
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(15, true),
            'author'=>'$this->faker->name()',
            'categories'=>$this->faker->randomElement(BlogCategoryEnum::options()),
            'likes'=>$this->faker->randomDigit(),
            'photo'=>$this->faker->imageUrl(),
            'posted'=>$this->faker->boolean(),
        ];
    }
}
