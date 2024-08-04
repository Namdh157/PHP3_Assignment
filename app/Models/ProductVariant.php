<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price_regular',
        'price_sale',
        'stock',
        'is_active',
        'is_sale'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variantColor()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function variantSize()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
}
