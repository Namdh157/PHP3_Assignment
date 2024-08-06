<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends CommonController
{
    const PATH_VIEW = 'pages.public.home.';

    public function index()
    {
        $trendingProducts = Product::where('is_active',1)->orderBy('view', 'desc')->limit(8)
            ->with('catalogue','productVariants')->get();
        $newArrivalProducts = Product::where('is_active',1)->orderBy('created_at', 'asc')->limit(8)
            ->with('catalogue','productVariants')->get();
        $dealProducts = Product::where('is_active',1)->orderBy('sell_count', 'desc')->limit(2)
            ->with('catalogue','productVariants')->get();
        $slideBanner = Banner::where('is_active',1)->with('bannerImages')->first();
    
        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'Trang chủ',
            'trendingProducts'=> $trendingProducts,
            'newArrivalProducts' => $newArrivalProducts,
            'dealProducts' => $dealProducts,
            'slideBanner' => $slideBanner,
            ...$this->dataHeader
            
        ]);
    }
}
