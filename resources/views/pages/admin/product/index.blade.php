@extends('layouts.admin')

<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <h2>All Products</h2>
        <hr>
        <a href="{{ route('admin.product.create') }}" class="btn btn-success my-3">
            Add new <i class="fa-solid fa-plus"></i>
        </a>

        <table class="table">
            <thead>
                <tr class="table-primary">
                    <th class="col-1">#</th>
                    <th class="col-2">SKU</th>
                    <th class="col-3">Product</th>
                    <th class="col-2">Catalogue</th>
                    <th class="col-2">Status</th>
                    <th class="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                <tr>
                    <th scope="row">{{$index + 1 + ($curPage - 1) * $itemPerPage }}</th>
                    <td>{{ $product->sku }}</td>
                    <td>
                        <img src="{{$product->image_thumbnail}}" alt="" class="object-fit-contain rounded" style="width: 50px; height: 50px">
                        {{ $product->name }}
                    </td>
                    <td>{{ $product->catalogue->name }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" {{$product->is_active ? 'checked':''}} />
                            <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-warning">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="{{ route('admin.product.show', $product) }}" class="btn btn-info">
                            <i class="fa-solid fa-circle-info"></i>
                        </a>
                        <form action="{{ route('admin.product.destroy', $product) }}" method="POST" style="display:inline" onsubmit="confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
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


@endsection
<!-- file Javascript -->
@section('script')
@endsection