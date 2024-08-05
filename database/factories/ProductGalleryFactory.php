<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductGallery>
 */
class ProductGalleryFactory extends Factory
{
    protected $model = ProductGallery::class;
    public function definition(): array
    {
        $products = Product::all()->pluck('id')->toArray();
        return [
            'product_id' => $this->faker->randomElement($products),
            'image' => 'https://picsum.photos/640/480',
        ];
    }
}
