@extends('layouts.admin')

<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <div class="d-flex justify-content-between align-items-center">
            <form action="">
                <select class="form-select" id="sort-action" name="sort" onchange="onChangeSort(this)">
                    <option value="">-- Sort by --</option>
                    <option value="user" {{$sort === 'user' ? 'selected':''}}>User</option>
                    <option value="price_up" {{$sort === 'price_up' ? 'selected':''}}>Price ↑</option>
                    <option value="price_down" {{$sort === 'price_down' ? 'selected':''}}>Price ↓</option>
                    <option value="created_up" {{$sort === 'created_up' ? 'selected':''}}>Created ↑</option>
                    <option value="created_down" {{$sort === 'created_down' ? 'selected':''}}>Created ↓</option>
                </select>
            </form>

            <!-- Search -->
            <form class="input-group my-3" style="width: 250px" action="{{route('admin.bill.index')}}" method="get">
                <input type="text" class="form-control" placeholder="Search ID" name="id">
                <button type="submit" class="input-group-text" id="basic-addon2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <!-- Table -->
        <table class="table table-hover table-bordered align-middle">
            <thead align="middle">
                <tr class="table-primary" style="vertical-align: middle;">
                    <th class="">Bill ID</th>
                    <th class="">User</th>
                    <th class="">Payment method</th>
                    <th class="">Voucher discount</th>
                    <th class="">Cost</th>
                    <th class="">Status</th>
                    <th class="">paid</th>
                    <th class="">Updated at</th>
                    <th class="">Created at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bills as $index => $bill)
                <tr role="button" onclick="onChooseBill(`{{ route('admin.bill.show',$bill->id) }}`)">
                    <td>{{ $bill->id }}</td>
                    <td>{{ $bill->customer_name }}</td>
                    <td class="text-center">
                        <input class="form-control text-center" type="text" value="{{ $paymentMethod[$bill->payment_method] }}" disabled readonly>
                    </td>
                    <td>
                        <input class="form-control text-center" type="text" value="{{ $bill->total_discount }}$" disabled readonly>
                    </td>
                    <td>
                        <input class="form-control text-center" type="text" value="{{ $bill->total_price }}$" disabled readonly>
                    </td>
                    <td style="width: 140px">
                        <select class="form-select text-light" onchange="onChangeSelect(event)" onfocus="onFocusSelect(event)" onclick="event.stopPropagation()" data-bill-id="{{$bill->id}}">
                            @foreach ($billStatus as $key => $status )
                            <option value="{{$key}}" {{ strtolower($status) === strtolower($bill->status) ? 'selected' : '' }}>{{$status}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    <input class="form-check-input" type="checkbox" onclick="((e)=>{e.preventDefault()})(event)" {{$bill->is_paid ? 'checked':''}}>
                    </td>
                    <td>
                        <span class="text-muted text-nowrap">{{ $bill->updated_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <span class="text-muted text-nowrap">{{ $bill->created_at->diffForHumans() }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <!-- Paginate -->
        @include('common.pagination')
    </div>
</div>

<form action="" id="change-status-form">
    @csrf
</form>

@endsection
<!-- file Javascript -->
@section('script')

<!-- Config Script -->
<script>
    const routeUpdateOne = "{{route('admin.bill.update', 1)}}";
</script>

<!-- Handle Script -->
<script src="{{asset('js/admin/bill/index.js')}}"></script>
@endsection