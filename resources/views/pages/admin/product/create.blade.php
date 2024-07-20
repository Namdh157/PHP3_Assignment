@extends('layouts.admin')
@section('content')

<div class="container mt-3">
    <div class="d-flex justify-content-between">
        <div class="d-flex gap-2 align-items-center">
            <a href="{{ $httpReferer }}" class="fs-6 btn btn-primary">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h3>Add Product</h3>
        </div>
        <button class="btn btn-success" onclick="onAddProduct()">Save</button>
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

<!-- Add Product -->
<script>
    const onAddProduct = function() {
        // Product Information
        const name = document.getElementById('name');
        const brand_id = document.getElementById('brand');
        const catalogue_id = document.getElementById('catalogue');
        const sku = document.getElementById('sku');
        const slug = document.getElementById('slug');
        const description = document.querySelector('textarea[name="description"]');
        const content = document.querySelector('textarea[name="content"]');
        const is_active = document.getElementById('is_active').checked ? 1 : 0;
        const thumbnail = document.getElementById('thumbnail-input');
        const gallery = document.getElementById('gallery').files;
        const variants = [];
        const variantItems = document.querySelectorAll('#variant-container > [data-variant]');
        const fieldsInforNeedValid = {
            name,
            brand_id,
            catalogue_id,
            sku,
            slug,
            thumbnail
        }

        // Variant
        const fieldsVariantNeedValid = [];
        variantItems.forEach((variant, index) => {
            const size = variant.querySelector('input[name="size"]');
            const color = variant.querySelector('input[name="color"]');
            const stock = variant.querySelector('input[name="stock"]');
            const price_regular = variant.querySelector('input[name="price_regular"]');
            const price_sale = variant.querySelector('input[name="price_sale"]');
            const is_active = variant.querySelector('input[name="is_active"]').checked;

            let field = {};
            field[`${index}.size`] = size;
            field[`${index}.color`] = color;
            field[`${index}.stock`] = stock;
            field[`${index}.price_regular`] = price_regular;
            field[`${index}.price_sale`] = price_sale;
            fieldsVariantNeedValid.push(field);

            variants.push({
                size: size.value.toUpperCase(),
                color: color.value.toLowerCase(),
                stock: stock.value,
                price_regular: price_regular.value,
                price_sale: price_sale.value === '' ? price_regular.value : price_sale.value,
                is_active: is_active ? 1 : 0
            });
        })

        const isSameVariant = variants.some((variant, index) => {
            return variants.findIndex((v, i) => {
                return v.size === variant.size && v.color === variant.color && i !== index;
            }) !== -1;
        });
        if (isSameVariant) {
            ToastCustom('Exist the same variant', 'error');
            return;
        }

        const formData = new FormData(document.querySelector('#addForm'));
        formData.append('name', name.value);
        formData.append('brand_id', brand_id.value);
        formData.append('catalogue_id', catalogue_id.value);
        formData.append('sku', sku.value);
        formData.append('slug', slug.value);
        formData.append('description', description.value);
        formData.append('content', content.value);
        formData.append('is_active', is_active);
        formData.append('thumbnail', thumbnail.files[0]);
        for (let i = 0; i < gallery.length; i++) {
            formData.append('gallery[]', gallery[i]);
        }
        formData.append('variants', JSON.stringify(variants));

        // Handle Request
        function successCallback (res) {
            setTimeout(() => {
                if (confirm('Do you want to add more product?')) {
                    window.location.reload();
                } else {
                    window.location.href = "{{ $httpReferer }}";
                }
            },1500);
        }
        function errorCallback(errors) {
            setErrorValidate(fieldsInforNeedValid, errors.product || {});
            if (fieldsVariantNeedValid.length > 0) {
                fieldsVariantNeedValid.forEach((field, index) => {
                    setErrorValidate(field, errors.variant || {});
                });
            }
        }
        // Send request
        postFormData("{{ route('admin.product.store') }}", formData, successCallback, errorCallback);
    }
