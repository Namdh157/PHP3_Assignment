<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillDetail>
 */
class BillDetailFactory extends Factory
{
    protected $model = BillDetail::class;
    public function definition(): array
    {
        return [
            'bill_id' => Bill::factory(),
            'product_id' => Product::factory(),
            'product_name' => $this->faker->name(),
            'product_size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'product_color' => $this->faker->randomElement(['Red', 'Green', 'Blue']),
            'product_image_thumbnail' => $this->faker->imageUrl(),
            'unit_price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
