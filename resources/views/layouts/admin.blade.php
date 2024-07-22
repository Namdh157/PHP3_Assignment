@extends('layouts.master')
@section('layout')

<style>
    .bi {
        display: inline-block;
        width: 1rem;
        height: 1rem;
    }

    /*
 * Sidebar
 */

    @media (min-width: 768px) {
        .sidebar .offcanvas-lg {
            position: -webkit-sticky;
            position: sticky;
            top: 48px;
        }

        .navbar-search {
            display: block;
        }
    }

    .sidebar .nav-link {
        font-size: .875rem;
        font-weight: 500;
    }

    .sidebar .nav-link.active {
        color: #2470dc;
        background-color: #aaaaaa85;
    }

    .sidebar-heading {
        font-size: .75rem;
    }

    /*
 * Navbar
 */

    .navbar-brand {
        padding-top: .75rem;
        padding-bottom: .75rem;
        background-color: rgba(0, 0, 0, .25);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
    }

    .navbar .form-control {
        padding: .75rem 1rem;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
    }

    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .bd-mode-toggle {
        z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
    }
    :root{
        --bs-body-font-size: 0.9rem;
    }
    .btn{
        --bs-btn-font-size: 0.9rem;
    }
    .form-select{
        --bs-form-select-font-size: 0.9rem;
        font-size: 0.9rem;
    }
    .form-control{
        --bs-form-control-font-size: 0.9rem;
        font-size: 0.9rem;
    }
    .dropdown-menu{
        --bs-dropdown-font-size: 0.9rem;
    }
</style>

<!-- @include('pages.admin.components.header') -->

<div class="container-fluid ps-0">
    <div class="d-flex position-relative">
        <!-- Include Sidebar -->
        @include('pages.admin.components.sidebar')

        <div class="px-0 flex-fill">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-chevron p-3 bg-body-tertiary">
                    <li class="breadcrumb-item">
                        <a class="link-body-emphasis" href="{{route('admin.dashboard')}}">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </a>
                    </li>
                    @foreach ($breadcrumb as $key => $item)
                    @if ($key == count($breadcrumb) - 1)
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $item['title'] }}
                    </li>
                    @endif
                    @if ($key < count($breadcrumb) - 1) <li class="breadcrumb-item">
                        <a class="link-body-emphasis fw-semibold text-decoration-none" href="{{route($item['route'])}}">
                            {{ $item['title'] }}
                        </a>
                        </li>
                        @endif
                        @if (isset($item['params']))
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $item['params'] }}
                        </li>
                        @endif
                        @endforeach
                </ol>
            </nav>

            <!-- Content -->
            <main class="ms-sm-auto px-md-4">
                @yield('content')
            </main>
        </div>
    </div>
</div>

<!-- Post FormData - Set error validate -->
<script>
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
</script>

<!-- Confirm -->
<script>
    function confirmDelete(event) {
        event.preventDefault();
        if (confirm('Are you sure to DELETE this item?')) {
            event.target.submit();
        }
    }
</script>

@endsection