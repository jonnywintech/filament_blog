<?php

namespace Database\Factories;

use App\Models\Tag;
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
        $tag = Tag::inRandomOrder()->first();
        $tag_id = $tag->id;
        $tag_title = $tag->title;

        return [
            'thumbnail' => fake()->image,
            'title' => fake()->title,
            'color' => fake()->hexColor,
            'slug' => fake()->slug,
            'tag_id' => $tag_id,
            'content' => fake()->text,
            'tags' => ['id' => rand(1,10), 'title' => fake()->title],
            'published' => true,
        ];
    }
}
