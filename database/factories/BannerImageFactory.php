<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BannerImage>
 */
class BannerImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $banners = Banner::all()->pluck('id')->toArray();
        return [
            'banner_id' => $this->faker->randomElement($banners),
            'url' => $this->faker->imageUrl(1000, 450),
        ];
    }
}
