<?php

namespace Database\Factories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    protected $model = Size::class;
    public function definition(): array
    {
        return [
            'size' => $this->faker->unique()->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
        ];
    }
}
