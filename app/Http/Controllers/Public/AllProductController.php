<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllProductController extends Controller
{
    public function index()
    {
        $title = 'All Products';
        //products
        $curPage = $_GET['page'] ?? 1;
        if($curPage < 1)  $curPage = 1;
        $products = DB::table('products')
            ->leftJoin('catalogues', 'products.catalogue_id', '=', 'catalogues.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->Join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->select('products.name', 'products.image_thumbnail', 'products.slug',
                        'catalogues.name AS catalogue_name', 
                        'brands.name AS brand_name', 'product_variants.price_regular')
            ->distinct()
            ->where('products.is_active', 1, 'and' )
            ->paginate(9, '*', 'products', $curPage);

        // paginate
        $pageArray = range(1, $products->lastPage());
        $curPath = $products->path();

        //catalogue
        $catalogues = Catalogue::withCount('products')
            ->has('products')
            ->take(5)
            ->get();
        $totalCatalogues = Catalogue::has('products')->count();

        //size
        $typeSize = DB::table('sizes')
            ->select('size')
            ->distinct()
            ->get();

        //brand
        $brands = Brand::withCount('products')
            ->has('products')
            ->take(5)
            ->get();
        $totalBrands = Brand::has('products')->count();

        // dd($brands);
        return view('pages.public.allProduct.index',[
            'title' => $title,
            'catalogues' => $catalogues,
            'totalCatalogues' => $totalCatalogues,
            'showMoreCatalogues' => route('api.catalogue.showMore'),
            'typeSize' => $typeSize,
            'brands' => $brands,
            'totalBrands' => $totalBrands,
            'showMoreBrands' => route('api.brand.showMore'),
            'products' => $products,
            'pageArray' => $pageArray,
            'curPath' => $curPath,
            'curPage' => $curPage
        ]);
    }
}
