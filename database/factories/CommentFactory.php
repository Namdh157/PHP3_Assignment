<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;
    public function definition(): array
    {
        $users = User::all()->pluck('id')->toArray();
        $products = Product::all()->pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'product_id' => $this->faker->randomElement($products),
            'content' => $this->faker->text(),
        ];
    }
}
