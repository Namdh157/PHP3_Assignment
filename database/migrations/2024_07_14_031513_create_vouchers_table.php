<?php

use App\Models\Bill;
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
            $table->enum('type', array_keys(Voucher::TYPE))->default(array_keys(Voucher::TYPE)[0])->comment('Loại giảm giá');
            $table->integer('quantity')->comment('Số lượng mã giảm giá');
            $table->integer('used')->default(0)->comment('Số lượng mã giảm giá đã sử dụng');
            $table->boolean('is_active')->default(true)->comment('Trạng thái hoạt động');
            $table->date('start_at')->comment('Thời gian bắt đầu');
            $table->date('end_at')->comment('Thời gian kết thúc');
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
