<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    const PAYMENT_METHOD = [
        'cod' => 'Cod',
        'transfer' => 'Transfer',
    ];
    const STATUS = [
        'pending' => 'Pending',
        'shipping' => 'Shipping',
        'completed' => 'Completed',
        'canceled' => 'Canceled',
    ];

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
