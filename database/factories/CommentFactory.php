<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $user_id = $user->first()->id;
        $post_id = Post::inRandomOrder()->first()->id;
        return [
            'user_id' => $user_id,
            'commentable_type' => 'App\Models\Post',
            'commentable_id' => $post_id,
            'comment' => fake()->sentence(),
        ];
    }
}
