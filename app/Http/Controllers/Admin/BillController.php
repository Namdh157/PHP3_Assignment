<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
{
    const VIEW_PATH = 'pages.admin.bill.';
    const SIDE_BAR = 'bill';
    /**
     * Display a listing of the resource.
     */
    private $model;
    public function __construct()
    {
        $this->model = new Bill();
    }
    public function index()
    {
        $sort = request('sort');
        $curPage = request('page') ?? 1;
        $id = request('id');

        if ($curPage < 1)  $curPage = 1;
        $paramsOrder = match ($sort) {
            'user' => ['customer_name', 'asc'],
            'price_up' => ['total_price', 'asc'],
            'price_down' => ['total_price', 'desc'],
            'created_up' => ['created_at', 'asc'],
            'created_down' => ['created_at', 'desc'],
            default => ['id', 'desc'],
        };
        // Get bill
        $bills = $id
            ? $this->model->query()->where('id', '=', $id)->paginate($this->model->getPerPage())
            : $this->model->query()->orderBy(...$paramsOrder)->paginate($this->model->getPerPage(), '*', 'page', $curPage);

        $billStatus = Bill::STATUS;
        $paymentMethod = Bill::PAYMENT_METHOD;
        // Pagination
        $totalPage = $bills->lastPage();
        $curPath = $bills->path() . '?' . ($sort ? "sort=$sort" : '');
        $pageArray = range(1, $totalPage);

        return view(self::VIEW_PATH . __FUNCTION__, [
            'title' => 'All Bill',
            'sidebar' => self::SIDE_BAR,
            'bills' => $bills,
            'sort' => $sort,
            'billStatus' => $billStatus,
            'paymentMethod' => $paymentMethod,
            'pageArray' => $pageArray,
            'curPage' => $curPage,
            'curPath' => $curPath,
            'totalPage' => $totalPage,
            'breadcrumb' => [
                ['title' => 'Bill', 'route' => 'admin.bill.index'],
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
        $billDetail = BillDetail::where('bill_id', $id)->get();
        $bill = Bill::find($id);
        return view(self::VIEW_PATH . __FUNCTION__, [
            'title' => 'Bill Detail',
            'sidebar' => self::SIDE_BAR,
            'bill' => $bill,
            'billDetail' => $billDetail,
            'breadcrumb' => [
                ['title' => 'Bill', 'route' => 'admin.bill.index'],
                ['title' => 'Detail', 'route' => 'admin.bill.show', 'params' => $id],
            ]
        ]);
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
    public function update(Request $request)
    {
        $statusValid = Bill::STATUS;
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:App\Models\Bill,id',
            'status' => 'required|in:' . implode(',', array_keys($statusValid))
        ]);
        if ($validated->fails()) {
            return response()->json([
                'error' => 'Update failed',
                'data' => $request->all(),
            ]);
        }

        $bill = Bill::find($request->id);
        $bill->status = $request->status;
        $bill->save();

        return response()->json([
            'success' => 'Update success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
