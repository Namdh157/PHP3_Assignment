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
            $table->foreignIdFor(Product::class)->constrained();
            $table->integer('quantity')->comment('Số lượng sản phẩm trong hóa đơn');
            $table->decimal('unit_price', 10, 2)->comment('Giá sản phẩm tại thời điểm mua');
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
