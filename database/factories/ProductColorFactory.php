<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductColor>
 */
class ProductColorFactory extends Factory
{
    protected $model = ProductColor::class;
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'color' => $this->faker->colorName(),
        ];
    }
}
