<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banner extends Model
{
    use HasFactory;
    const OBJECT_FIT = ['cover', 'contain'];
    const DEFAULT_WIDTH = 1400;
    const DEFAULT_HEIGHT = 500;
    protected $fillable = [
        'name', 
        'width',
        'height',
        'object_fit',
        'is_active',
    ];

    // Relationship
    public function bannerImages()
    {
        return $this->hasMany(BannerImage::class);
    }

    // Method
    public function getAllWithFirstImage()
    {
        $subquery = BannerImage::query()
            ->select('banner_id', DB::raw('MIN(id) as id'))
            ->groupBy('banner_id');

        $results = Banner::query()
            ->leftJoinSub($subquery, 'min_images', function ($join) {
                $join->on('banners.id', '=', 'min_images.banner_id');
            })
            ->leftJoin('banner_images', 'min_images.id', '=', 'banner_images.id')
            ->select('banners.*', 'banner_images.url as image')
            ->orderBy('banners.created_at', 'desc')
            ->get();

        return $results;
    }
    public function setActiveOn($id){
        Banner::where('is_active', 1)->update(['is_active' => 0]);
        $banner = Banner::find($id);
        $banner->is_active = 1;
        return $banner->save();
    }
}
