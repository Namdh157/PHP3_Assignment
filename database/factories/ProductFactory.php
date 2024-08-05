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
        $catalogues = Catalogue::all()->pluck('id')->toArray();
        $brands = Brand::all()->pluck('id')->toArray();
        return [
            'catalogue_id' => $this->faker->randomElement($catalogues),
            'brand_id' => $this->faker->randomElement($brands),
            'name' => $this->faker->name(), 
            'slug' => $this->generateSlug(),
            'sku' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
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
