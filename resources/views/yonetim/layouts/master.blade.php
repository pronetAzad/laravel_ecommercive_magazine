<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name') . " | Yonetim")</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('head')
    <style>
        .loader{
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            background-color: #e0e9f3cc;
            z-index: 9999;
        }
    </style>
</head>
<body>
@include('yonetim.layouts.partials.navbar');
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 sidebar collapse" id="sidebar">
            @include('yonetim.layouts.partials.sidebar')
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-10 col-lg-offset-2 main">
            @yield('content')
        </div>
    </div>
</div>
<div class="loader" style="display: none;">
   <div class="text-center" style="margin-top: 15%">
       <img src="{{ asset('img/loading.gif') }}" alt="Laravel Ecommerce logo" width="150">
   </div>
</div>

<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="{{ asset('js/admin-app.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</body>
</html>