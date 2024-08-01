function loading() {
    const loadingSpiner = document.getElementById('loading-spiner');
    return {
        on: () => {
            loadingSpiner.classList.add('active')
        },
        off: () => {
            loadingSpiner.classList.contains('active') && loadingSpiner.classList.remove('active')
        }
    }
}

// Toast
function ToastCustom(message, type = 'success') {
    let bg = '#198754';
    switch (type) {
        case 'success':
            bg = '#198754';
            break;
        case 'error':
            bg = '#dc3545';
            break;
        case 'warning':
            bg = '#ffc107';
            break;
        case 'info':
            bg = '#0dcaf0';
            break;
    }

    Toastify({
        text: message,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top",
        position: 'right',
        style: {
            background: bg,
        },
        stopOnFocus: true,
    }).showToast();
};
