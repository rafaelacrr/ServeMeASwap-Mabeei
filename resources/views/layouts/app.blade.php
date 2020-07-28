<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - Simplifying the creation of Swaps</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app" class="main-content">
        <div class="navbar-wrapper">

            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-dark pt-4 pb-4 mb-5">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img alt="Brand" height="45" weight="45" src="{{ asset('images/logo.png') }}">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav mr-auto">

                        </ul>
                        <ul class="navbar-nav">
                            @if (Auth::guest())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                        <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            {{ csrf_field() }}
                                            <button class="dropdown-item" type="submit">
                                                Sign out
                                            </button>
                                        </form>
                                    </li>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div class="container">
            @include('flash::message')
        </div>

        <div class="container mb-5">
            @yield('content')
        </div>
    </div>

    <footer class="main-footer" id="footer">
        <div class="container">
            <div class="row align-items-center p-4 text-muted small">
                <div class="col">
                    Developed with love by Luís Alves e Rafaela Rodrigues.
                </div>
                <div class="col-2 text-center">
                    <img alt="Brand" height="28" src="{{ asset('images/logo.png') }}">
                </div>
            </div>
        </div>
      </footer>
  </div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
