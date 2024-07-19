@extends('layouts.admin')
@section('content')

<div class="container mt-3">
    <div class="d-flex justify-content-between">
        <h3>Add Product</h3>
        <button class="btn btn-success">Save <i class="fa-solid fa-plus" style="font-size: 12px"></i></button>
    </div>
    <hr>
    <div class="row">
        <div class="col-7">
            <!-- Infor -->
            <div class="card shadow">
                <div class="card-header">Product information</div>
                <div class="card-body">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <!-- Slug - Sku -->
                    <div class="input-group gap-2 mb-3">
                        <div class="mb-3 flex-fill">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" disabled id="sku" name="sku" value="{{ $sku }}">
                        </div>
                        <div class="mb-3 flex-fill">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" aria-label="With textarea" name="description" placeholder="Type your description..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Variant -->
            <div class="card shadow mt-5">
                <div class="card-header">Variant</div>
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

        <div class="col-5">
            <div class="card shadow">
                <!-- Media -->
                <div class="card-header">Media</div>
                <div class="card-body">
                    <input class="form-control" type="file" id="formFileMultiple" multiple />
                    <!-- Image container -->
                    <div id="image-container" class="d-flex gap-2 mt-2 flex-wrap">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
            variant.classList.add('mt-3', 'mb-3', 'd-flex', 'gap-2', 'shadow', 'p-3', 'rounded', 'position-relative');
            variant.id = `variant-${variantIndex++}`;
            variant.innerHTML = `
                <div class="mb-3">
                    <label for="size" class="form-label">Size</label>
                    <input type="text" class="form-control" id="size" name="size">
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control" id="color" name="color">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price">
                </div>
                <button class="btn p-1 px-2 position-absolute" style="font-size: 14px; top: 3px; right: 3px" onclick="deleteVariant(this)">X</button>
            `;
            variantContainer.appendChild(variant);
        });
    })();

    (() => {
        // Show image when user select
        const imageContainer = document.getElementById('image-container');
        const formFileMultiple = document.getElementById('formFileMultiple');
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
    })();
</script>

@endsection