<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>

        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body class="text-gray-900 break-words">
        <div class="max-w-lg mx-auto">
            <div class="flex mt-4 mb-8 mx-6">
                <div class="flex-auto mt-1 leading-relaxed relative">
                    <a href="{{ config('app.url') }}"><h1 class="inline text-lg font-semibold tracking-wider">{{ config('app.name') }}</h1>
                        <span class="inline-block bg-blue-100 text-blue-400 text-xs px-1 rounded">beta</span>
                    </a>
                </div>
                <div class="flex-none">
                    @auth
                    <a href="{{ env('DASHBOARD_URL') }}" class="inline-block mt-3">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="mr-4">Log In</a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn">Sign Up</a>
                    @endif
                    @endauth
                </div>
            </div>

            @yield('content')
        </div>
    </body>
</html>
