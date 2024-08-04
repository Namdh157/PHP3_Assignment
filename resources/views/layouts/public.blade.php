@extends('layouts.master')

@section('layout')
<!-- Plugins CSS File -->
<link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/magnific-popup/magnific-popup.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/jquery.countdown.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">
<!-- Main CSS File -->
<link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/skins/skin-demo-6.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/demos/demo-6.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/demos/carousel-layout.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/nouislider/nouislider.css">

@include('pages.public.components.header')

@yield('content')
<!-- Content -->

@include('pages.public.components.footer')


<script src="{{asset('js/public/common.js')}}"></script>
<!-- Plugins JS File -->
<script src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script src="{{ asset('assets') }}/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/js/jquery.hoverIntent.min.js"></script>
<script src="{{ asset('assets') }}/js/jquery.waypoints.min.js"></script>
<script src="{{ asset('assets') }}/js/superfish.min.js"></script>
<script src="{{ asset('assets') }}/js/bootstrap-input-spinner.js"></script>
<script src="{{ asset('assets') }}/js/jquery.plugin.min.js"></script>
<script src="{{ asset('assets') }}/js/jquery.countdown.min.js"></script>
<script src="{{ asset('assets') }}/js/bootstrap-input-spinner.js"></script>
<script src="{{ asset('assets') }}/js/superfish.min.js"></script>
<script src="{{ asset('assets') }}/js/jquery.elevateZoom.min.js"></script>
<script src="{{ asset('assets') }}/js/jquery.sticky-kit.min.js"></script>
<script src="{{ asset('assets') }}/js/wNumb.js"></script>
<script src="{{ asset('assets') }}/js/nouislider.min.js"></script>
<script src="{{ asset('assets') }}/js/slider.js"></script>
@endsection