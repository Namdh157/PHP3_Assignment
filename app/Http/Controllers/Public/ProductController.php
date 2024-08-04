<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    const PATH_VIEW = 'pages.public.';
    public function detail($slug){
        //echo $slug;
        $product = Product::where('slug',$slug)->with('catalogue','brand','productVariants')->first();
        $listBrands = Brand::where('is_active',1)->get();
        $listCatalogues = Catalogue::where('is_active',1)->get();
        $alsoLikeProducts = Product::where('catalogue_id',$product->catalogue_id)->limit(4)
            ->with('catalogue','productVariants')->get();
        //dd($product);
        return view(self::PATH_VIEW.'detail.index',[
            'title' => 'Detail',
            'product' => $product,
            'listBrands' => $listBrands,
            'listCatalogues' => $listCatalogues,
            'alsoLikeProducts' => $alsoLikeProducts,
        ]);
    }

    public function allProduct(){
        
    }
}
