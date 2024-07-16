<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = ['color'];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'product_color_id');
    }
}
