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
<body class="">
    <!-- Application -->
    <div class="wrapper">
<!--        <flash-message transition-name="flash-transition" class="flashpool"></flash-message>-->
        <div class="sidebar" data-color="brown" data-active-color="danger">
            <div class="sidebar-wrapper">
                <div class="logo text-md-center font-weight-bold">
                    <a href="{{ url('/') }}" class="simple-text logo-normal">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <!--  -->
                <ul class="nav">
                    <li class="{{ Request::is('login') ? 'active' : '' }}">
                        <a href="{{ route('login') }}">
                            <i class="nc-icon nc-single-02"></i>
                            <p>{{ __('Login') }}</p>
                        </a>
                    </li>
                    <li class="{{ Request::is('register') ? 'active' : '' }}">
                        <a href="{{ route('register') }}">
                            <i class="nc-icon nc-user-run"></i>
                            <p>{{ __('Register') }}</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
                <div class="container-fluid">
                    
                    <div class="navbar-wrapper">
                        <!-- for mobile fiew -->
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <span class="navbar-brand">{{ __('You need to log in to continue')}}</span>
                    </div>
                    <div class="navbar-wrapper justify-content-end">
                        <a class="ml-2" href="/lang/ru">Ru</a>
                        <a class="ml-2" href="/lang/en">En</a>
                    </div>
                    
                </div>
            </nav>
            <!-- End Navbar -->
  
            <div class="content">
                    @yield('content')
            </div>
    
            <footer class="footer footer-black">
                <div class="container-fluid">
                    <div class="pull-left">
                        <a class="" href="{{ url('/') }}">{{ __('Back')}}</a>
                    </div>
                    <div class="copyright pull-right">
                        &copy; 2019 made with <i class="fa fa-heart heart"></i> by <a href="{{ url('/') }}">DanceZilla</a>
                    </div>
                </div>
            </footer>
            
        </div>
        
    </div>
    <!-- End of Application -->
</body>
<!-- Scripts -->
<script src="{{ asset('/js/non-auth-app.js') }}"></script>
</html>
