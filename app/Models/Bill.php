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
        'customer_note',
        'status',
        'is_paid',
        'quantity',
        'total_discount',
        'total_price',
    ];

    // Relationship
    public function user(){
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function checkVouchers()
    {
        return $this->hasMany(CheckVoucher::class);
    }
    public function billDetails(){
        return $this->hasMany(BillDetail::class);
    }
}
