function successCallback(res) {
    setTimeout(() => {
        if (confirm('Do you want to add more product?')) {
            window.location.reload();
        } else {
            window.location.href = httpReferer;
        }
    }, 1500);
}