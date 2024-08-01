@extends('layouts.admin')

<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.product.create') }}" class="btn btn-success my-3">
                Add new <i class="fa-solid fa-plus"></i>
            </a>
            <div class="d-flex gap-2" style="height: max-content">
                <select class="form-select" id="select-action">
                    <option value="" selected>-- Action --</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="delete">Delete</option>
                </select>
                <button class="btn btn-outline-success" id="select-submit">Submit</button>
            </div>
        </div>

        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr class="table-primary">
                    <th class="">
                        <input class="form-check-input" type="checkbox" id="checked-all">
                    </th>
                    <th class="">SKU</th>
                    <th class="">Product</th>
                    <th class="">Catalogue</th>
                    <th class="">Brand</th>
                    <th class="">Variant</th>
                    <th class="">Active</th>
                    <th class="">Updated</th>
                    <th class="">Created</th>
                    <th class="">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                <tr>
                    <td class="position-relative">
                        <label for="check-item-{{$index}}" class="position-absolute top-0 start-0 w-100 h-100 z-3"></label>
                        <input class="form-check-input" type="checkbox" value="{{$product->id}}" name="check-item" id="check-item-{{$index}}">
                    </td>
                    <td>{{ $product->sku }}</td>
                    <td style="max-width: 250px">
                        <img src="{{asset($product->image_thumbnail)}}" alt="" class="object-fit-contain rounded-3" style="width: 50px; height: 50px">
                        <a href="{{ route('public.product.detail', $product->slug) }}" class="link-offset-2 text-decoration-none" style="--bs-link-hover-color-rgb: 25, 135, 84;">
                            <span class="fw-bold">{{ $product->name }}</span>
                        </a>
                    </td>
                    <td style="max-width: 100px">{{ $product->catalogue->name }}</td>
                    <td style="max-width: 100px">{{ $product->brand->name }}</td>
                    <td class="text-center">{{ $product->product_variants_count }}</td>
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" onclick="((e)=>{e.preventDefault()})(event)" {{$product->is_active ? 'checked':''}} name="active-item">
                    </td>
                    <td>
                        <span class="text-muted text-nowrap">{{ $product->updated_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <span class="text-muted text-nowrap">{{ $product->created_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-outline-info">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('admin.product.destroy', $product) }}" method="POST" style="display:inline" onsubmit="confirmDelete(event)">
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

@section('script')
<!-- Config Script -->
<script>
    const routeUpdate = "{{ route('api.product.updateStatus') }}";
    const routeDelete = "{{ route('api.product.deleteMany') }}";
    const httpReferer = "{{isset($httpReferer)? $httpReferer : asset('admin.product.index')}}"
</script>
<!-- Handler -->
<script src="{{asset('js/admin/selectIndex.js')}}"></script>
@endsection