<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                <li class="nav-item">
                    <router-link class="nav-link" to="/home">{{ __('Home') }}</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/company">{{ __('My Company') }}</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/branches">{{ __('Branches') }}</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/trainers">{{ __('Trainers') }}</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/customers">{{ __('Customers') }}</router-link>
                </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="/lang/ru">Ru</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/lang/en">En</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item">
                    <router-link class="nav-link" to="/profile">{{ Auth::user()->name }}</router-link>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
