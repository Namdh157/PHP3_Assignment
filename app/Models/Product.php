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

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function catalogue() {
        return $this->belongsTo(Catalogue::class);
    }

    public function productGalleries() {
        return $this->hasMany(ProductGallery::class);
    }
    public function productColors() {
        return $this->hasMany(ProductColor::class);
    }
    public function productSizes() {
        return $this->hasMany(ProductSize::class);
    }
}
