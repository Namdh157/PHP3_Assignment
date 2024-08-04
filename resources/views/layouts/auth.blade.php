@extends('layouts.master')

@section('layout')
<style>
    .background {
        background-image: url('{{ asset("storage/images/wallpaper.jpg") }}');
    }
    .error {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-size: 14px;
        margin-top: 5px;
        margin-left: 10px;
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