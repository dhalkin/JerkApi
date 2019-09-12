<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="/js/lang.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Application -->
    <div id="app">
        
        @include('menu')

        <main class="py-4">
            {{-- This comment will not be present in the rendered HTML --}}
            @auth
                <router-view some-data="{{ Auth::user()->api_token }}"></router-view>
            @endauth

            @guest
                @yield('content')
            @endguest

        </main>
    </div>
    <!-- End of Application -->
</body>
</html>
