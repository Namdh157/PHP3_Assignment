const checkAll = document.getElementById('checked-all');
const checkItems = document.querySelectorAll('tbody input[name="check-item"]');
const selectAction = document.getElementById('select-action');
const selectSubmit = document.getElementById('select-submit');
const formData = new FormData(document.getElementById('checkbox-form'));

// CheckBox event
if(checkAll) checkAll.onchange = function () {
    checkItems.forEach(checkbox => {
        checkbox.checked = checkAll.checked;
    })
}
if(checkItems) checkItems.forEach(checkbox => {
    checkbox.onchange = function () {
        checkAll.checked = checkItems.length === document.querySelectorAll('tbody input[name="check-item"]:checked').length;
    }
})

// Submit select
if(selectSubmit) selectSubmit.onclick = function () {
    const action = selectAction.value;
    const checkedIds = [];
    checkItems.forEach(checkbox => {
        if (checkbox.checked) {
            checkedIds.push(checkbox.value);
        }
    })
    if (checkedIds.length === 0) {
        ToastCustom('Please select an item', 'error');
        return;
    }

    formData.set('checkedIds', JSON.stringify(checkedIds));
    let route = routeUpdate;
    let method = 'PATCH';
    let callBackSuccess = (res) => {
        document.querySelectorAll('input[name="check-item"]:checked').forEach(checkbox => {
            const tr = checkbox.closest('tr');
            const active = action === 'published' ? true : false;
            if (active) {
                tr.querySelector('input[name="active-item"]')?.setAttribute('checked', '');
            } else tr.querySelector('input[name="active-item"]')?.removeAttribute('checked');
            checkbox.checked = false;
            checkAll.checked = false;
        });
    };

    switch (action) {
        case 'published':
            formData.set('is_active', 1);
            break;
        case 'draft':
            formData.set('is_active', 0);
            break;
        case 'delete':
            if(!routeDelete){
                ToastCustom('Route delete not found', 'error');
                return;
            }
            if (!confirm(`Are you sure you want to DELETE ${checkedIds.length} items?`)) return;
            method = "DELETE";
            route = routeDelete;
            callBackSuccess = (res) => {
                window.location.reload();
            }
            break;
        default:
            ToastCustom('Please select an action', 'error');
            return;
    }
    if(!route){
        ToastCustom('Route not found', 'error');
        return;
    }
    postFormData(route, formData, callBackSuccess, null, method);
}