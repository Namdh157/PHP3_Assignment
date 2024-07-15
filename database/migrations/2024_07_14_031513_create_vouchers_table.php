<?php

use App\Models\Voucher;
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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('value', 10, 2)->comment('Giá trị giảm giá');
            $table->enum('type', [Voucher::TYPE_PERCENT, Voucher::TYPE_FIXED])->default(Voucher::TYPE_PERCENT)->comment('Loại giảm giá');
            $table->integer('quantity')->comment('Số lượng mã giảm giá');
            $table->integer('used')->default(0)->comment('Số lượng mã giảm giá đã sử dụng');
            $table->integer('max_use')->comment('Số lần sử dụng tối đa');
            $table->boolean('is_active')->default(true)->comment('Trạng thái hoạt động');
            $table->dateTime('start_at')->comment('Thời gian bắt đầu');
            $table->dateTime('end_at')->comment('Thời gian kết thúc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
