<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Banner;
use App\Models\BannerImage;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Catalogue;
use App\Models\CheckVoucher;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Color;
use App\Models\ProductGallery;
use App\Models\Size;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Catalogue::factory(10)->create();
        Brand::factory(10)->create();
        Product::factory(100)->create();
        ProductGallery::factory(100)->create();
        Size::factory(10)->create();
        Color::factory(10)->create();
        ProductVariant::factory(50)->create();
        Comment::factory(10)->create();
        CartItem::factory(20)->create();
        Bill::factory(10)->create();
        BillDetail::factory(10)->create();
        Voucher::factory(20)->create();
        CheckVoucher::factory(20)->create();
        Banner::factory(3)->create();
        BannerImage::factory(10)->create();
    }
}
