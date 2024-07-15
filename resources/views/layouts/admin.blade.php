@extends('layouts.master')
@section('layout')

@include('pages.admin.components.icon')
@include('pages.admin.components.header')

<div class="container-fluid">
    <div class="row position-relative">
        <!-- Include Sidebar -->
        @include('pages.admin.components.sidebar')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Content -->
            @yield('content')
        </main>
    </div>
</div>


@endsection