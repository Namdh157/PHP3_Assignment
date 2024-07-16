@extends('layouts.admin')
@section('title', 'All Products')


<!-- content -->
@section('content')
<style>
</style>
<div class="container">
    <div class="row my-3">
        <h1>All Products</h1>
        <a href="{{ route('admin.product.create') }}" class="btn btn-primary col-2 my-3">Add Product</a>

        <table class="table">
            <thead>
                <tr>
                    <th class="col-1">#</th>
                    <th class="col-2">SKU</th>
                    <th class="col-2">Name</th>
                    <th class="col-2">Status</th>
                    <th class="col-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)

                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                            <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.product.show', $product) }}" class="btn btn-info">Detail</a>
                        <form action="{{ route('admin.product.destroy', $product) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>


@endsection
<!-- file Javascript -->
@section('script')
@endsection