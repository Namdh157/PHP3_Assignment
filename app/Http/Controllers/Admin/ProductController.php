<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    const PATH_VIEW = 'pages.admin.product.';
    const SIDE_BAR = 'product';
    public function index()
    {
        $totalPage = ceil(Product::query()->count() / $this->itemPerPage);
        $curPage = $_GET['page'] ?? 1;
        if ($curPage < 1)  $curPage = 1;
        if ($curPage > $totalPage) $curPage = $totalPage;
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
        $httpReferer = $_SERVER['HTTP_REFERER'];
        $allBrands = Brand::all();
        $allCatalogues = Catalogue::all();
        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'Add Product',
            'sidebar' => self::SIDE_BAR,
            'httpReferer' => $httpReferer,
            'allBrands' => $allBrands,
            'allCatalogues' => $allCatalogues
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // echo json_encode(['success'=>'Success']);die;
        // Validate
        $validateErrors = [];
        $validateProduct = self::validateProduct($request);
        $variants = json_decode($request->get('variants'), true);

        if (!empty($variants)) {
            $validateVariant = self::validateVariant($variants);
            $validateVariant !== true && $validateErrors['variant'] = $validateVariant;
        }
        $validateProduct !== true && $validateErrors['product'] = $validateProduct;

        if (!empty($validateErrors)) {
            return response()->json([
                "error" => "Failed to validate",
                "data" => $validateErrors
            ])->setStatusCode(500);
        }

        // Upload Thumbnail
        $file = $request->file('thumbnail');
        $thumbnailPath = self::uploadImage($file);
        if ($thumbnailPath === false) {
            return response()->json([
                "error" => "Failed to upload thumbnail"
            ])->setStatusCode(500);
        }

        // Create Product
        $product = Product::create([
            'name' => $request->get('name'),
            'brand_id' => $request->get('brand_id'),
            'catalogue_id' => $request->get('catalogue_id'),
            'sku' => $request->get('sku'),
            'slug' => $request->get('slug'),
            'description' => $request->get('description'),
            'content' => $request->get('content'),
            'is_active' => $request->get('is_active'),
            'image_thumbnail' => $thumbnailPath
        ]);
        $product->save();

        if (!$product) {
            return response()->json([
                "error" => "Failed to create product"
            ])->setStatusCode(500);
        }

        // upload galleries
        $galery = $request->file('gallery');
        if (!empty($galery)) {
            foreach ($galery as $key => $file) {
                $galleryPath = self::uploadImage($file);
                if ($galleryPath === false) {
                    return response()->json([
                        "error" => "Failed to upload gallery"
                    ])->setStatusCode(500);
                } else {
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $galleryPath
                    ]);
                }
            }
        }

        // Validate Variants
        if (!empty($variants)) {
            foreach ($variants as $key => $variant) {
                // Add Size
                $size = Size::firstOrCreate(['size' => $variant['size']]);
                if (!$size) {
                    return response()->json([
                        "error" => "Failed to create size"
                    ])->setStatusCode(500);
                }
                // Add Color
                $color = Color::firstOrCreate(['color' => $variant['color']]);
                if (!$color) {
                    return response()->json([
                        "error" => "Failed to create color"
                    ])->setStatusCode(500);
                }
                // Add Variant
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $size->id,
                    'color_id' => $color->id,
                    'price_regular' => $variant['price_regular'],
                    'price_sale' => $variant['price_sale'],
                    'stock' => $variant['stock'],
                    'is_active' => $variant['is_active'],
                    'is_sale' => $variant['price_sale'] < $variant['price_regular'] ? 1 : 0
                ]);
                if (!$variant) {
                    return response()->json([
                        "error" => "Failed to create variant"
                    ])->setStatusCode(500);
                }
            }
        }
        return response()->json([
            "success" => "Product has been created",
            "data" => $product
        ])->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $httpReferer = $_SERVER['HTTP_REFERER'];
        $product = Product::with(['brand', 'catalogue', 'productGalleries', 'productVariants.variantColor', 'productVariants.variantSize'])->find($product->id);
        $maxPrice = $product->productVariants->max('price_regular') ?? 0;
        $minPrice = $product->productVariants->min('price_regular') ?? 0;
        $totalStock = $product->productVariants->sum('stock');
        // dd($product->productVariants)->toArray();
        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'Product Detail',
            'sidebar' => self::SIDE_BAR,
            'product' => $product,
            'maxPrice' => $maxPrice,
            'minPrice' => $minPrice,
            'totalStock' => $totalStock,
            'httpReferer' => $httpReferer
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
        if ($destroy) {
            return redirect()->back()->with('success', 'Product has been deleted');
        }
        return redirect()->back()->with('error', 'Product failed to delete');
    }

    private function validateProduct(Request $request)
    {
        $rule = [
            'name' => 'required|min:3',
            'brand_id' => 'required|numeric',
            'catalogue_id' => 'required|numeric',
            'sku' => ['required', 'unique:products,sku', 'min:10', 'max:10'],
            'slug' => ['required', 'unique:products,slug', 'max:255'],
            'is_active' => 'required|boolean',
            'thumbnail' => 'required|image',
        ];

        $valid = Validator::make($request->all(), $rule);
        if ($valid->fails()) {
            return $valid->errors();
        }
        return true;
    }

    private function validateVariant($variants)
    {
        $rule = [
            '*.color' => 'required',
            '*.size' => 'required',
            '*.price_regular' => 'required|numeric',
            '*.price_sale' => 'required|numeric|lte:*.price_regular',
            '*.stock' => 'required|numeric',
            '*.is_active' => 'required|boolean',
        ];

        $valid = Validator::make($variants, $rule);
        if ($valid->fails()) {
            return $valid->errors();
        }
        return true;
    }
}
