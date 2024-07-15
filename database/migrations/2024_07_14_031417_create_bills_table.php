<?php

use App\Models\Bill;
use App\Models\User;
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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->enum( 'payment_method' ,[Bill::METHOD_TRANSFER, Bill::METHOD_COD])->default(Bill::METHOD_COD)->comment('Phương thức thanh toán');
            $table->enum('status', [BILL::PENDING, BILL::CONFIRMED, BILL::SHIPPING, BILL::SUCCESS, BILL::CANCEL])->default(BILL::PENDING)->comment('Trạng thái hóa đơn');
            $table->integer('quantity')->comment('Số lượng hàng có trong hóa đơn');
            $table->decimal('total_discount')->comment('Số tiền được áp dụng giảm giá');
            $table->decimal('total_price')->comment('Tổng giá trị hóa đơn sau khi áp giảm giá');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
