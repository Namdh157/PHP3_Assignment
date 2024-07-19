@extends('layouts.admin')
@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
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
                        <div class="col">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>
                    </div>

                    <!-- Brand - Catalogue -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <select class="form-select" name="brand" id="brand">
                                <option selected>Choose Brand</option>
                                @foreach ($allBrands as $key => $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-select" name="catalogue" id="catalogue">
                                <option selected>Choose Catalogue</option>
                                @foreach ($allCatalogues as $key => $catalogue)
                                <option value="{{$catalogue->id}}">{{$catalogue->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Slug - Sku -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="sku" class="form-label fw-bold">SKU</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="sku" name="sku" placeholder="ex: 2U99VABUKZ">
                                <button class="btn btn-secondary input-group-text" id="basic-addon1" onclick="generateRandomSku()">
                                    <i class="fa-solid fa-shuffle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="slug" class="form-label fw-bold">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="ex: t-shirt-1998">
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
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input class="form-control" type="file" id="thumbnail-input" accept="image/*" />
                        <img src="" class="object-fit-contain mt-3 img-thumbnail" style="height: 100px;" id="thumbnail-img" alt="">
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<!-- Add Product -->
<script>
    const onAddProduct = function() {
        const name = document.getElementById('name').value;
        const brand = document.getElementById('brand').value;
        const catalogue = document.getElementById('catalogue').value;
        const sku = document.getElementById('sku').value;
        const slug = document.getElementById('slug').value;
        const description = document.querySelector('textarea[name="description"]').value;
        const content = document.querySelector('textarea[name="content"]').value;
        const is_active = document.getElementById('is_active').checked ? 1 : 0;
        const thumbnail = document.getElementById('thumbnail-input').files[0];
        const gallery = document.getElementById('gallery').files;
        const variants = [];
        const variantItems = document.querySelectorAll('#variant-container > [data-variant]');


        variantItems.forEach(variant => {
            const size = variant.querySelector('input[name="size"]').value;
            const color = variant.querySelector('input[name="color"]').value;
            const stock = variant.querySelector('input[name="stock"]').value;
            const price_regular = variant.querySelector('input[name="price_regular"]').value;
            const price_sale = variant.querySelector('input[name="price_sale"]').value;
            const is_active = variant.querySelector('input[name="is_active"]').checked;
            variants.push({
                size: size.toUpperCase(),
                color: color.toLowerCase(),
                stock,
                price_regular,
                price_sale,
                is_active
            });
        })
        console.log("Variants: ", variants);

        // Validate same variant
        const isSameVariant = variants.some((variant, index) => {
            return variants.findIndex((v, i) => {
                return v.size === variant.size && v.color === variant.color && i !== index;
            }) !== -1;
        });
        if (isSameVariant) {
            alert('Please check your variant');
            return;
        }

        const formData = new FormData(document.querySelector('#addForm'));
        formData.append('name', name);
        formData.append('brand_id', brand);
        formData.append('catalogue_id', catalogue);
        formData.append('sku', sku);
        formData.append('slug', slug);
        formData.append('description', description);
        formData.append('content', content);
        formData.append('is_active', is_active);
        formData.append('thumbnail', thumbnail);
        for (let i = 0; i < gallery.length; i++) {
            formData.append('gallery[]', gallery[i]);
        }
        formData.append('variants', JSON.stringify(variants));

        fetch("{{ route('admin.product.store') }}", {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    Toastify({
                        text: data.success,
                        duration: 3000,
                        destination: "https://github.com/apvarun/toastify-js",
                        newWindow: true,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        style: {
                            background: "green",
                        }
                    }).showToast();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Toastify({
                    text: "Something went wrong",
                    duration: 3000,
                    destination: "https://github.com/apvarun/toastify-js",
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    style: {
                        background: "red",
                    }
                }).showToast();
            });
    }
</script>

<!-- Event Handlers -->
<script>
    const onChangeActive = function(checkbox) {
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
                <div class="mb-3 col mx-0">
                    <input type="text" class="form-control" id="size-${variantIndex}" name="size" placeholder="Size">
                </div>
                <div class="mb-3 col mx-0">
                    <input type="text" class="form-control" id="color-${variantIndex}" name="color" placeholder="Color">
                </div>
                <div class="mb-3 col mx-0">
                    <input type="number" class="form-control" id="stock-${variantIndex}" name="stock" placeholder="Stock">
                </div>
                <div class="mb-3 col-6 mx-0">
                    <div class="input-group mb-3">
                        <input type="numer" class="form-control" id="price_regular-${variantIndex}" name="price_regular" placeholder="Price Original">
                        <span class="input-group-text">$</span>
                    </div>
                </div>
                <div class="mb-3 col-6 mx-0">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="price_sale-${variantIndex}" name="price_sale" placeholder="Price Sale">
                        <span class="input-group-text">$</span>
                    </div>
                </div>
                <button class="btn btn-outline-danger p-1 px-2 position-absolute" style="font-size: 14px; top: 3px; right: 3px; width: max-content" onclick="deleteVariant(this)">X</button>
                <div class="form-check form-switch position-absolute" style="top: 3px; left: 10px">
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