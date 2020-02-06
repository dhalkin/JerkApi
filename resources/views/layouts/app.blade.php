<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <link href="{{ asset('css/montseratt.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/awesome.css') }}" rel="stylesheet" />
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
<!--    <link href="{{ asset('css/paper-dashboard-new.css') }}" rel="stylesheet" />-->
<!--    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />-->
<!--    <link href="{{ asset('css/sweetalert2.css') }}" rel="stylesheet" />-->
<!--    <link href="{{ asset('css/vuenotify.css') }}" rel="stylesheet" />-->
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="company-uid" content="{{ $companyUid }}">
    <meta name="company-name" content="{{ $companyName }}">
    <meta name="user-name" content="{{ $userName }}">
    <meta name="secret" content="{{ $apiToken }}">
    
    <title>{{ $title }}</title>
    
</head>
<body>
<!-- Application -->
<div id="app"></div>
<!-- End of Application -->
</body>
<!-- Scripts -->
<script src="{{ asset('/js/lang.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>
</html>
