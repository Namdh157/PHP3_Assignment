async function postFormData(route, formData , callBackSuccess = null, callBackError = null, method = 'POST') {
    // Transform method to POST if method is DELETE, PATCH, PUT
    const otherMethod = ['DELETE', 'PATCH', 'PUT'];
    if(otherMethod.includes(method.toUpperCase())){
        formData.set('_method', method);
        method = 'POST';
    }

    loading().on();
    try {
        const response = await fetch(route, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            method,
            body: formData,
        });
        const result = await response.json();
        if (result.success) {
            ToastCustom(result.success);
            callBackSuccess && callBackSuccess(result.data);
        } else throw new Error(JSON.stringify(result));
    } catch (error) {
        const response = JSON.parse(error.message);
        console.log('Error:', response);
        callBackError && callBackError(response.data);
        ToastCustom(response.error || 'Something went wrong', 'error');
    } finally {
        loading().off();
    }
}

function setErrorValidate(fieldsNeedValid, errors = {}) {
    for (const field in fieldsNeedValid) {
        const error = fieldsNeedValid[field].closest('.group').querySelector('.error');
        let errorText = '';
        if (errors[field]) {
            errorText = errors[field][0].replace(/\d+\./g, '')
        }
        error.innerHTML = errorText;
    }
}

function confirmDelete(event) {
    event.preventDefault();
    if (confirm('Are you sure to DELETE this item?')) {
        event.target.submit();
        loading().on();
    }
}
