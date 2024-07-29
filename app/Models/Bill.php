<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    const PAYMENT_METHOD = [
        'transfer' => 'Chuyển khoản',
        'cod' => 'Thanh toán khi nhận hàng',
    ];
    const METHOD_TRANSFER = "TRANSFER";
    const METHOD_COD = "COD";

    const PENDING = 'PENDING';
    const CONFIRMED = 'CONFIRMED';
    const SHIPPING = 'SHIPPING';
    const SUCCESS = 'SUCCESS';
    const CANCEL = 'CANCEL';
    
    

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'payment_method',
        'status',
        'quantity',
        'total_discount',
        'total_price',
    ];
}
