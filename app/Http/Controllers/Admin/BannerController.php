<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

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
        // Get Data
        $sort = request('sort');
        $curPage = request('page') ?? 1;
        if ($curPage < 1)  $curPage = 1;

        $banners = $this->model->query()
            ->paginate($this->model->getPerPage(), ['*'], 'comments', $curPage);

        // Pagination
        $totalPage = $banners->lastPage();
        $curPath = $banners->path() . '?' . ($sort ? "sort=$sort" : '');
        $pageArray = range(1, $totalPage);

        return view(self::VIEW_PATH . __FUNCTION__, [
            'title' => 'Banner',
            'sidebar' => self::SIDE_BAR,
            'banners' => $banners,
            'totalPage' => $totalPage,
            'curPage' => $curPage,
            'curPath' => $curPath,
            'pageArray' => $pageArray,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
