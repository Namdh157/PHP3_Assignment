<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    const VIEW_PATH = 'pages.admin.banner.';
    const SIDE_BAR = 'banner';
    private $model;
    public function __construct()
    {
        $this->model = new Banner();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = $this->model->getAllWithFirstImage();
        // dd($banners);
        return view(self::VIEW_PATH . __FUNCTION__, [
            'title' => 'Banner',
            'sidebar' => self::SIDE_BAR,
            'banners' => $banners,
            'breadcrumb' => [
                ['title' => 'Banner', 'route' => 'admin.banner.index'],
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $objectFit = Banner::OBJECT_FIT;
        $defaultWidth = Banner::DEFAULT_WIDTH;
        $defaultHeight = Banner::DEFAULT_HEIGHT;
        $httpReferer = request()->headers->get('referer') ?? route('admin.banner.index');

        return view(self::VIEW_PATH . 'banner', [
            'title' => 'Create Banner',
            'sidebar' => self::SIDE_BAR,
            'objectFit' => $objectFit,
            'defaultWidth' => $defaultWidth,
            'defaultHeight' => $defaultHeight,
            'httpReferer' => $httpReferer,
            'js' => asset('js/admin/banner/create.js'),
            'routePost' => route('admin.banner.store'),
            'breadcrumb' => [
                ['title' => 'Banner', 'route' => 'admin.banner.index'],
                ['title' => 'Create Banner', 'route' => 'admin.banner.create'],
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $objectFit = Banner::OBJECT_FIT;
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:banners',
            'width' => 'required|int|min:1',
            'height' => 'required|int|min:1',
            'object_fit' => 'required|in:' . implode(',', $objectFit),
            'gallery' => 'required|array',
        ]);
        if ($validate->fails()) {
            return $request->expectsJson()
                ? response()->json([
                    'error' => 'Validation error',
                    'data' => $validate->errors()
                ])
                : redirect()->back()->withErrors($validate->errors());
        }

        // nếu is_active === true thì cập nhật tất cả các banner khác về false
        if ($request->is_active) {
            $this->model->where('is_active', true)->update(['is_active' => false]);
        }

        // create banner
        $banner = $this->model->create([
            'name' => $request->name,
            'width' => $request->width,
            'height' => $request->height,
            'object_fit' => $request->object_fit,
            'is_active' => $request->is_active ?? false
        ]);
        if (!$banner) {
            return response()->json([
                'error' => 'Failed to create banner'
            ]);
        }

        // upload gallery
        foreach ($request->gallery as $key => $image) {
            $galleryPath = $this->uploadImage($image);
            if (!$galleryPath) {
                return response()->json([
                    "error" => "Failed to upload gallery"
                ]);
            }
            BannerImage::create([
                'banner_id' => $banner->id,
                'url' => $galleryPath
            ]);
        }

        return response()->json([
            'success' => 'Banner has been created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $objectFit = Banner::OBJECT_FIT;
        $defaultWidth = Banner::DEFAULT_WIDTH;
        $defaultHeight = Banner::DEFAULT_HEIGHT;
        $httpReferer = request()->headers->get('referer') ?? route('admin.banner.index');
        $banner = $this->model->find($id);
        $listImage = BannerImage::where('banner_id', $id)->get();

        return view(self::VIEW_PATH . 'banner', [
            'title' => 'Edit Banner',
            'sidebar' => self::SIDE_BAR,
            'banner' => $banner,
            'listImage' => $listImage,
            'objectFit' => $objectFit,
            'defaultWidth' => $defaultWidth,
            'defaultHeight' => $defaultHeight,
            'httpReferer' => $httpReferer,
            'routePost' => route('admin.banner.update', $id),
            'js' => asset('js/admin/banner/edit.js'),
            'method' => 'PUT',
            'breadcrumb' => [
                ['title' => 'Banner', 'route' => 'admin.banner.index'],
                ['title' => 'Edit Banner', 'route' => 'admin.banner.edit'],
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $objectFit = Banner::OBJECT_FIT;
        $banner = $this->model->find($id);
        $rule = [
            'width' => 'required|int|min:1',
            'height' => 'required|int|min:1',
            'object_fit' => 'required|in:' . implode(',', $objectFit)
        ];
        if($banner->name !== $request->name) {
            $rule['name'] = 'required|unique:banners';
        }

        // validate
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return $request->expectsJson()
                ? response()->json([
                    'error' => 'Validation error',
                    'data' => $validate->errors()
                ])
                : redirect()->back()->withErrors($validate->errors());
        }

        // Xoá gallery chọn
        $galleryIds = json_decode($request->delete_gallery, true);
        $numberOfGallery = BannerImage::where('banner_id', $id)->count();
        if(count($galleryIds) === $numberOfGallery){
            return response()->json([
                'error' => 'You must keep at least 1 image'
            ]);
        }
        BannerImage::destroy($galleryIds);

        // upload gallery nếu có
        if ($request->gallery) {
            foreach ($request->gallery as $key => $image) {
                $galleryPath = $this->uploadImage($image);
                if (!$galleryPath) {
                    return response()->json([
                        "error" => "Failed to upload gallery"
                    ]);
                }
                BannerImage::create([
                    'banner_id' => $banner->id,
                    'url' => $galleryPath
                ]);
            }
        }

        // nếu is_active === true thì cập nhật tất cả các banner khác về false
        if ($request->is_active) {
            $this->model->where('is_active', true)->update(['is_active' => false]);
            $banner->is_active = true;
        }

        // update banner
        $update = $banner->update([
            'name' => $request->get('name'),
            'width' => $request->get('width'),
            'height' => $request->get('height'),
            'object_fit' => $request->get('object_fit'),
        ]);
        if (!$update) {
            return response()->json([
                'error' => 'Failed to update banner'
            ]);
        }

        return response()->json([
            'success' => 'Banner has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy = $this->model->destroy($id);
        if ($destroy) {
            return redirect()->back()->with('success', 'Banner has been deleted');
        }
        return redirect()->back()->with('error', 'Banner failed to delete');
    }
}
