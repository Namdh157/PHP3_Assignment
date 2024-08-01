@extends('layouts.admin')

<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <!-- Search -->
        <form class="input-group mb-3 ms-auto" style="width: 250px">
            <input type="text" class="form-control" placeholder="Search ID">
            <button type="submit" class="input-group-text" id="basic-addon2">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

        <!-- Table -->
        <table class="table table-hover table-bordered align-middle">
            <thead align="middle">
                <tr class="table-primary" style="vertical-align: middle;">
                    <th class="">Bill ID</th>
                    <th class="">User</th>
                    <th class="">Phone number</th>
                    <th class="">Email</th>
                    <th class="">Address</th>
                    <th class="">Payment method</th>
                    <th class="">Cost</th>
                    <th class="">Status</th>
                    <th class="">Updated at</th>
                    <th class="">Created at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bills as $index => $bill)
                <tr role="button" onclick="onChooseBill(`{{ route('admin.bill.show',$bill->id) }}`)">
                    <td>{{ $bill->id }}</td>
                    <td>{{ $bill->customer_name }}</td>
                    <td>{{ $bill->customer_phone }}</td>
                    <td>{{ $bill->customer_email }}</td>
                    <td>{{ $bill->customer_address }}</td>
                    <td class="text-center">
                        <input class="form-control text-center" type="text" value="{{ $paymentMethod[$bill->payment_method] }}" disabled readonly style="width: 80px">
                    </td>
                    <td>
                        <input class="form-control text-center" type="text" value="{{ $bill->total_price }}$" disabled readonly style="width: 100px">
                    </td>
                    <td style="width: 140px">
                        <select class="form-select text-light" onchange="onChangeSelect(event)" onfocus="onFocusSelect(event)" onclick="event.stopPropagation()" data-bill-id="{{$bill->id}}">
                            @foreach ($billStatus as $key => $status )
                            <option value="{{$key}}" {{ strtolower($status) === strtolower($bill->status) ? 'selected' : '' }}>{{$status}}</option>
                            @endforeach
                        </select>
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

<form action="" id="apiForm">
    @csrf
</form>

@endsection
<!-- file Javascript -->
@section('script')

<!-- Config Script -->
<script>
    const route = '{{$routePostTo}}';
</script>

<!-- Handle Script -->
<script src="{{asset('js/admin/bill/index.js')}}"></script>
@endsection