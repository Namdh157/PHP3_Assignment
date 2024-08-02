<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatalogueController extends Controller
{
    const PATH_VIEW = 'pages.admin.catalogue.';
    const SIDE_BAR = 'catalogue';

    private $model;

    public function __construct()
    {
        $this->model = new Catalogue();
    }
    public function index()
    {
        $curPage = $_GET['page'] ?? 1;
        if ($curPage < 1)  $curPage = 1;
        $catalogues = $this->model->query()
            ->with(['products'])
            ->latest('id')
            ->paginate($this->model->getPerPage(), '*', 'catalogues', $curPage);
        // Pagination
        $totalPage = $catalogues->lastPage();
        $curPath = $catalogues->path() . '?';
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
                ['title' => 'Catalogue', 'route' => 'admin.catalogue.index'],
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . 'catalogue', [
            'title' => 'Create Catalogue',
            'sidebar' => self::SIDE_BAR,
            'httpReferer' => route('admin.catalogue.index'),
            'routePostTo' => route('admin.catalogue.store'),
            'method' => 'POST',
            'isContinue' => true,
            'breadcrumb' => [
                ['title' => 'Catalogue', 'route' => 'admin.catalogue.index'],
                ['title' => 'Create', 'route' => 'admin.catalogue.create'],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
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

        $catalogue = $this->model->create([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        if($catalogue) {
            return response()->json([
                'data' => $catalogue,
                'success' => 'Catalogue has been created',
            ]);
        }

        return response()->json([
            'data' => $error,
            'error' => 'Catalogue failed to create',
        ]);
    }


    public function show(Catalogue $catalogue)
    {
        //
    }

    public function edit(Catalogue $catalogue)
    {
        return view(self::PATH_VIEW . 'catalogue', [
            'title' => 'Update Catalogue',
            'sidebar' => self::SIDE_BAR,
            'breadcrumb' => [
                ['title' => 'Catalogue', 'route' => 'admin.catalogue.index'],
                ['title' => 'Update', 'route' => 'admin.catalogue.edit', 'id' => $catalogue->id],
            ],
            'catalogue' => $catalogue,
            'httpReferer' => route('admin.catalogue.index'),
            'routePostTo' => route('admin.catalogue.update', $catalogue->id),
            'method' => 'PUT',
            'isContinue' => false,
        ]);   
    }

    public function update(Request $request, Catalogue $catalogue)
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

        $catalogue->name = $request->name;
        $catalogue->is_active = $request->is_active;
        $catalogue->save();

        if($catalogue) {
            return response()->json([
                'data' => $catalogue,
                'success' => 'Catalogue has been updated',
            ]);
        }

        return response()->json([
            'data' => $error,
            'error' => 'Catalogue failed to update',
        ]);
    }

    public function destroy(Catalogue $catalogue)
    {
        $destroy = $this->model::destroy($catalogue->id);
        if ($destroy) {
            return redirect()->back()->with('success', 'Catalogue has been deleted');
        }
        return redirect()->back()->with('error', 'Catalogue failed to delete');
    }
}
