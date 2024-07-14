<?php

use App\Models\BillStatus;
use App\Models\PaymentMethod;
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
            $table->foreignIdFor(BillStatus::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(PaymentMethod::class)->constrained();
            $table->json('item');
            $table->integer('quantity')->comment('Số lượng hàng có trong hóa đơn');
            $table->double('total_discount')->comment('Số tiền được áp dụng giảm giá');
            $table->double('total_price')->comment('Tổng giá trị hóa đơn sau khi áp giảm giá');
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
