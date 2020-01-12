<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('Welcome') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/welcome.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="welcome" class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">::{{ __('Home') }}</a>
                    @else
                        <a href="{{ route('login') }}">::{{ __('Login') }}</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">::{{ __('Register') }}</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Dance!
                </div>

                <div class="title-medium">
                    Like you never dance before.
                </div>

                <div class="broadcast">
                    <carousel :data="carousel" :controls="false" :indicators="false" :interval="5000" direction="up"></carousel>
                </div>
                
            </div>
        </div>
    </body>
</html>
