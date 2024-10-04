<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('css/master.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <nav>
        <div class="logo">
            <a href="/">
                <img src="{{ url('images/logo.svg') }}" alt="">
            </a>
        </div>
        @if (session()->has('success'))
            <div class="success">
                {{ session()->get('success') }} {{ Auth::user()->name }}
            </div>
        @endif
        <div class="links">
            <ul>
                @guest
                    <li>
                        <a href="{{ route('registerForm') }}">Register</a>
                    </li>
                    <li>
                        <a href="{{ route('loginForm') }}">Login</a>
                    </li>
                @endguest
                <li>
                    <a href="{{ route('posts.index') }}">Generates</a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('profile') }}">Profile</a>
                    </li>
                @endauth
                <li>
                    <a href="{{ route('generateForm') }}">Generate</a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('logout') }}">Logout</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    @yield('content')
</body>

</html>
