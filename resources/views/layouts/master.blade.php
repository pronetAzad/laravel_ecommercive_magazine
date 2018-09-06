<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name'))</title>
    @include('layouts.partials.head')
    @yield('head')
</head>

<body id="commerce">
<div class="loader text-center" style="
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: #dedede;
    opacity: 0.5;
    z-index: 999999;
    display: none;">
    <img src="{{ asset('img/loader.gif') }}" width="80" style="margin-top: 15%;">
</div>
@include('layouts.partials.navbar')
@yield('content')
@include('layouts.partials.footer')
@yield('footer')
</body>
</html>