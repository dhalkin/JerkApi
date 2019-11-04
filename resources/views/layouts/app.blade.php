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
<div id="app" class="wrapper">
    
    <flash-message transition-name="flash-transition" class="flashpool"></flash-message>
   
    <div class="sidebar" data-background-color="dark" data-active-color="danger">
        <div class="sidebar-wrapper">
            <div class="logo text-md-center font-weight-bold">
                <a href="{{ url('/') }}" class="simple-text logo-normal">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <!--  -->
            <ul class="nav">
                <li>
                    <router-link to="/company">
                        <i class="nc-icon nc-single-02"></i>
                        <p>{{ __('My Company') }}</p>
                    </router-link>
                </li>
                <li>
                    <router-link to="/halls">
                        <i class="nc-icon nc-single-02"></i>
                        <p>{{ __('Halls') }}</p>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
    
    <router-view api-token="{{ Auth::user()->api_token }}" csrf="{{ Session::token() }}"></router-view>

</div>
<!-- End of Application -->
</body>
<!-- Scripts -->
<script src="{{ asset('/js/app.js') }}"></script>
</html>
