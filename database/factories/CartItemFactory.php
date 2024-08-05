<?php

namespace Database\Factories;

use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition()
    {
        $users = User::all()->pluck('id')->toArray();
        $productVariants = ProductVariant::all()->pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'product_variant_id' => $this->faker->randomElement($productVariants),
            'quantity' => $this->faker->numberBetween(1, 5),
            // 'price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
