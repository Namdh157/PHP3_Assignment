<?php

namespace Database\Factories;

use App\Models\Bill;
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
            'customer_id' => $this->faker->numberBetween(1, 10),
            'customer_name' => $this->faker->name,
            'customer_phone' => $this->faker->phoneNumber,
            'customer_email' => $this->faker->email,
            'customer_address' => $this->faker->address,
            'quantity' => $this->faker->numberBetween(1, 5),
            'total_discount' => $this->faker->randomFloat(2, 10, 100),
            'total_price' => $this->faker->randomFloat(2, 20, 200),
            'status' => $this->faker->randomElement(Bill::STATUS),
            'payment_method' => $this->faker->randomElement(Bill::PAYMENT_METHOD),
        ];
    }
}
