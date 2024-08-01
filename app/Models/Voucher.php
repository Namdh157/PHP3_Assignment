<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    const TYPE = [
        'percent' => 'Percent',
        'fixed' => 'Fixed',
    ];
    protected $fillable = [
        'code',
        'value',
        'type',
        'quantity',
        'used',
        'max_use',
        'is_active',
        'start_at',
        'end_at',
    ];

    public function checkVoucher()
    {
        return $this->hasMany(CheckVoucher::class);
    }
}
