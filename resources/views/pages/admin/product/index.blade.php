@extends('layouts.admin')

<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <a href="{{ route('admin.product.create') }}" class="btn btn-success my-3">
            Add new <i class="fa-solid fa-plus"></i>
        </a>

        <table class="table">
            <thead>
                <tr class="table-primary">
                    <th class="">#</th>
                    <th class="">SKU</th>
                    <th class="">Product</th>
                    <th class="">Catalogue</th>
                    <th class="">Brand</th>
                    <th class="">Variant</th>
                    <th class="">Active</th>
                    <th class="">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                <tr>
                    <th scope="row">{{$index + 1 + ($curPage - 1) * $itemPerPage }}</th>
                    <td>{{ $product->sku }}</td>
                    <td>
                        <a href="{{ route('admin.product.show', $product) }}" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
                            <img src="{{asset($product->image_thumbnail)}}" alt="" class="object-fit-contain rounded-3" style="width: 50px; height: 50px">
                            <span class="fw-bold">{{ $product->name }}</span>
                        </a>
                    </td>
                    <td>{{ $product->catalogue->name }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>{{ $product->product_variants_count }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" onclick="((e)=>{e.preventDefault()})(event)" type="checkbox" role="switch" id="flexSwitchCheckDefault" {{$product->is_active ? 'checked':''}} />
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-warning">
                            <i class="fa-solid fa-pen-to-square"></i>
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