@extends('layouts.admin')
@section('content')

<div class="container mt-3">
    <div class="d-flex justify-content-end">
        <button class="btn btn-success px-4" onclick="onPostProduct()">Save</button>
    </div>
    <hr>
    <div class="row">
        <!-- Left -->
        <div class="col-7">
            <!-- Infor -->
            <div class="card shadow">
                <div class="card-header fw-bold">Product information</div>
                <div class="card-body">
                    <!-- Name -->
                    <div class="row mb-3">
                        <div class="group">
                            <div class="input-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ isset($product) ? $product->name : ''}}">
                                <button class="btn btn-secondary input-group-text" id="basic-addon1" onclick="onRenderSlug(this)">
                                    <i class="fa-solid fa-link"></i>
                                    <span> Use as Slug</span>
                                </button>
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>

                    <!-- Brand - Catalogue -->
                    <div class="row mb-3">
                        <div class="col-6 group">
                            <select class="form-select" name="brand" id="brand">
                                <option {{isset($product)?'':'selected'}}>Choose Brand</option>
                                @foreach ($allBrands as $key => $brand)
                                <option value="{{$brand->id}}" {{ isset($product) && $product->brand_id == $brand->id ? 'selected' : ''}}>{{$brand->name}}</option>
                                @endforeach
                            </select>
                            <div class="error"></div>
                        </div>
                        <div class="col-6 group">
                            <select class="form-select" name="catalogue" id="catalogue">
                                <option {{isset($product)?'':'selected'}}>Choose Catalogue</option>
                                @foreach ($allCatalogues as $key => $catalogue)
                                <option value="{{$catalogue->id}}" {{ isset($product) && $product->catalogue_id == $catalogue->id ? 'selected' : ''}}>{{$catalogue->name}}</option>
                                @endforeach
                            </select>
                            <div class="error"></div>
                        </div>
                    </div>

                    <!-- Slug - Sku -->
                    <div class="row mb-3">
                        <div class="col-6 group">
                            <label for="sku" class="form-label fw-bold">SKU</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="sku" name="sku" placeholder="ex: 2U99VABUKZ" value="{{ isset($product) ? $product->sku : ''}}">
                                <button class="btn btn-secondary input-group-text" id="basic-addon1" onclick="generateRandomSku()">
                                    <i class="fa-solid fa-shuffle"></i>
                                </button>
                            </div>
                            <div class="error"></div>
                        </div>
                        <div class="col-6 group">
                            <label for="slug" class="form-label fw-bold">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="ex: t-shirt-1998" value="{{ isset($product) ? $product->slug : ''}}">
                            <div class="error"></div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <!-- <label for="description" class="form-label">Description</label> -->
                        <textarea class="form-control" name="description" placeholder="Type your description...">{{ isset($product) ? $product->description : ''}}</textarea>
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <!-- <label for="content" class="form-label">Content</label> -->
                        <textarea class="form-control" rows="5" name="content" placeholder="Type your content...">{{ isset($product) ? $product->description : ''}}</textarea>
                    </div>
                </div>
            </div>

            <!-- Variant -->
            <div class="card shadow mt-5">
                <div class="card-header fw-bold">Variant</div>
                <div class="card-body">
                    <!-- Variant Container -->
                    <div id="variant-container">
                        <!-- Nếu là edit và có $variant thì hiển thị -->
                        @if (isset($variants))
                        @foreach ($variants as $index => $variant)
                        <div class="mt-3 mb-3 row row-cols-3 shadow mx-3 pt-5 border border-1 rounded position-relative" data-variant="{{$index}}" data-variant-id="{{$variant->id}}">
                            <div class="mb-3 col mx-0 group">
                                <div class="input-group">
                                    <span class="input-group-text">Size</span>
                                    <input type="text" class="form-control" name="size" value="{{$variant->variantSize->size}}">
                                </div>
                                <div class="error"></div>
                            </div>
                            <div class="mb-3 col mx-0 group">
                                <div class="input-group">
                                    <span class="input-group-text">Color</span>
                                    <input type="text" class="form-control" name="color" value="{{$variant->variantColor->color}}">
                                </div>
                                <div class="error"></div>
                            </div>
                            <div class="mb-3 col mx-0 group">
                                <div class="input-group">
                                    <span class="input-group-text">Stock</span>
                                    <input type="number" class="form-control" name="stock" value="{{$variant->stock}}">
                                </div>
                                <div class="error"></div>
                            </div>
                            <div class="mb-3 pb-3 col-6 mx-0 group">
                                <div class="input-group">
                                    <span class="input-group-text">Original price</span>
                                    <input type="numer" class="form-control" name="price_regular" value="{{$variant->price_regular}}">
                                    <span class="input-group-text">$</span>
                                </div>
                                <div class="error"></div>
                            </div>
                            <div class="mb-3 pb-3 col-6 mx-0 group">
                                <div class="input-group">
                                    <span class="input-group-text">Sale price</span>
                                    <input type="number" class="form-control" name="price_sale" value="{{$variant->price_sale}}">
                                    <span class="input-group-text">$</span>
                                </div>
                                <div class="error"></div>
                            </div>
                            <button class="btn btn-outline-danger p-1 px-2 position-absolute" style="font-size: 14px; top: 3px; right: 3px; width: max-content" onclick="deleteVariant(this)" data-variant-id="{{$variant->id}}">X</button>
                            <div class="form-check form-switch position-absolute" style="top: 3px; left: 10px">
                                <span class="ms-2 fw-bold">Variant {{$index+1}}</span>
                                <input class="form-check-input" type="checkbox" name="is_active" {{$variant->is_active == 1 ? 'checked':''}}>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <button class="btn btn-outline-primary" onclick="onAddVariant()">
                        <i class="fa-solid fa-plus" style="font-size: 12px;"></i> Add an variant
                    </button>
                </div>
            </div>

        </div>

        <!-- Right -->
        <div class="col-5">
            <!-- Active status -->
            <div class="card shadow">
                <div class="card-header fw-bold d-flex justify-content-between {{ isset($product) && $product->is_active ? 'bg-info' : ''}}" id="active-container">
                    <span>Active</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ isset($product) && $product->is_active ? 'checked' : ''}} onchange="onChangeActive(this)">
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="card shadow mt-5">
                <div class="card-header fw-bold">Media</div>
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="mb-3 group">
                        <label for="thumbnail-input" class="form-label">Thumbnail</label>
                        <input class="form-control" type="file" id="thumbnail-input" accept="image/*" onchange="onChangeSingleImage(event)" />
                        <label for="thumbnail-input">
                            <img src="{{isset($product)?asset($product->image_thumbnail):''}}" class="object-fit-contain mt-3 img-thumbnail" style="height: 100px;" id="thumbnail-img" alt="">
                        </label>
                        <div class="error"></div>
                    </div>

                    <!-- Image container -->
                    <div class="mb-3 mt-5">
                        <label for="gallery" class="form-label">Gallery</label>
                        <input class="form-control" type="file" id="gallery" accept="image/*" multiple onchange="onChangeMultipleImage(event)" />
                        <div id="image-container" class="d-flex gap-3 column-gap-2 mt-2 flex-wrap">
                            @if (isset($gallery))
                            @foreach ($gallery as $key => $image)
                            <div class="d-flex flex-column shadow-sm image-group">
                                <img src="{{asset($image->image)}}" alt="" class="img-thumnail mb-3 object-fit-contain" style="width: 130px">
                                <div class="hstack justify-content-evenly">
                                    <button class="btn" onclick="showFullViewImage('{{asset($image->image)}}')">
                                        <i class="fa-solid fa-eye text-info"></i>
                                    </button>
                                    <span class="vr"></span>
                                    <button class="btn" onclick="removeImage(this)" data-gallery-id="{{$image->id}}">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Show fullview image -->
@include('common.fullView')

<form action="{{route('admin.product.store')}}" method="post" id="postForm">
    @csrf
</form>
@endsection

@section('script')
<!-- Config script -->
<script>
    const routePost = "{{ $routePostTo }}";
    const method = "{{ $method }}";
    const httpReferer = "{{ $httpReferer }}";
    let variantIndex = Number("{{isset($variants)?count($variants):0}}");
</script>
<!-- Handler script -->
<script src="{{$js}}"></script>
<script src="{{asset('js/admin/product/product.js')}}"></script>
@endsection