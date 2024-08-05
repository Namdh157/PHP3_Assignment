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
        $users = User::all()->pluck('id')->toArray();
        $vouchers = Voucher::all()->pluck('id')->toArray();
        $bills = Bill::all()->pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'voucher_id' => $this->faker->randomElement($vouchers),
            'bill_id' => $this->faker->randomElement($bills),
        ];
    }
}
