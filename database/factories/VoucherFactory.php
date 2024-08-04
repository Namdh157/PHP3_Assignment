<?php

namespace Database\Factories;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    protected $model = Voucher::class;
    public function definition(): array
    {
        return [
            'code' => str::random(10), 
            'value' => $this->faker->randomFloat(2, 1, 1000), 
            'type' => $this->faker->randomElement(Voucher::TYPE),
            'quantity' => $this->faker->numberBetween(1, 100), 
            'used' => $this->faker->numberBetween(0, 10), 
            'is_active' => $this->faker->boolean(),
            'start_at' => $this->faker->dateTimeBetween('now', '+1 month'), // Thời gian bắt đầu, từ bây giờ đến một tháng sau
            'end_at' => $this->faker->dateTimeBetween('+1 month', '+2 months'), // Thời gian kết thúc, từ một tháng sau đến hai tháng sau
        ];
    }
}
