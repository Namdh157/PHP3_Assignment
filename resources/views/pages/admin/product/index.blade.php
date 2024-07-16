@extends('layouts.admin')
@section('title', 'All Products')


<!-- content -->
@section('content')
<div class="container">
    <div class="row my-3">
        <h2>All Products</h2>
        <hr>
        <a href="{{ route('admin.product.create') }}" class="btn btn-primary col-2 my-3">Add Product</a>

        <table class="table">
            <thead>
                <tr>
                    <th class="col-1">#</th>
                    <th class="col-2">SKU</th>
                    <th class="col-2">Name</th>
                    <th class="col-2">Catalogue</th>
                    <th class="col-2">Status</th>
                    <th class="col-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                <tr>
                    <th scope="row">{{$index + 1 + ($curPage - 1) * $itemPerPage }}</th>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->catalogue->name }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" {{$product->is_active ? 'checked':''}}/>
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

        <!-- Paginate -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link {{$curPage <= 1 ? 'disabled':''}}" href="{{$curPath}}?page={{$curPage > 1 ? $curPage - 1 : $curPage}}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                @foreach ($pageArray as $page)
                    <li class="page-item {{$curPage == $page ? 'active':''}}">
                        <a class="page-link" href="{{$curPath}}?page={{$page}}">{{$page}}</a>
                    </li>
                @endforeach
                
                <li class="page-item">
                    <a class="page-link {{$curPage >= $totalPage ? 'disabled':''}}" href="{{$curPath}}?page={{$curPage < $totalPage ? $curPage + 1 : $curPage}}" aria-label="Previous">
                    <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>


@endsection
<!-- file Javascript -->
@section('script')
@endsection