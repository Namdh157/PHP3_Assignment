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
    const formData = new FormData(document.querySelector('#change-role-form'));
    formData.set('role', target.value);
    formData.set('prev_role', prevSelect);
    formData.set('id', target.getAttribute('data-user-id'));

    function callBackError(data) {
        target.value = data?.prev_status;
    }

    function callBackSuccess() {
        setBgSelect(target);
    }
    postFormData(routeUpdateRole, formData, callBackSuccess, callBackError, 'PATCH');
}

function onChooseBill(url) {
    window.location.href = url;
}

function setBgSelect(target) {
    if (!target) return;
    let bg = '';
    switch (target.value) {
        case 'admin':
            bg = '#0984e3';
            break;
        case 'member':
            bg = '#2d3436';
            break;
    }
    target.style.backgroundColor = bg;
};

(() => {
    document.querySelectorAll('select[data-user-id]').forEach(select => {
        setBgSelect(select);
    });
})();