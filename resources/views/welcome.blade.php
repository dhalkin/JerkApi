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
    
        <!-- Scripts -->
        <script src="{{ asset('js/welcome.js') }}" defer></script>
    
        <title>{{ __('Manage your business') }}</title>
    </head>
    <body>
        <div id="welcome" class="wrapper p-3" style="background-color: #f4f3ef;">
    
            <div class="row">
                <div class="col col-md-8 ml-auto mr-auto">
                    <div class="row">
                        <div class="col-8">
                            <span class="h5">{{ config('app.name', 'Laravel') }}</span>
                            <span style="font-size: 1.25vw">.club</span>
                        </div>
                        <div class="col-4 text-right font-weight-bolder invisible">
                            @if (Route::has('login'))
                    
                            @auth
                            <a class="mr-2" href="{{ route('webapp') }}">{{ __('Control Panel') }}</a>
                            @else
                            <a class="mr-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                            <a class="mr-1" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                            @endauth
                    
                            @endif
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col">
                            <!--                                    <carousel-->
                            <!--                                        :data="carousel"-->
                            <!--                                        :controls="false"-->
                            <!--                                        :indicators="false"-->
                            <!--                                        :interval="5000"-->
                            <!--                                        direction="left"-->
                            <!--                                    >-->
                            <!--                                    </carousel>-->
                            {{ __("Easy manage your sport business")}}
                        </div>
                    </div>
            
                    
                    <div class="row">
                        <div class="col"><h4>{{ __('Available schedules')}}</h4></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @foreach ($companies as $company)
                            <ul>
                                <a href="/company/{{ $company->uid }}/public-schedule" target="_blank">
                                    <li><h6>{{ $company->name }} | {{ $company->city }}&nbsp;&nbsp;<i
                                                class="fa fa-external-link-square"></i></h6></li>
                                </a>
                                <div class="p-1 text-muted">
                                    {{ $company->about }}
                                </div>
                            </ul>
                            @endforeach
                        </div>
                    </div>
                    
        
                </div>
            </div>
        
        </div>
    </body>
</html>
