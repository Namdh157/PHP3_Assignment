<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    const VIEW_PATH = 'pages.admin.brand.';
    const SIDE_BAR = 'brand';
    private $model;

    public function __construct()
    {
        $this->model = new Brand();
    }
    public function index()
    {
        $curPage = request('page') ?? 1;
        if($curPage < 1) $curPage = 1;

        $brands = $this->model->query()
            ->latest('id')
            ->paginate($this->model->getPerPage(), ['*'], 'brands', $curPage);

        $totalPage = $brands->lastPage();
        $curPath = $brands->path() . '?';
        $pageArray = range(1, $totalPage);
        
        return view(self::VIEW_PATH . __function__, [
            'title' => 'All brands',
            'sidebar' => self::SIDE_BAR,
            'curPage' => $curPage,
            'totalPage' => $totalPage,
            'curPath' => $curPath,
            'pageArray' =>$pageArray,
            'brands' => $brands,
            'breadcrumb' => [
                ['title' => 'Brands', 'route' => 'admin.brand.index']
            ]

        ]); 
    }

    public function create()
    {
        return view(self::VIEW_PATH . 'brand', [
            'title' => 'Create brand',
            'sidebar' => self::SIDE_BAR,
            'breadcrumb' => [
                ['title' => 'Brands', 'route' => 'admin.brand.index'],
                ['title' => 'Create brand', 'route' => 'admin.brand.create']
            ],
            'isContinue' => true,
            'routePostTo' => route('admin.brand.store'),
            'method' => 'POST',
            'httpReferer' => route('admin.brand.index')
        ]);
    }

    public function store(Request $request)
    {
        $error = [];
        $rule = [
            'name' => 'required|min:3',
            'is_active' => 'required|boolean',
        ];

        $valid = Validator::make($request->all(), $rule);
        if ($valid->fails()) {
            $error = $valid->errors();
        }

        $brand = $this->model->create([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        if($brand) {
            return response()->json([
                'data' => $brand,
                'success' => 'Brand has been created',
            ]);
        }

        return response()->json([
            'data' => $error,
            'error' => 'Brand failed to create',
        ]);
    }

    public function show(Brand $brand)
    {
        
    }

    public function edit(Brand $brand)
    {
        return view(self::VIEW_PATH . 'brand', [
            'title' => 'Update brand',
            'sidebar' => self::SIDE_BAR,
            'brand' => $brand,
            'breadcrumb' => [
                ['title' => 'Brands', 'route' => 'admin.brand.index'],
                ['title' => 'Update brand', 'route' => 'admin.brand.edit']
            ],
            'isContinue' => false,
            'routePostTo' => route('admin.brand.update', $brand->id),
            'method' => 'PUT',
            'httpReferer' => route('admin.brand.index')
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $error = [];
        $rule = [
            'name' => 'required|min:3',
            'is_active' => 'required|boolean',
        ];

        $valid = Validator::make($request->all(), $rule);
        if ($valid->fails()) {
            $error = $valid->errors();
        }

        $brand->name = $request->name;
        $brand->is_active = $request->is_active;
        $brand->save();

        if($brand) {
            return response()->json([
                'data' => $brand,
                'success' => 'Brand has been updated',
            ]);
        }

        return response()->json([
            'data' => $error,
            'error' => 'Brand failed to update',
        ]);
    }

    public function destroy(Brand $brand)
    {
        $destroy = $this->model::destroy($brand->id);
        if ($destroy) {
            return redirect()->back()->with('success', 'Brand has been deleted');
        }
        return redirect()->back()->with('error', 'Brand failed to delete');
    }
}
