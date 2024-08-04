@extends('layouts.admin')
@section('content')

<div class="container mt-3">
    <div class="d-flex justify-content-end">
        <button class="btn btn-success px-4" onclick="onPostVoucher()">Save</button>
    </div>
    <hr>
    <div class="card shadow">
        <div class="card-header fw-bold d-flex justify-content-between {{ isset($voucher) && $voucher->is_active ? 'bg-info' : ''}}" id="active-container">
            <span>Active</span>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ isset($voucher) && $voucher->is_active ? 'checked' : ''}} onchange="onChangeActive(this)">
            </div>
        </div>
        <div class="card-body">
            <!-- Row 1 -->
            <div class="row mb-3">
                <div class="col-3 group">
                    <label for="code" class="form-label fw-bold">Code</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="code" name="code" placeholder="Code" value="{{ isset($voucher) ? $voucher->code : ''}}">
                        <button class="btn btn-secondary input-group-text" onclick="generateRandomCode()">
                            <i class="fa-solid fa-shuffle"></i>
                        </button>
                    </div>
                    <div class="error"></div>
                </div>
                <div class="col-3 group">
                    <label for="type" class="form-label fw-bold">Type</label>
                    <select class="form-select" name="type">
                        <option value="">-- Select type --</option>
                        @foreach ($types as $key => $type)
                        <option value="{{$key}}" {{(isset($voucher) && $voucher->type == $key)?'selected':''}}>{{$type}}</option>
                        @endforeach
                    </select>
                    <div class="error"></div>
                </div>
                <div class="col-3 group">
                    <label for="value" class="form-label fw-bold">Value</label>
                    <input type="number" class="form-control" id="value" name="value" placeholder="Value" value="{{ isset($voucher) ? $voucher->value : ''}}">
                    <div class="error"></div>
                </div>
                <div class="col-3 group">
                    <label for="quantity" class="form-label fw-bold">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" value="{{ isset($voucher) ? $voucher->quantity : ''}}">
                    <div class="error"></div>
                </div>
            </div>
            <!-- Row 2 -->
            <div class="row mb-3 justify-content-center">
                <div class="col-4 group">
                    <label for="start_at" class="form-label fw-bold">Start at</label>
                    <input type="date" class="form-control" id="start_at" name="start_at" value="{{ isset($voucher) ? $voucher->start_at : ''}}">
                    <div class="error"></div>
                </div>
                <div class="col-4 group">
                    <label for="end_at" class="form-label fw-bold">End at</label>
                    <input type="date" class="form-control" id="end_at" name="end_at" value="{{ isset($voucher) ? $voucher->end_at : ''}}">
                    <div class="error"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<form method="post" id="postForm">
    @csrf
</form>

@endsection

@section('script')
<!-- Config script -->
<script>
    const routePost = "{{ $routePostTo }}";
    const method = "{{ $method }}";
    const httpReferer = "{{ $httpReferer }}";
</script>
<!-- Handler script -->
<!-- <script src="{{asset('js/admin/voucher/voucher.js')}}"></script> -->
<script>
    function onPostVoucher() {
        const fieldsNeedValid = {
            code: document.querySelector('input[name="code"]'),
            type: document.querySelector('select[name="type"]'),
            value: document.querySelector('input[name="value"]'),
            quantity: document.querySelector('input[name="quantity"]'),
            start_at: document.querySelector('input[name="start_at"]'),
            end_at: document.querySelector('input[name="end_at"]'),
        }

        // Form Data
        const formData = new FormData(document.querySelector('#postForm'));
        for (const key in fieldsNeedValid) {
            formData.set(key, fieldsNeedValid[key].value);
        }
        formData.set('is_active', document.querySelector('[name="is_active"]').checked ? 1 : 0);

        // Callback Function
        const errorCallback = function(errors) {
            setErrorValidate(fieldsNeedValid, errors || {});
        }
        const successCallback = function() {
            window.location.href = httpReferer;
        }
        postFormData(routePost, formData, successCallback, errorCallback, method);
    }

    function generateRandomCode() {
        const codeInput = document.querySelector('input[name="code"]');
        codeInput.value = Math.random().toString(36).substring(2, 10).toUpperCase();
    }

    function onChangeActive(checkbox) {
        const activeContainer = document.getElementById('active-container');
        if (checkbox.checked) activeContainer.classList.add('bg-info');
        else activeContainer.classList.contains('bg-info') && activeContainer.classList.remove('bg-info');
    }
</script>
@endsection