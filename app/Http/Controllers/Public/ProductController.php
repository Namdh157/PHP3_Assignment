<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends CommonController
{
    //
    const PATH_VIEW = 'pages.public.';
    public function detail($slug)
    {
        // product detail
        $product = Product::where('slug', $slug)
            ->with(['catalogue', 'brand', 'productVariants', 'productGalleries', 'productVariants.variantColor', 'productVariants.variantSize'])
            ->first();
        if ($product->count() == 0) {
            return redirect()->route('public.home');
        }

        // also like products
        $alsoLikeProducts = Product::where('catalogue_id', $product->catalogue_id)
            ->first()
            ->limit(4)
            ->with(['catalogue', 'productVariants'])->get();

        // comments
        $comments = $product->comments()
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select('comments.*', 'users.name as user_name')
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($product['product_galleries']);

        return view(self::PATH_VIEW . 'detail.index', [
            'title' => 'Detail',
            'product' => $product->toArray(),
            'alsoLikeProducts' => $alsoLikeProducts,
            'comments' => $comments,
            ...$this->dataHeader

        ]);
    }

    public function allProduct()
    {
        $catalogues = Catalogue::all();
        $brands = Brand::all();
        //products
        $curPage = $_GET['page'] ?? 1;
        if ($curPage < 1)  $curPage = 1;
        $listBrandParams = $_GET['brand'] ?? '';
        $listCatalogueParams = $_GET['catalogue'] ?? '';

        $products = match (true) {
            !empty($listBrandParams) && !empty($listCatalogueParams) => Product::where('is_active', 1)
                ->whereHas('productVariants', function ($query) {
                    $query->where('id', '>', 0);
                })
                ->whereIn('catalogue_id', $listCatalogueParams)
                ->whereIn('brand_id', $listBrandParams)
                ->with(['catalogue', 'productVariants'])
                ->paginate(9, '*', 'products', $curPage),

            !empty($listBrandParams) => Product::where('is_active', 1)
                ->whereHas('productVariants', function ($query) {
                    $query->where('id', '>', 0);
                })
                ->whereIn('brand_id', $listBrandParams)
                ->with(['catalogue', 'productVariants'])
                ->paginate(9, '*', 'products', $curPage),

            !empty($listCatalogueParams) => Product::where('is_active', 1)
                ->whereHas('productVariants', function ($query) {
                    $query->where('id', '>', 0);
                })
                ->whereIn('catalogue_id', $listCatalogueParams)
                ->with(['catalogue', 'productVariants'])
                ->paginate(9, '*', 'products', $curPage),

            default => Product::where('is_active', 1)
                ->whereHas('productVariants', function ($query) {
                    $query->where('id', '>', 0);
                })
                ->with(['catalogue', 'productVariants'])
                ->paginate(9, '*', 'products', $curPage),
        };


        // dd($products);
        $pageArray = range(1, $products->lastPage());
        $curPath = $products->path();

        return view('pages.public.allProduct.index', [
            'title' => 'All Products',
            'catalogues' => $catalogues,
            'showMoreCatalogues' => route('api.catalogue.showMore'),
            'brands' => $brands,
            'showMoreBrands' => route('api.brand.showMore'),
            'products' => $products,
            'pageArray' => $pageArray,
            'curPath' => $curPath,
            'curPage' => $curPage,
            'listBrandParams' => is_array($listBrandParams) ? $listBrandParams : [$listBrandParams],
            'listCatalogueParams' => is_array($listCatalogueParams) ? $listCatalogueParams : [$listCatalogueParams],
            ...$this->dataHeader
        ]);
    }
}
