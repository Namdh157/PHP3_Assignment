<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'sku',
        'image_thumbnail',
        'price_regular',
        'price_sale',
        'description',
        'content',
        'view',
    ];

    protected $casts = [
        'price_regular' => 'double',
        'price_sale' => 'double',
        'view' => 'integer',
        'is_active' => 'boolean',
    ];
}
