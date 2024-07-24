@extends('layouts.master')

@section('layout')
<style>
    .background {
        background-image: url('{{ asset("storage/images/login.jpg") }}');
    }
</style>
<link href="{{ asset('css/auth/auth.css') }}" rel="stylesheet">

@yield('content')

<script>
    document.querySelector('form').onsubmit = function(e) {
        e.preventDefault();
        loading().on();
        e.target.submit();
    }
</script>
@endsection