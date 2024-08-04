function onPostBanner() {
    const fieldsNeedValid = {
        name: document.querySelector('input[name="name"]'),
        width: document.querySelector('input[name="width"]'),
        height: document.querySelector('input[name="height"]'),
        object_fit: document.querySelector('select[name="object_fit"]'),
    };
    const isActive = document.querySelector('input[name="is_active"]').checked ? 1 : 0;
    const formData = new FormData(document.querySelector('#postForm'));
    // Set formdata
    for (const key in fieldsNeedValid) {
        formData.set(key, fieldsNeedValid[key].value);
    }
    // Nếu không có ảnh thì dừng lại và thông báo
    if (listGallery.length == 0) {
        ToastCustom('Please choose image for slide', 'error');
        return;
    }
    // Nếu có ảnh thì thêm vào formdata
    for (let i = 0; i < listGallery.length; i++) {
        formData.append('gallery[]', listGallery[i]);
    }
    formData.set('is_active', isActive);

    const errorCallback = function (errors) {
        // Set error (thêm trường gallery vào danh sách cần validate)
        let needValid = {
            ...fieldsNeedValid,
            gallery: document.querySelector('input[name="gallery"]')
        };
        setErrorValidate(needValid, errors);
    }
    const successCallback = function () {
        window.location.href = httpReferer;
    }
    postFormData(routePost, formData, successCallback, errorCallback, method);
}