@extends('layouts.admin')

<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <div class="d-flex justify-content-between">
            <!-- left -->
            <div class="d-flex gap-3 align-items-center">
                <a href="{{  route('admin.voucher.create')  }}" class="btn btn-success my-3">
                    Add new <i class="fa-solid fa-plus"></i>
                </a>
                <form action="">
                    <select class="form-select" id="sort-action" name="sort" onchange="onChangeSort(this)">
                        <option value="">-- Sort by --</option>
                        <option value="type" {{ $sort === 'type' ? 'selected':'' }}>Type</option>
                        <option value="status" {{ $sort === 'status' ? 'selected':'' }}>Status</option>
                        <option value="created_up" {{ $sort === 'created_up' ? 'selected':'' }}>Created ↑</option>
                        <option value="created_down" {{ $sort === 'created_down' ? 'selected':'' }}>Created ↓</option>
                    </select>
                </form>
            </div>

            <!-- Right -->
            <div class="d-flex gap-2 my-3" style="height: max-content">
                <select class="form-select" id="select-action">
                    <option value="" selected>-- Action --</option>
                    <option value="published">Active</option>
                    <option value="draft">Inactive</option>
                    <option value="delete">Delete</option>
                </select>
                <button class="btn btn-outline-success" id="select-submit">Submit</button>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-hover table-bordered align-middle">
            <thead align="middle">
                <tr class="table-primary" style="vertical-align: middle;">
                    <th class="">
                        <input class="form-check-input" type="checkbox" id="checked-all">
                    </th>
                    <th class="">Code</th>
                    <th class="">Type</th>
                    <th class="">Value</th>
                    <th class="">Quantity</th>
                    <th class="">Used</th>
                    <th class="">Start</th>
                    <th class="">End</th>
                    <th class="">Status</th>
                    <th class="">Updated at</th>
                    <th class="">Created at</th>
                    <th class="">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $index => $voucher)
                <tr>
                    <td class="position-relative">
                        <label for="check-item-{{ $index }}" class="position-absolute top-0 start-0 w-100 h-100 z-3"></label>
                        <input class="form-check-input" type="checkbox" value="{{ $voucher->id }}" name="check-item" id="check-item-{{ $index }}">
                    </td>
                    <td>{{ $voucher->code }}</td>
                    <td>{{ $typeArr[$voucher->type] ?? $voucher->type }}</td>
                    <td>{{ $voucher->value }}</td>
                    <td>{{ $voucher->quantity }}</td>
                    <td>{{ $voucher->used }}</td>
                    <td>{{ $voucher->start_at }}</td>
                    <td>{{ $voucher->end_at }}</td>
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" onclick="((e)=>{e.preventDefault()})(event)" {{ $voucher->is_active ? 'checked':'' }} name="active-item">
                    </td>
                    <td>{{ $voucher->updated_at }}</td>
                    <td>{{ $voucher->created_at }}</td>
                    <td style="width: 100px">
                        <a href="{{  route('admin.voucher.edit', $voucher->id)  }}" class="btn btn-outline-info">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <form action="{{  route('admin.voucher.destroy', $voucher)  }}" method="POST" style="display:inline" onsubmit="confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <!-- Paginate -->
        @include('common.pagination')
    </div>
</div>

<form action="" id="checkbox-form">
    @csrf
</form>

@endsection
<!-- file Javascript -->
@section('script')

<!-- Config Script -->
<script>
    const routeUpdate = "{{ route('api.voucher.updateStatus', 0) }}";
    const routeDelete = "{{ route('api.voucher.deleteMany', 0) }}";
    const httpReferer = "{{ isset($httpReferer)? $httpReferer : asset('admin.comment.index') }}"
</script>

<!-- Handle Script -->
<script src="{{ asset('js/admin/selectIndex.js') }}"></script>
@endsection