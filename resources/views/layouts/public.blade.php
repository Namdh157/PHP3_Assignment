@extends('layouts.master')

@section('layout')

@include('pages.public.components.header')

@yield('content')
<!-- Content -->

@include('pages.public.components.footer')

@endsection