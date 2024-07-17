<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_regular',
        'price_sale',
        'stock',
    ];

    protected $casts = [
        'is_sale' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function variantColor() {
        return $this->belongsTo(Color::class, 'product_color_id');
    }
    public function variantSize() {
        return $this->belongsTo(Size::class, 'product_size_id');
    }
}
