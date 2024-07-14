<?php

namespace Database\Factories;

use App\Models\BillStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillStatus>
 */
class BillStatusFactory extends Factory
{
    protected $model = BillStatus::class;
    public function definition(): array
    {
        return [
            'status' => $this->faker->word(),
        ];
    }
}
