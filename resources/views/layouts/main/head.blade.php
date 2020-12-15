<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php $version = env('APP_VERSION'); @endphp
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="site-url" content="{{url('/')}}">
  <meta name="current-url" content="{{url(request()->path())}}">
  <link href="{{ asset('resources/assets/img/logo/logo.png') }}" rel="icon">
  <title>@yield('pageTitle')</title>
  <link href="{{ asset('resources/assets/vendor/fontawesome-free/css/all.min.css') }}?ver={{$version}}" rel="stylesheet" type="text/css">
  <link href="{{ asset('resources/assets/vendor/bootstrap/css/bootstrap.min.css') }}?ver={{$version}}" rel="stylesheet" type="text/css">
  <link href="{{ asset('resources/assets/css/theme.css') }}?ver={{$version}}" rel="stylesheet">
  <link href="{{ asset('resources/assets/css/main.css') }}?ver={{$version}}" rel="stylesheet">
  <script src="{{ asset('resources/assets/vendor/jquery/jquery.min.js') }}?ver={{$version}}"></script>
  @yield('topScripts')
</head>

<body id="page-top">