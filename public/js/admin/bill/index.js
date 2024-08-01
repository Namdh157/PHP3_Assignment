let prevSelect = null;

function onFocusSelect(e) {
    prevSelect = e.target.value;
}

function onChangeSelect(e) {
    if (confirm(`Change to ${e.target.value.toUpperCase()}?`)) {
        onChangeStatus(e.target);
        return;
    }
    e.target.value = prevSelect;
}

function onChangeStatus(target) {
    const formData = new FormData(document.querySelector('#change-status-form'));
    formData.set('status', target.value);
    formData.set('prev_status', prevSelect);
    formData.set('id', target.getAttribute('data-bill-id'));

    function callBackError(data) {
        target.value = data?.prev_status;
    }

    function callBackSuccess() {
        setBgSelect(target);
    }
    postFormData(routeUpdateOne, formData, callBackSuccess, callBackError, 'PATCH');
}

function onChooseBill(url) {
    window.location.href = url;
}

function setBgSelect(target) {
    if (!target) return;
    let bg = '';
    switch (target.value) {
        case 'completed':
            bg = '#1cb681';
            break;
        case 'canceled':
            bg = '#000';
            break;
        case 'pending':
            bg = '#f93e3e';
            break;
        case 'shipping':
            bg = '#34a6b2';
            break;
    }
    target.style.backgroundColor = bg;
};

(() => {
    document.querySelectorAll('select[data-bill-id]').forEach(select => {
        setBgSelect(select);
    });
})();