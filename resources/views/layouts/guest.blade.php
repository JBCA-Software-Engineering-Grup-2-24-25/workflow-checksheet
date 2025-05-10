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

    <!-- Styles -->
    <!-- <link rel="stylesheet" href="../../../resources/css/app.css"> -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
</head>

<body class="font-sans antialiased text-gray-900">
    <div class="relative flex flex-col justify-center min-h-screen authentication-bg">
        <div class="flex items-center justify-center mb-10">
            <h1 class="text-xl font-bold tracking-widest text-gray-100 uppercase">{{ config('app.icon_name') }}</h1>
            {{-- <img src="{{ Vite::asset('resources/images/logo-icl.webp') }}" width="250" alt="logo" /> --}}
        </div>
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
