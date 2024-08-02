@extends('layouts.admin')
@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-end">
        <button class="btn btn btn-success px-4" onclick="onPostBrand()">Save</button>
    </div>
    <hr>
    <div class="row">
        <!-- Left -->
        <div class="col-7">
            <!-- Infor -->
            <div class="card shadow">
                <div class="card-header fw-bold">Brand information</div>
                <div class="card-body">
                    <!-- Name -->
                    <div class="row mb-3">
                        <div class="group">
                            <div class="input-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ isset($brand) ? $brand->name : ''}}">
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
                <div class="card-header fw-bold d-flex justify-content-between {{ isset($brand) && $brand->is_active ? 'bg-info' : ''}}" id="active-container">
                    <span>Active</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ isset($brand) && $brand->is_active ? 'checked' : ''}} onchange="onChangeActive(this)">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<form action="{{route('admin.brand.store')}}" method="post" id="postForm">
    @csrf
</form>
@section('script')
<!-- config scripts -->
<script>
    const route = "{{ $routePostTo }}";
    const method = "{{ $method }}";
    const httpReferer = "{{ $httpReferer }}";
    let successCallback = () => window.location.href = httpReferer;
</script>

@if (isset($isContinue) && $isContinue)
<script>
    successCallback = function(res) {
        setTimeout(() => {
            if (confirm('Do you want to add more brand?')) {
                window.location.reload();
            } else {
                window.location.href = httpReferer;
            }
        }, 1200);
    }
</script>
@endif

<!-- Handler script -->
<script>
    function onChangeActive(checkbox) {
        const activeContainer = document.getElementById('active-container');
        if (checkbox.checked) activeContainer.classList.add('bg-info');
        else activeContainer.classList.contains('bg-info') && activeContainer.classList.remove('bg-info');
    }

    const onPostBrand = function() {
        const fieldsInforNeedValid = {
            name: document.getElementById('name'),
        }
        // brand Information
        const is_active = document.getElementById('is_active').checked ? 1 : 0
        const formData = new FormData(document.querySelector('#postForm'));
        formData.set('name', fieldsInforNeedValid.name.value);
        formData.set('is_active', is_active);
        console.log(fieldsInforNeedValid.name.value);

        // Handle Request
        function errorCallback(errors) {
            console.log('Error:', errors);
            setErrorValidate(fieldsInforNeedValid, errors || {}); // Set error for brand information
        }
        // Send request
        postFormData(route, formData, successCallback, errorCallback, method);
    }
</script>
@endsection