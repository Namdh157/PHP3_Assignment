<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition()
    {
        // Chuẩn bị tập hợp giá trị hợp lệ
        $products = Product::all()->pluck('id')->toArray();
        $productColors = ProductColor::all()->pluck('id')->toArray();
        $productSizes = ProductSize::all()->pluck('id')->toArray();

        return [
            'product_id' => $this->faker->randomElement($products),
            'product_color_id' => $this->faker->randomElement($productColors),
            'product_size_id' => $this->faker->randomElement($productSizes),
            'price_regular' => $this->faker->randomFloat(2, 10, 100),
            'price_sale' => $this->faker->optional()->randomFloat(2, 5, 90),
            'stock' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(true),
        ];
    }
}
