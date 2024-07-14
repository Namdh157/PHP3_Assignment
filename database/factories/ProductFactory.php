<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            'catalogue_id' => Catalogue::factory(),
            'brand_id' => Brand::factory(),
            'slug' => $this->generateSlug(),
            'sku' => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'image_thumbnail' => 'https://picsum.photos/640/480',
            'description' => $this->faker->sentence(),
            'content' => $this->faker->text(),
        ];
    }
    protected function generateSlug(): string
    {
        return Str::slug($this->faker->sentence(3)); // Tạo slug từ một câu ngắn
    }
}
