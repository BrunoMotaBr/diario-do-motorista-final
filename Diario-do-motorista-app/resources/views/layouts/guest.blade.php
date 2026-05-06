<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div
            class="guest-principal"
        >
        <img class="i" src="{{ asset('build/assets/imgs/bg.svg') }}" alt="">
        <div class="sombra-bg"></div>
            {{ $slot }}
        </div>
    </body>
    <style>
        .i{
            position: absolute;
            z-index: 0;
            object-fit: cover;
            object-position: center;
        }
        .sombra-bg{
            position: absolute;
            z-index: -10;
            width: 100%;
            height: 100%;
            background-color: var(--bg-main-shadow);
        }
    </style>
</html>
