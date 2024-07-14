<?php

namespace Database\Factories;

use App\Models\Catalogue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalogue>
 */
class CatalogueFactory extends Factory
{
    protected $model = Catalogue::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
