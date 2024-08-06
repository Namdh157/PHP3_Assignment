<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'product_id',
        'product_name',
        'product_size',
        'product_color',
        'product_image_thumbnail',
        'unit_price',
        'quantity'
    ];
    public function bill(){
        return $this->belongsTo(Bill::class);
    }
}
