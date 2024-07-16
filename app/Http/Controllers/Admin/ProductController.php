<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    const PATH_VIEW = 'pages.admin.product.';
    public function index()
    {
        $products = Product::query()->with('catalogue')->latest('id');
        return view(self::PATH_VIEW . __FUNCTION__, [
            'products' => $products->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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

        $product = Product::with(['brand', 'catalogue', 'productGalleries', 'productColors', 'productSizes', 'productVariants'])->find($product->id);
        dd($product);
        return view(self::PATH_VIEW . __FUNCTION__, [
            'product' => $product,
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
        //
    }
}
