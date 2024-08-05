<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_id',
        'catalogue_id',
        'slug',
        'sku',
        'image_thumbnail',
        'description',
        'content',
        'sell_count',
        'view',
        'is_active',
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
    public function productVariants() {
        return $this->hasMany(ProductVariant::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }

}
