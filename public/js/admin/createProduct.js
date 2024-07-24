// < !--Add Product-- >
const onAddProduct = function () {
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
    formData.set('name', name.value);
    formData.set('brand_id', brand_id.value);
    formData.set('catalogue_id', catalogue_id.value);
    formData.set('sku', sku.value);
    formData.set('slug', slug.value);
    formData.set('description', description.value);
    formData.set('content', content.value);
    formData.set('is_active', is_active);
    formData.set('thumbnail', thumbnail.files[0]);
    for (let i = 0; i < gallery.length; i++) {
        formData.append('gallery[]', gallery[i]);
    }
    formData.set('variants', JSON.stringify(variants));

    // Handle Request
    function successCallback(res) {
        setTimeout(() => {
            if (confirm('Do you want to add more product?')) {
                window.location.reload();
            } else {
                window.location.href = "{{ $httpReferer }}";
            }
        }, 1500);
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
    postFormData(routeCreate, formData, successCallback, errorCallback);
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

// < !-- // Show image when user select -->
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
