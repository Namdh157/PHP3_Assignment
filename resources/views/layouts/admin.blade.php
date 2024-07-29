@extends('layouts.master')
@section('layout')

<link rel="stylesheet" href="{{asset('css/admin/layout.css')}}">

<div class="container-fluid px-0">
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

<script src="{{asset('js/admin/layout.js')}}"></script>
@endsection