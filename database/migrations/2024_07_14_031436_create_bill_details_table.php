<?php

use App\Models\Bill;
use App\Models\Product;
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
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Bill::class)->constrained()->onDelete('cascade');
            $table->string('product_id');
            $table->string('product_name');
            $table->string('product_size');
            $table->string('product_color');
            $table->string('product_image_thumbnail');
            $table->decimal('unit_price')->comment('Giá sản phẩm tại thời điểm mua');
            $table->integer('quantity')->comment('Số lượng sản phẩm trong hóa đơn');         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_details');
    }
};
