const arrDeleteVariant = [];
const arrDeleteGallery = [];
const listGallery = {};
let galleryIndex = 0;

// < !--Post Product-- >
const onPostProduct = function () {
    const fieldsInforNeedValid = {
        name: document.getElementById('name'),
        brand_id: document.getElementById('brand'),
        catalogue_id: document.getElementById('catalogue'),
        sku: document.getElementById('sku'),
        slug: document.getElementById('slug'),
        thumbnail: document.getElementById('thumbnail-input')
    }
    const fieldsVariantNeedValid = [];

    // Product Information
    const description = document.querySelector('textarea[name="description"]');
    const content = document.querySelector('textarea[name="content"]');
    const is_active = document.getElementById('is_active').checked ? 1 : 0;
    // const gallery = document.getElementById('gallery').files;
    const variants = [];
    const variantItems = document.querySelectorAll('#variant-container > [data-variant]');
    
    // Variant
    variantItems.forEach((variant, index) => {
        const variant_id = variant.getAttribute('data-variant-id');
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

        let obj = {
            size: size.value.toUpperCase(),
            color: color.value,
            stock: stock.value,
            price_regular: price_regular.value,
            price_sale: price_sale.value === '' ? price_regular.value : price_sale.value,
            is_active: is_active ? 1 : 0,
        }
        if(variant_id) obj.variant_id = variant_id;
        variants.push(obj);
    })

    const isSameVariant = variants.some((variant, index) => {
        return variants.findIndex((v, i) => {
            return v.size === variant.size && v.color.toLowerCase() === variant.color.toLowerCase() && i !== index;
        }) !== -1;
    });
    if (isSameVariant) {
        ToastCustom('Exist the same variant', 'error');
        return;
    }

    const formData = new FormData(document.querySelector('#postForm'));
    // Product Information
    for (const key in fieldsInforNeedValid) {
        if (key === 'thumbnail') formData.set(key, fieldsInforNeedValid[key].files[0]);
        else formData.set(key, fieldsInforNeedValid[key].value);
    }
    formData.set('description', description.value);
    formData.set('content', content.value);
    formData.set('is_active', is_active);
    // Gallery
    for (let key in listGallery) {
        formData.append('gallery[]', listGallery[key]);
    }
    formData.set('variants', JSON.stringify(variants));
    formData.set('deleteVariant', JSON.stringify(arrDeleteVariant));
    formData.set('deleteGallery', JSON.stringify(arrDeleteGallery));

    // Handle Request
    function errorCallback(errors) {
        setErrorValidate(fieldsInforNeedValid, errors?.product || {}); // Set error for product information

        if (fieldsVariantNeedValid.length > 0) { // Set error for variant
            fieldsVariantNeedValid.forEach((field, index) => {
                setErrorValidate(field, errors?.variant || {});
            });
        }
    }
    // Send request
    postFormData(routePost, formData, successCallback, errorCallback, method);
}

// < !--Event Handlers -->
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

// < !--Variant -->
function deleteVariant(btn) {
    if (!confirm('Do you want to delete this variant?')) return;
    btn.dataset.variantId && arrDeleteVariant.push(btn.dataset.variantId);
    console.log("Delete Variant: ", arrDeleteVariant);
    const variant = btn.closest('[data-variant]');
    variant.remove();
}

function onAddVariant() {
    const variantContainer = document.getElementById('variant-container');
    const variant = document.createElement('div');
    variant.classList.add('mt-3', 'mb-3', 'row', 'row-cols-3', 'shadow', 'mx-3', 'pt-5', 'border', 'border-1', 'rounded', 'position-relative');
    variant.id = `variant-${variantIndex}`;
    variant.dataset.variant = variantIndex;
    variant.innerHTML = `
        <div class="mb-3 col mx-0 group">
            <div class="input-group">
                <span class="input-group-text">Size</span>
                <input type="text" class="form-control" name="size">
            </div>
            <div class="error"></div>
        </div>
        <div class="mb-3 col mx-0 group">
            <div class="input-group">
                <span class="input-group-text">Color</span>
                <input type="text" class="form-control" name="color">
            </div>
            <div class="error"></div>
        </div>
        <div class="mb-3 col mx-0 group">
            <div class="input-group">
                <span class="input-group-text">Stock</span>
                <input type="number" class="form-control" name="stock">
            </div>
            <div class="error"></div>
        </div>
        <div class="mb-3 pb-3 col-6 mx-0 group">
            <div class="input-group">
                <span class="input-group-text">Original price</span>
                <input type="numer" class="form-control" name="price_regular">
                <span class="input-group-text">$</span>
            </div>
            <div class="error"></div>
        </div>
        <div class="mb-3 pb-3 col-6 mx-0 group">
            <div class="input-group">
                <span class="input-group-text">Sale price</span>
                <input type="number" class="form-control" name="price_sale">
                <span class="input-group-text">$</span>
            </div>
            <div class="error"></div>
        </div>
        <button 
            class="btn btn-outline-danger p-1 px-2 position-absolute" 
            style="font-size: 14px; top: 3px; right: 3px; width: max-content" 
            onclick="deleteVariant(this)"
        >X</button>
        <div class="form-check form-switch position-absolute" style="top: 3px; left: 10px">
            <span class="ms-2 fw-bold">Variant ${variantIndex + 1}</span>
            <input class="form-check-input" type="checkbox" name="is_active" checked>
        </div>
    `;
    variantContainer.appendChild(variant);
    variantIndex++;
};

// < !-- // Show image when user select -->

function onChangeMultipleImage(e) {
    const imageContainer = document.getElementById('image-container');
    const files = e.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        listGallery[galleryIndex++] = file;
    }
    for (let i = galleryIndex - files.length; i < galleryIndex; i++) {
        const reader = new FileReader();
        reader.readAsDataURL(listGallery[i]);
        reader.onload = (e) => {
            const html = `
                <div class="d-flex flex-column shadow-sm image-group">
                    <img src="${e.target.result}" alt="" class="img-thumnail mb-3 object-fit-contain" style="width: 130px">
                    <div class="hstack justify-content-evenly">
                        <button class="btn" onclick="showFullViewImage('${e.target.result}')">
                            <i class="fa-solid fa-eye text-info"></i>
                        </button>
                        <span class="vr"></span>
                        <button class="btn" onclick="removeImage(this)" data-index-gallery="${i}">
                            <i class="fa-solid fa-trash text-danger"></i>
                        </button>
                    </div>
                </div>
            `
            imageContainer.innerHTML += html;
        }
    }
    console.log("Post Gallery: ", listGallery);
}

function onChangeSingleImage(e) {
    const thumbnailImg = document.getElementById('thumbnail-img');
    const file = e.target.files[0];
    const reader = new FileReader();
    reader.onload = (e) => {
        thumbnailImg.src = e.target.result;
    }
    reader.readAsDataURL(file);
}

function removeImage(btn) {
    if (!confirm('Do you want to remove this image?')) return;
    const imageGroup = btn.closest('.image-group');
    imageGroup.remove();

    const index = btn.dataset.indexGallery;
    if (index !== undefined) delete listGallery[index];
    console.log("Post Gallery: ", listGallery);

    btn.dataset.galleryId && arrDeleteGallery.push(btn.dataset.galleryId);
    console.log("Delete Gallery: ", arrDeleteGallery);

    ToastCustom('Remove image successfully', 'success');
}