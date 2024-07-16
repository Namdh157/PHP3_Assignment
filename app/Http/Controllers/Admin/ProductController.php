<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    const PATH_VIEW = 'pages.admin.product.';
    const SIDE_BAR = 'product';
    public function index()
    {
        $totalPage = ceil(Product::query()->count() / $this->itemPerPage);
        $curPage = $_GET['page'] ?? 1;
        if($curPage < 1)  $curPage = 1;
        if($curPage > $totalPage) $curPage = $totalPage;
        $curPath = $_SERVER['PATH_INFO'];
        $pageArray = range(1, $totalPage);

        $products = Product::query()->with('catalogue')->latest('id');
        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'All Product',
            'sidebar' => self::SIDE_BAR,
            'products' => $products->paginate(10, '*', 'products', $curPage),
            'totalPage' => $totalPage,
            'curPage' => $curPage,
            'curPath' => $curPath,
            'pageArray' => $pageArray,
            'itemPerPage' => $this->itemPerPage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'Add Product',
            'sidebar' => self::SIDE_BAR,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        $product = Product::with(['brand', 'catalogue', 'productGalleries', 'productVariants.variantColor', 'productVariants.variantSize'])->find($product->id);
        $maxPrice = $product->productVariants->max('price_regular') ?? 0;
        $minPrice = $product->productVariants->min('price_regular') ?? 0;
        $totalStock = $product->productVariants->sum('stock');
        // dd($product->productVariants)->toArray();
        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'Product Detail',
            'sidebar' => 'product',
            'product' => $product,
            'maxPrice' => $maxPrice,
            'minPrice' => $minPrice,
            'totalStock' => $totalStock
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $destroy = Product::destroy($product->id);
        if($destroy){
            return redirect()->back()->with('success', 'Product has been deleted');
        }
        return redirect()->back()->with('error', 'Product failed to delete');
    }
}
