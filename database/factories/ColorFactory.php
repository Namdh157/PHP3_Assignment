<?php

namespace Database\Factories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class ColorFactory extends Factory
{
    protected $model = Color::class;
    public function definition(): array
    {
        return [
            'color' => $this->faker->unique()->colorName(),
        ];
    }
}
