@extends('layouts.admin')

<!-- content -->
@section('content')

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-3">
                <a href="{{ $httpReferer }}" class="fs-6 btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h3>{{ $product->name }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-7">
                        <img src="{{ asset($product->image_thumbnail) }}" alt="" class="object-fit-contain rounded" style="height: 300px">
                        @foreach ($product->productGalleries as $image)
                            <img src="{{asset($image['image'])}}" alt="" class="object-fit-contain rounded" style="height: 70px">
                        @endforeach
                    </div>

                    <div class="col-5">
                        <table class="table">
                            <tr>
                                <th>SKU</th>
                                <td>{{ $product->sku }}</td>
                            </tr>
                            <tr>
                                <th>Catalogue</th>
                                <td>{{ $product->catalogue->name }}</td>
                            </tr>
                            <tr>
                                <th>Brand</th>
                                <td>{{ $product->brand->name }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{ "$minPrice$ - $maxPrice$" }}</td>
                            </tr>
                            <tr>
                                <th>Stock</th>
                                <td>{{ $totalStock }}</td>
                            </tr>
                            <tr>
                                <th>Sold</th>
                                <td>{{ $product->sell_count }}</td>
                            </tr>
                            <tr>
                                <th>View</th>
                                <td>{{ $product->view }} <i class="fa-solid fa-eye"></i></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>
                                    <textarea class="form-control" aria-label="With textarea" disabled>{{ $product->description }}</textarea>
                                </td>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Variant -->
    <div class="row mt-4">
        <div class="card">
            <h3 class="card-header">Variant</h3>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Size</th>
                            <th scope="col">Color</th>
                            <th scope="col">Price regular</th>
                            <th scope="col">Price sale</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Sale status</th>
                            <th scope="col">Active status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->productVariants as $key => $variant)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $variant->variantSize->size }}</td>
                            <td>
                                {{ $variant->variantColor->color}}
                            </td>
                            <td>{{ $variant->price_regular }}$</td>
                            <td>{{ $variant->price_sale === null ? $variant->price_regular :  $variant->price_sale}}$</td>
                            <td>{{ $variant->stock }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDisabled" disabled {{$variant->is_sale ? 'checked' : ''}}>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDisabled" disabled {{$variant->is_active ? 'checked' : ''}}>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- file Javascript -->
@section('script')
@endsection