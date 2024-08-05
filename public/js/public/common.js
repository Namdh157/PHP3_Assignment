async function sendRequest(route, data, method, callBackSuccess, callBackError) {
    loading().on();
    try {
   
        const response = await fetch(route, {
            method: method || 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });
       
        
        const result = await response.json();
        if (result.success) {
            // ToastCustom(result.success);
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