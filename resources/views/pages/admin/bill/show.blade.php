@extends('layouts.admin')

@section('content')

<div class="card shadow">
    <h5 class="card-header fw-bold">Bill Detail</h5>
    <div class="card-body">
        <!-- Information -->
        <div class="mb-2">
            <div>Customer: <span class="fw-medium">{{$bill->customer_name}}</span></div>
            <div>Phone: <span class="fw-medium">{{$bill->customer_phone}}</span></div>
            <div>Address: <span class="fw-medium">{{$bill->customer_address}}</span></div>
            <div>Payment method: <span class="fw-medium">{{strtoupper($bill->payment_method)}}</span></div>
            <div>Status: <span class="fw-medium text-danger">{{strtoupper($bill->status)}}</span></div>
        </div>
        <hr>
        <!-- Detail -->
        <table class="table  table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Size</th>
                    <th scope="col">Color</th>
                    <th scope="col">Quantity (pcs)</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($billDetail as $detail)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $detail->product_name }}</td>
                    <td>{{ $detail->product_sku }}</td>
                    <td>
                        <input class="form-control fw-medium" style="width: 100px" type="text" value="{{ $detail->product_size }}" disabled readonly>
                    </td>
                    <td>
                        <input class="form-control fw-medium" style="width: 100px" type="text" value="{{ $detail->product_color }}" disabled readonly>
                    </td>
                    <td>
                        <input class="form-control fw-medium" style="width: 100px" type="text" value="{{ $detail->quantity }}" disabled readonly>
                    </td>
                    <td>
                        <input class="form-control fw-medium" style="width: 100px" type="text" value="{{ $detail->unit_price }}$" disabled readonly>
                    </td>
                    <td>
                        <input class="form-control fw-medium" style="width: 100px" type="text" value="{{ $detail->quantity * $detail->unit_price }}$" disabled readonly>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-primary-subtle pb-3">
        <div class="fw-bold d-flex justify-content-between px-5 fs-6">
            <span></span>
            <span class="text-danger">-{{$bill->total_discount}}$</span>
        </div>
        <hr>
        <div class="fw-bold d-flex justify-content-between px-5 fs-6">
            <span>Total bill price:</span>
            <span>{{$bill->total_price}}$</span>
        </div>
    </div>
</div>

@endsection