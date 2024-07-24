<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    const PATH_VIEW = 'pages.admin.catalogue.';
    const SIDE_BAR = 'catalogue';

    private $model;

    public function __construct() {
        $this->model = new Catalogue();
    }
    public function index()
    {
        $curPage = $_GET['page'] ?? 1;
        if ($curPage < 1)  $curPage = 1;
        $catalogues = $this->model->query()
            ->with(['products'])
            ->paginate($this->model->getPerPage(), '*', 'catalogues', $curPage);
        // Pagination
        $totalPage = $catalogues->lastPage();
        $curPath = $catalogues->path();
        $pageArray = range(1, $totalPage);

        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'All Catalogue',
            'sidebar' => self::SIDE_BAR,
            'curPage' => $curPage,
            'catalogues' => $catalogues,
            'totalPage' => $totalPage,
            'curPath' => $curPath,
            'pageArray' => $pageArray,
            'breadcrumb' => [
                ['title' => 'Catalogue', 'route' => 'admin.catalogue.index']
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
    public function show(Catalogue $catalogue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Catalogue $catalogue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Catalogue $catalogue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catalogue $catalogue)
    {
        $destroy = $this->model::destroy($catalogue->id);
        if ($destroy) {
            return redirect()->back()->with('success', 'Catalogue has been deleted');
        }
        return redirect()->back()->with('error', 'Catalogue failed to delete');
    }
}
