<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Product;

class HomeController extends Controller
{
    const PATH_VIEW = 'pages.public.home.';
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $trendingProducts = Product::where('is_active',1)->orderBy('view', 'desc')->limit(8)
            ->with('catalogue','productVariants')->get();
        $newArrivalProducts = Product::where('is_active',1)->orderBy('created_at', 'asc')->limit(8)
            ->with('catalogue','productVariants')->get();
        $dealProducts = Product::where('is_active',1)->orderBy('sell_count', 'desc')->limit(2)
            ->with('catalogue','productVariants')->get();
        $listBrands = Brand::where('is_active',1)->get();
        $listCatalogues = Catalogue::where('is_active',1)->get();
        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'Trang chủ',
            'trendingProducts'=> $trendingProducts,
            'newArrivalProducts' => $newArrivalProducts,
            'listBrands' => $listBrands,
            'listCatalogues' => $listCatalogues,
            'dealProducts' => $dealProducts,
        ]);
    }
}