</script>

<!-- Event Handlers -->
<script>
    function onRenderSlug(button) {
        const slug = document.getElementById('slug');
        const name = button.closest('.group').querySelector('input[name="name"]').value;
        const slugValue = name.toLowerCase().replace(/ /g, '-').replace(/[^a-zA-Z0-9-]/g, '');
        slug.value = slugValue;
    }

    function onChangeActive(checkbox) {
        const activeContainer = document.getElementById('active-container');
        if (checkbox.checked) activeContainer.classList.add('bg-info');
        else activeContainer.classList.contains('bg-info') && activeContainer.classList.remove('bg-info');
    }

    function generateRandomSku() {
        const sku = document.getElementById('sku');
        const randomSku = Math.random().toString(36).substring(2, 12).toUpperCase();
        sku.value = randomSku;
    }
</script>

<!-- Variant -->
<script>
    function deleteVariant(btn) {
        const variant = btn.parentElement;
        variant.remove();
    }
    (() => {
        const variantContainer = document.getElementById('variant-container');
        const addVariantBtn = document.querySelector('#add-variant-btn');
        let variantIndex = 0;
        addVariantBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const variant = document.createElement('div');
            variant.classList.add('mt-3', 'mb-3', 'row', 'row-cols-3', 'shadow', 'mx-3', 'pt-5', 'border', 'border-1', 'rounded', 'position-relative');
            variant.id = `variant-${variantIndex}`;
            variant.dataset.variant = variantIndex;
            variant.innerHTML = `
                <div class="mb-3 col mx-0 group">
                    <input type="text" class="form-control" id="size-${variantIndex}" name="size" placeholder="Size">
                    <div class="error"></div>
                </div>
                <div class="mb-3 col mx-0 group">
                    <input type="text" class="form-control" id="color-${variantIndex}" name="color" placeholder="Color">
                    <div class="error"></div>
                </div>
                <div class="mb-3 col mx-0 group">
                    <input type="number" class="form-control" id="stock-${variantIndex}" name="stock" placeholder="Stock">
                    <div class="error"></div>
                </div>
                <div class="mb-3 pb-3 col-6 mx-0 group">
                    <div class="input-group">
                        <input type="numer" class="form-control" id="price_regular-${variantIndex}" name="price_regular" placeholder="Origin Price">
                        <span class="input-group-text">$</span>
                    </div>
                    <div class="error"></div>
                </div>
                <div class="mb-3 pb-3 col-6 mx-0 group">
                    <div class="input-group">
                        <input type="number" class="form-control" id="price_sale-${variantIndex}" name="price_sale" placeholder="Price Sale">
                        <span class="input-group-text">$</span>
                    </div>
                    <div class="error"></div>
                </div>
                <button class="btn btn-outline-danger p-1 px-2 position-absolute" style="font-size: 14px; top: 3px; right: 3px; width: max-content" onclick="deleteVariant(this)">X</button>
                <div class="form-check form-switch position-absolute" style="top: 3px; left: 10px">
                    <span class="ms-2 fw-bold">Variant ${variantIndex + 1}</span>
                    <input class="form-check-input" type="checkbox" name="is_active" checked>
                </div>
            `;
            variantContainer.appendChild(variant);
            variantIndex++;
        });
    })();
</script>

<!-- // Show image when user select -->
<script>
    (() => {
        const imageContainer = document.getElementById('image-container');
        const thumbnailImg = document.getElementById('thumbnail-img');
        const formFileMultiple = document.getElementById('gallery');
        const formFileSingle = document.getElementById('thumbnail-input');
        formFileMultiple.addEventListener('change', (e) => {
            const files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '130px';
                    img.classList.add('img-thumbnail', 'mb-3', 'object-fit-contain');
                    imageContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
        formFileSingle.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                thumbnailImg.src = e.target.result;
            }
            reader.readAsDataURL(file);
        });
    })();
</script>

@endsection