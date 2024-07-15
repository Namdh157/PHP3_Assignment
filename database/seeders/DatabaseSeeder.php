<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Catalogue;
use App\Models\CheckVoucher;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductSize;
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
        Product::factory(10)->create();
        ProductGallery::factory(10)->create();
        ProductSize::factory(10)->create();
        ProductColor::factory(10)->create();
        ProductVariant::factory(10)->create();
        Comment::factory(10)->create();
        CartItem::factory(10)->create();
        Bill::factory(10)->create();
        BillDetail::factory(10)->create();
        Voucher::factory(10)->create();
        CheckVoucher::factory(10)->create();

    }
}
