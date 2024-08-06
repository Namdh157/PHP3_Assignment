@extends('layouts.admin')
@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <h4 class=" px-4">INFORMATION USER</h4>
    </div>
    <hr>

    <div class="row border border-3 p-5 m-4 rounded shadow">
        <!-- Avatar -->
        <div class="col-md-3">
            <img src="{{ asset($user->image) }}" alt="" class="img-thumbnail rounded-circle">
            <ul class="list-inline d-flex justify-content-center gap-2">
                <li><i style="color:#0d6efd" class="fa-solid fa-star"></i></li>
                <li><i style="color:#0d6efd" class="fa-solid fa-star"></i></li>
                <li><i style="color:#0d6efd" class="fa-solid fa-star"></i></li>
                <li><i style="color:#0d6efd" class="fa-solid fa-star"></i></li>
                <li><i style="color:#0d6efd" class="fa-solid fa-star"></i></li>
            </ul>
        </div>
        <!-- Information -->
        <div class="col-md-9">
            <h4>Information</h4>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone number</strong></td>
                        <td>{{ isset($user->phone_number) ? $user->phone_number : 'Not Update' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Address</strong></td>
                        <td>{{ isset($user->address) ? $user->address : 'Not Update' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Role</strong></td>
                        <td>{{ $user->role }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection

<!-- Show fullview image -->
@include('common.fullView')

@section('script')
<!-- config scripts -->


<!-- Handler script -->
@endsection