<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\CheckVoucher;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CheckVoucher>
 */
class CheckVoucherFactory extends Factory
{
    protected $model = CheckVoucher::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'voucher_id' => Voucher::factory(),
            'bill_id' => Bill::factory(),
        ];
    }
}
