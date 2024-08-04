<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    const PATH_VIEW = 'pages.admin.voucher.';
    const SIDE_BAR = 'voucher';
    private $model;
    public function __construct()
    {
        $this->model = new Voucher();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sort = request('sort');
        $curPage = request('page') ?? 1;
        $typeArr = Voucher::TYPE;

        if ($curPage < 1)  $curPage = 1;
        $paramsOrder = match ($sort) {
            'type' => ['type', 'asc'],
            'status' => ['is_active', 'desc'],
            'created_up' => ['created_at', 'asc'],
            'created_down' => ['created_at', 'desc'],
            default => ['id', 'desc'],
        };
        // Get bill
        $vouchers = $this->model->query()->orderBy(...$paramsOrder)->paginate($this->model->getPerPage(), '*', 'page', $curPage);

        // Pagination
        $totalPage = $vouchers->lastPage();
        $curPath = $vouchers->path() . '?' . ($sort ? "sort=$sort" : '');
        $pageArray = range(1, $totalPage);

        return view(self::PATH_VIEW . 'index', [
            'title' => 'Voucher',
            'sidebar' => self::SIDE_BAR,
            'sort' => $sort,
            'pageArray' => $pageArray,
            'curPage' => $curPage,
            'curPath' => $curPath,
            'totalPage' => $totalPage,
            'vouchers' => $vouchers,
            'typeArr' => $typeArr,
            'breadcrumb' => [
                ['title' => 'Voucher', 'route' => 'admin.voucher.index']
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $httpReferer = route('admin.voucher.index');
        $types = Voucher::TYPE;
        return view(self::PATH_VIEW . 'voucher', [
            'title' => 'Add Voucher',
            'sidebar' => self::SIDE_BAR,
            'httpReferer' => $httpReferer,
            'types' => $types,
            'routePostTo' => route('admin.voucher.store'),
            'method' => 'POST',
            'breadcrumb' => [
                ['title' => 'Voucher', 'route' => 'admin.voucher.index'],
                ['title' => 'Add', 'route' => 'admin.voucher.create']
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $voucher = $request->all();
        $type = array_keys(Voucher::TYPE);

        // Validate
        $validate = Validator::make($voucher, [
            'code' => 'required|unique:vouchers',
            'type' => ['required', 'in:' . implode(',', $type)],
            'value' => 'required|numeric|min:0',
            'quantity' => 'required|int|min:0',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'is_active' => 'required|boolean',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'error' => 'Validate error',
                'data' => $validate->errors()
            ]);
        }

        // Create
        $voucher = $this->model->create($voucher);
        if ($voucher) {
            return response()->json([
                'success' => 'Voucher has been created',
                'data' => $voucher
            ]);
        }

        return response()->json([
            'error' => 'Can not create voucher'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $httpReferer = $_SERVER['HTTP_REFERER'] ?? route('admin.voucher.index');
        $types = Voucher::TYPE;
        $voucher = $this->model->find($id);
        if (!$voucher) {
            return redirect()->back()->with('error', 'Can not find voucher');
        }

        return view(self::PATH_VIEW . 'voucher', [
            'title' => 'Edit Voucher',
            'sidebar' => self::SIDE_BAR,
            'httpReferer' => $httpReferer,
            'types' => $types,
            'voucher' => $voucher,
            'routePostTo' => route('admin.voucher.update', $id),
            'method' => 'PATCH',
            'breadcrumb' => [
                ['title' => 'Voucher', 'route' => 'admin.voucher.index'],
                ['title' => 'Edit', 'route' => 'admin.voucher.show', 'params' => $id]
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestVoucher = $request->all();
        $voucher = $this->model->find($id);
        $type = array_keys(Voucher::TYPE);
        $rule = [
            'type' => ['required', 'in:' . implode(',', $type)],
            'value' => 'required|numeric|min:0',
            'quantity' => 'required|int|min:0',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'is_active' => 'required|boolean',
        ];
        if($requestVoucher['code'] != $voucher->code) {
            $rule['code'] = 'required|unique:vouchers';
        }

        // Validate
        $validate = Validator::make($requestVoucher, $rule);
        if ($validate->fails()) {
            return response()->json([
                'error' => 'Validate error',
                'data' => $validate->errors()
            ]);
        }

        // Update
        $voucher->fill($requestVoucher);
        if ($voucher->save()) {
            return response()->json([
                'success' => 'Voucher has been updated',
                'data' => $voucher
            ]);
        }

        return response()->json([
            'error' => 'Can not create voucher'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy = $this->model->destroy($id);
        if ($destroy) {
            return redirect()->back()->with('success', 'Voucher has been deleted');
        }
        return redirect()->back()->with('error', 'Voucher failed to delete');
    }
}
