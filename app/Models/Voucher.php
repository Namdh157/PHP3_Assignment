<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    const TYPE_PERCENT = 'PERCENT';
    const TYPE_FIXED = 'FIXED';

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

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function bill()
    {
        return $this->hasMany(Bill::class);
    }
}
