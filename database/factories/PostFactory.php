<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();
        $category_id = $category->id;

        return [
            'thumbnail' => fake()->image,
            'title' => fake()->word(1),
            'color' => fake()->hexColor,
            'slug' => fake()->slug,
            'category_id' => $category_id,
            'content' => fake()->text,
            'tags' => fake()->word(1) . ',' . fake()->word(1),
            'published' => true,
        ];
    }
}
