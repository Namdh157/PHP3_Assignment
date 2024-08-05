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
            // $table->foreignIdFor(User::class)->constrained();

            $table->bigInteger('customer_id')->unsigned()->comment('ID khách hàng');
            $table->string('customer_name')->comment('Tên khách hàng');
            $table->string('customer_phone')->comment('Số điện thoại khách hàng');
            $table->string('customer_email')->comment('Email khách hàng');
            $table->string('customer_address')->comment('Địa chỉ khách hàng');
            $table->string('customer_note')->default('');
            $table->enum('payment_method', array_keys(Bill::PAYMENT_METHOD))->default(array_keys(Bill::PAYMENT_METHOD)[0])->comment('Phương thức thanh toán');
            $table->enum('status', array_keys(BILL::STATUS))->default(array_keys(BILL::STATUS)[0])->comment('Trạng thái hóa đơn');
            $table->boolean('is_paid')->default(false)->comment('Đã thanh toán hay chưa');
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
