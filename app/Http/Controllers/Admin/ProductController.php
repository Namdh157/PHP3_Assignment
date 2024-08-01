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
    private $model;
    function __construct()
    {
        $this->model = new Product();
    }
    public function index()
    {
        // Get Data
        $curPage = $_GET['page'] ?? 1;
        if ($curPage < 1)  $curPage = 1;
        $products = $this->model->query()
            ->with(['catalogue'])
            ->withCount('productVariants')
            ->latest('id')
            ->paginate($this->model->getPerPage(), '*', 'products', $curPage);

        // Pagination
        $totalPage = $products->lastPage();
        $curPath = $products->path() .  '?';
        $pageArray = range(1, $totalPage);

        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'All Product',
            'sidebar' => self::SIDE_BAR,
            'products' => $products,
            'totalPage' => $totalPage,
            'curPage' => $curPage,
            'curPath' => $curPath,
            'pageArray' => $pageArray,
            'itemPerPage' => $this->model->getPerPage(),
            'breadcrumb' => [
                ['title' => 'Product', 'route' => 'admin.product.index']
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $httpReferer = route('admin.product.index');
        $allBrands = Brand::all();
        $allCatalogues = Catalogue::all();
        return view(self::PATH_VIEW . 'product', [
            'title' => 'Add Product',
            'sidebar' => self::SIDE_BAR,
            'httpReferer' => $httpReferer,
            'allBrands' => $allBrands,
            'allCatalogues' => $allCatalogues,
            'routePostTo' => route('admin.product.store'),
            'method' => 'POST',
            'breadcrumb' => [
                ['title' => 'Product', 'route' => 'admin.product.index'],
                ['title' => 'Add', 'route' => 'admin.product.create']
            ],
            'js' => asset('js/admin/product/create.js')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $variants = json_decode($request->get('variants'), true); // Convert JSON to Array
        // Mảng chứa Validate errors
        $validateErrors = [];

        // Nếu Product chưa valid thì push vào mảng validateErrors
        $validateProduct = self::validateProduct($request);
        $validateProduct !== true && $validateErrors['product'] = $validateProduct;

        // Nếu có variants thì validate
        if (!empty($variants)) {
            $validateVariant = self::validateVariant($variants);
            $validateVariant !== true && $validateErrors['variant'] = $validateVariant;
        }

        // Nếu tất cả chưa valid thì trả về lỗi
        if (!empty($validateErrors)) {
            return response()->json([
                "error" => "Failed to validate",
                "data" => $validateErrors
            ]);
        }

        // Upload Thumbnail
        $file = $request->file('thumbnail');
        $thumbnailPath = self::uploadImage($file);
        if ($thumbnailPath === false) {
            return response()->json([
                "error" => "Failed to upload thumbnail"
            ]);
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
            ]);
        }

        // upload galleries
        $galery = $request->file('gallery');
        if (!empty($galery)) {
            foreach ($galery as $key => $file) {
                $galleryPath = self::uploadImage($file);
                if ($galleryPath === false) {
                    return response()->json([
                        "error" => "Failed to upload gallery"
                    ]);
                } else {
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $galleryPath
                    ]);
                }
            }
        }

        // Nếu có variants thì tạo
        if (!empty($variants)) {
            foreach ($variants as $key => $variant) {
                // Tạo size, color. Nếu đã có thì lấy ra
                $size = Size::firstOrCreate(['size' => $variant['size']]);
                if (!$size) {
                    return response()->json([
                        "error" => "Failed to create size"
                    ]);
                }
                $color = Color::firstOrCreate(['color' => $variant['color']]);
                if (!$color) {
                    return response()->json([
                        "error" => "Failed to create color"
                    ]);
                }
                // Tạo variant
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
                    ]);
                }
            }
        }
        // Trả về thông báo thành công với data
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
        return redirect()->route('public.product.detail', ['slug' => $product->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $httpReferer = $_SERVER['HTTP_REFERER'] ?? route('admin.product.index');
        $allBrands = Brand::all();
        $allCatalogues = Catalogue::all();
        $product = Product::with(['productGalleries', 'productVariants.variantColor', 'productVariants.variantSize'])->find($product->id);
        $gallery = $product->productGalleries;
        $variants = $product->productVariants->sortByDesc('created_at');

        return view(self::PATH_VIEW . 'product', [
            'title' => 'Edit Product',
            'sidebar' => self::SIDE_BAR,
            'httpReferer' => $httpReferer,
            'allBrands' => $allBrands,
            'allCatalogues' => $allCatalogues,
            'gallery' => $gallery,
            'variants' => $variants,
            'product' => $product,
            'routePostTo' => route('admin.product.update', ['product' => $product->id]),
            'method' => 'PUT',
            'breadcrumb' => [
                ['title' => 'Product', 'route' => 'admin.product.index'],
                ['title' => 'Edit', 'route' => 'admin.product.edit', 'params' => $product->sku]
            ],
            'js' => asset('js/admin/product/edit.js')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $variants = json_decode($request->get('variants'), true); // Convert JSON to Array
        $thumbnail = $request->file('thumbnail'); // Lấy ảnh ra nếu có
        $deleteGallery = json_decode($request->get('deleteGallery'), true); // Lấy mảng id gallery cần xóa
        $deleteVariant = json_decode($request->get('deleteVariant'), true); // Lấy mảng id variant cần xóa
        $hasUpdate = false; // Biến kiểm tra xem có update không

        // Mảng chứa Validate errors
        $validateErrors = [];

        // Nếu Product chưa valid thì push vào mảng validateErrors
        $validateProduct = self::validateProduct($request, !empty($thumbnail), $product);
        $validateProduct !== true && $validateErrors['product'] = $validateProduct;

        // Nếu có variants thì validate
        if (!empty($variants)) {
            $validateVariant = self::validateVariant($variants);
            $validateVariant !== true && $validateErrors['variant'] = $validateVariant;
        }

        // Nếu tất cả chưa valid thì trả về lỗi
        if (!empty($validateErrors)) {
            return response()->json([
                "error" => "Failed to validate",
                "data" => $validateErrors
            ]);
        }

        // Update Product
        $product->name = $request->get('name');
        $product->brand_id = $request->get('brand_id');
        $product->catalogue_id = $request->get('catalogue_id');
        $product->sku = $request->get('sku');
        $product->slug = $request->get('slug');
        $product->description = $request->get('description');
        $product->content = $request->get('content');
        $product->is_active = $request->get('is_active');

        // Nếu có ảnh mới thì upload
        if (!empty($thumbnail)) {
            $thumbnailPath = self::uploadImage($thumbnail);
            if ($thumbnailPath === false) {
                return response()->json([
                    "error" => "Failed to upload thumbnail"
                ]);
            }
            $product->image_thumbnail = $thumbnailPath;
        }

        // Lưu product, nếu lỗi thì trả về lỗi
        if (!$product->save()) {
            return response()->json([
                "error" => "Failed to update product"
            ]);
        }

        // upload galleries
        $galery = $request->file('gallery');
        if (!empty($galery)) {
            foreach ($galery as $key => $file) {
                $galleryPath = self::uploadImage($file);
                if ($galleryPath === false) {
                    return response()->json([
                        "error" => "Failed to upload gallery"
                    ]);
                } else {
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $galleryPath
                    ]);
                }
            }
            $hasUpdate = true;
        }

        // Nếu có variants thì tạo hoặc update 
        if (!empty($variants)) {
            foreach ($variants as $key => $variant) {
                // Tạo size, color. Nếu đã có thì lấy ra
                $size = Size::firstOrCreate(['size' => $variant['size']]);
                if (!$size) {
                    return response()->json([
                        "error" => "Failed to create size"
                    ]);
                }
                $color = Color::firstOrCreate(['color' => $variant['color']]);
                if (!$color) {
                    return response()->json([
                        "error" => "Failed to create color"
                    ]);
                }

                // Update nếu đã có variant
                if (isset($variant['variant_id'])) {
                    $variantUpdate = ProductVariant::find($variant['variant_id']);
                    $variantUpdate->size_id = $size->id;
                    $variantUpdate->color_id = $color->id;
                    $variantUpdate->price_regular = $variant['price_regular'];
                    $variantUpdate->price_sale = $variant['price_sale'];
                    $variantUpdate->stock = $variant['stock'];
                    $variantUpdate->is_active = $variant['is_active'];
                    $variantUpdate->is_sale = $variant['price_sale'] < $variant['price_regular'] ? 1 : 0;
                    if (!$variantUpdate->save()) {
                        return response()->json([
                            "error" => "Failed to update variant"
                        ]);
                    }
                }
                // Nếu chưa có variant thì tạo mới
                else {
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
                        ]);
                    }
                }
            }
            $hasUpdate = true;
        }

        // Xóa gallery
        if (!empty($deleteGallery)) {
            if (!ProductGallery::whereIn('id', $deleteGallery)->delete())
                return response()->json([
                    "error" => "Failed to delete gallery"
                ]);
            $hasUpdate = true;
        }

        // Xóa variant
        if (!empty($deleteVariant)) {
            if (!ProductVariant::whereIn('id', $deleteVariant)->delete())
                return response()->json([
                    "error" => "Failed to delete variant"
                ]);
            $hasUpdate = true;
        }

        $hasUpdate && $product->touch(); // Update updated_at

        return response()->json([
            "success" => "Update product success",
        ]);
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

    private function validateProduct(Request $request, $haveThumbnail = true, Product $product = null)
    {
        $rule = [
            'name' => 'required|min:3',
            'brand_id' => 'required|numeric',
            'catalogue_id' => 'required|numeric',
            'sku' => ['required', 'unique:products,sku', 'min:10', 'max:10'],
            'slug' => ['required', 'unique:products,slug', 'max:255'],
            'is_active' => 'required|boolean',
        ];
        if ($haveThumbnail) {
            $rule['thumbnail'] = 'required|image';
        }
        if ($product) {
            if ($request->get('sku') === $product->sku) {
                unset($rule['sku']);
            }
            if ($request->get('slug') === $product->slug) {
                unset($rule['slug']);
            }
        }

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
