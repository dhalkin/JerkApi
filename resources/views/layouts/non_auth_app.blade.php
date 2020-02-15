<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <!-- fonts -->
    <link href="{{ asset('css/montseratt.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/awesome.css') }}" rel="stylesheet" />
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/paper-dashboard.css') }}" rel="stylesheet" />
    
    <title>{{ __('Login or Register') }}</title>
    
</head>
<body>
    <!-- Application -->
    <div class="login-page">
        
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute" style="margin-bottom: 2px; margin-top: 2px;">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a href="/" class="navbar-brand">SportStation.club</a>
                </div>
                <div id="navigation" class="collapse navbar-collapse justify-content-end show navbar-right">
                    <ul class="navbar-nav">
                        @if (Route::has('login') && !Request::is('login'))
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">
                                <i class="nc-icon nc-single-02"></i>
                                {{ __('Login') }}
                            </a>
                        </li>
                        @endif
                        @if (Route::has('register') && !Request::is('register'))
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">
                                <i class="nc-icon nc-user-run"></i>
                                {{ __('Register') }}
                            </a>
                        </li>
                        @endif

                    </ul>
                </div>
            </div>
        </nav>
    
        <div class="wrapper wrapper-full-page">
        <div class="full-page login-page section-image">
            
            <div class="content" style="padding-top: 10vh">
                    @yield('content')
            </div>
    
            <footer class="footer footer-black footer-white">
                <div class="container-fluid">
                    <div class="row">
                        <nav class="footer-nav">
                            <ul>
                                <li>
                                </li>
                                <li>
                                </li>
                                <li>
                                </li>
                            </ul>
                        </nav>
                        <div class="credits ml-auto">
                            <div class="copyright">
                                &copy; SportStation
                                <i class="fa fa-heart heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
<!--            <div class="full-page-background" style="background-image: url(/static/img/background/background-2.jpg) "></div>-->
        
        </div>
        </div>
        
    </div>
    <!-- End of Application -->
</body>
</html>
