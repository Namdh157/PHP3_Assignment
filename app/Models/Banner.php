<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'thumbnail', 'is_active'];

    // Relationship
    public function bannerImages()
    {
        return $this->hasMany(BannerImage::class);
    }
}
