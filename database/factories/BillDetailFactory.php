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
            'quantity' => $this->faker->numberBetween(1, 10),
            'unit_price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
