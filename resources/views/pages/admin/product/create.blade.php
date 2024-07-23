@extends('layouts.admin')
@section('content')

<div class="container mt-3">
    <div class="d-flex justify-content-end">
        <button class="btn btn-success px-4" onclick="onAddProduct()">Save</button>
    </div>
    <hr>
    <div class="row">
        <div class="col-7">
            <!-- Infor -->
            <div class="card shadow">
                <div class="card-header fw-bold">Product information</div>
                <div class="card-body">
                    <!-- Name -->
                    <div class="row mb-3">
                        <div class="group">
                            <div class="input-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
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
                                <option selected>Choose Brand</option>
                                @foreach ($allBrands as $key => $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                            <div class="error"></div>
                        </div>
                        <div class="col-6 group">
                            <select class="form-select" name="catalogue" id="catalogue">
                                <option selected>Choose Catalogue</option>
                                @foreach ($allCatalogues as $key => $catalogue)
                                <option value="{{$catalogue->id}}">{{$catalogue->name}}</option>
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
                                <input type="text" class="form-control" id="sku" name="sku" placeholder="ex: 2U99VABUKZ">
                                <button class="btn btn-secondary input-group-text" id="basic-addon1" onclick="generateRandomSku()">
                                    <i class="fa-solid fa-shuffle"></i>
                                </button>
                            </div>
                            <div class="error"></div>
                        </div>
                        <div class="col-6 group">
                            <label for="slug" class="form-label fw-bold">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="ex: t-shirt-1998">
                            <div class="error"></div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <!-- <label for="description" class="form-label">Description</label> -->
                        <textarea class="form-control" name="description" placeholder="Type your description..."></textarea>
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <!-- <label for="content" class="form-label">Content</label> -->
                        <textarea class="form-control" rows="5" name="content" placeholder="Type your content..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Variant -->
            <div class="card shadow mt-5">
                <div class="card-header fw-bold">Variant</div>
                <div class="card-body">
                    <!-- Variant Container -->
                    <div id="variant-container">

                    </div>

                    <button class="btn btn-outline-primary" id="add-variant-btn">
                        <i class="fa-solid fa-plus" style="font-size: 12px;"></i> Add an variant
                    </button>
                </div>
            </div>

        </div>

        <!-- Active status -->
        <div class="col-5">
            <div class="card shadow">
                <div class="card-header fw-bold d-flex justify-content-between bg-info" id="active-container">
                    <span>Active</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked onchange="onChangeActive(this)">
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="card shadow mt-5">
                <div class="card-header fw-bold">Media</div>
                <div class="card-body">
                    <!-- Thumbnail -->
                    <div class="mb-3 group">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input class="form-control" type="file" id="thumbnail-input" accept="image/*" />
                        <img src="" class="object-fit-contain mt-3 img-thumbnail" style="height: 100px;" id="thumbnail-img" alt="">
                        <div class="error"></div>
                    </div>

                    <!-- Image container -->
                    <div class="mb-3 mt-5">
                        <label for="gallery" class="form-label">Gallery</label>
                        <input class="form-control" type="file" id="gallery" accept="image/*" multiple />
                        <div id="image-container" class="d-flex gap-2 mt-2 flex-wrap">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{route('admin.product.store')}}" method="post" id="addForm">
    @csrf
</form>
@endsection

@section('script')
<script>
    const routeCreate = "{{ route('admin.product.store') }}";
</script>
<script src="{{asset('js/admin/createProduct.js')}}"></script>
@endsection