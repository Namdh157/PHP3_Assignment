<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'voucher_id',
        'bill_id',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
    public function bill(){
        return $this->belongsTo(Bill::class, 'bill_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
