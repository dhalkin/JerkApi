<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <link href="{{ asset('css/montseratt.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/awesome.css') }}" rel="stylesheet" />
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/paper-dashboard.css') }}" rel="stylesheet" />

</head>
<body>
<!-- Application -->
<div id="app">
    
    <flash-message transition-name="flash-transition" class="flashpool"></flash-message>
    
    <side-menu app-name="{{ config('app.name', 'Dancezilla') }}" app-url="{{ url('/') }}"></side-menu>
    
    <router-view api-token="{{ Auth::user()->api_token }}" csrf="{{ Session::token() }}"></router-view>

</div>
<!-- End of Application -->
</body>
<!-- Scripts -->
<script src="{{ asset('/js/lang.js') }}"></script>
<script src="{{ asset('/js/app.js') }}"></script>
</html>
