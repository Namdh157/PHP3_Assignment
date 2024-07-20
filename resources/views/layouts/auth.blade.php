@extends('layouts.master')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
<style>
    .background {
        background-image: url('{{ asset("storage/images/login.jpg") }}');
    }

</style>
@yield('content')