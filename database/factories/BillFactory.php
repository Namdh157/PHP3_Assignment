<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\BillStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bill>
 */
class BillFactory extends Factory
{
    protected $model = Bill::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'total_discount' => $this->faker->randomFloat(2, 10, 100),
            'total_price' => $this->faker->randomFloat(2, 20, 200),
        ];
    }
}
