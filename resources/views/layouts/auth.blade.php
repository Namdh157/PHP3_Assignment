@extends('layouts.master')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
<style>
    .background {
        background-image: url('{{ asset("storage/images/login.jpg") }}');
    }
    .error{
        font-size: 14px;
        color: #ff5858;
        margin-left: 15px;
        font-weight: 600;
    }

</style>
@yield('content')