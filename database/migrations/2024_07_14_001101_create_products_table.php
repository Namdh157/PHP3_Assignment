<?php

use App\Models\Brand;
use App\Models\Catalogue;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Catalogue::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Brand::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique()->comment('Đường dẫn thân thiện'); 
            $table->string('sku', 10)->unique()->comment('Mã sản phẩm');
            $table->string('image_thumbnail');
            $table->string('description')->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('sell_count')->default(0);
            $table->unsignedBigInteger('view')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
