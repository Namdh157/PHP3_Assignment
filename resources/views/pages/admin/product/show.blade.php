@extends('layouts.admin')
@section('title', 'Products Detail')


<!-- content -->
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Product Detail</h1>
            <div class="card">
                <div class="card-header">
                    <h3>{{ $product->name }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset('storage/images/' . $product->image) }}" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>Price</th>
                                    <td>{{ $product->price }}</td>
                                </tr>
                                <tr>
                                    <th>Stock</th>
                                    <td>{{ $product->stock }}</td>
                                </tr>
                                <tr>
                                    <th>Catalogue</th>
                                    <td>{{ $product->catalogue->name }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $product->description }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.product.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- file Javascript -->
@section('script')
@endsection