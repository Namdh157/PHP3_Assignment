@extends('layouts.admin')
@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-end">
        <button class="btn btn btn-success px-4" onclick="onPostUser()">Save</button>
    </div>
    <hr>
    <div class="row">
        <!-- Left -->
        <div class="col-7">
            <!-- Infor -->
            <div class="card shadow">
                <div class="card-header fw-bold">User information</div>
                <div class="card-body">
                    <!-- Name -->
                    <div class="row mb-3">
                        <div class="group">
                            <div class="input-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $user->name}}">
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right -->
        <div class="col-5">
            <!-- Active status -->
            <div class="card shadow">
                <div class="card-header fw-bold d-flex justify-content-between " id="active-container">
                    <span>Active</span>
                    <div class="form-check form-switch">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Show fullview image -->
@include('common.fullView')

<form action="{{route('admin.catalogue.store')}}" method="post" id="postForm">
    @csrf
</form>
@section('script')
<!-- config scripts -->
<script>
    const route = "{{ $routePostTo }}";
    const method = "{{ $method }}";
    const httpReferer = "{{ $httpReferer }}";
</script>

<!-- Handler script -->
<script>
    function successCallback(res) {
    setTimeout(() => {
        if (confirm('Do you want to add more product?')) {
            window.location.reload();
        } else {
            window.location.href = httpReferer;
        }
    }, 1500);
}

    function onChangeActive(checkbox) {
        const activeContainer = document.getElementById('active-container');
        if (checkbox.checked) activeContainer.classList.add('bg-info');
        else activeContainer.classList.contains('bg-info') && activeContainer.classList.remove('bg-info');
    }
    const onPostCatalogue = function() {
        const fieldsInforNeedValid = {
            name: document.getElementById('name'),
        }
        // User Information
        const is_active = document.getElementById('is_active').checked ? 1 : 0
        const formData = new FormData(document.querySelector('#postForm'));
        formData.set('name', fieldsInforNeedValid.name.value);
        formData.set('is_active', is_active);

        // Handle Request
        function errorCallback(errors) {
            console.log(errors);
            setErrorValidate(fieldsInforNeedValid, errors || {}); // Set error for catalogue information
        }
        // Send request
        console.log(route);
        postFormData(route, formData, successCallback, errorCallback, method);
    }
</script>
@endsection