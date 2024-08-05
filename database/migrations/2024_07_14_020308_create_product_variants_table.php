<?php

use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Color::class)->constrained();
            $table->foreignIdFor(Size::class)->constrained();
            $table->double('price_regular');
            $table->double('price_sale');
            $table->unsignedInteger('stock');
            $table->boolean('is_sale')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['product_id', 'color_id', 'size_id'], 'product_variants_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
