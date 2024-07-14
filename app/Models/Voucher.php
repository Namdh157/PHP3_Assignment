<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'value',
        'type',
        'quantity',
        'used',
        'max_use',
        'max_use_per_user',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'code' => 'hashed',
        'is_active' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function bill()
    {
        return $this->hasMany(Bill::class);
    }
}
