<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $header ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- flatpickr style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <!-- flatpickr style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css'])

    <!-- flatpickr style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- flatpickr style -->

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js"></script>


    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @routes

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <!-- Scripts -->
</head>

<body class="font-sans antialiased" x-data="{
        init() {
            tippy('[data-tippy-content]')
        }
    }">
    <div x-data="{ menuOpen: false }" class="flex min-h-screen custom-scrollbar">
        <!-- start::Black overlay -->
        <div :class="menuOpen ? 'block' : 'hidden'" @click="menuOpen = false"
            class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
        <!-- end::Black overlay -->
        <!-- start::Sidebar -->
        @include('layouts.sidebar')
        <!-- end::Sidebar -->
        <div class="flex flex-col w-full lg:pl-64">
            <!-- start::Topbar -->
            @include('layouts.header')
            <!-- end::Topbar -->
            <!-- start:Page content -->
            <div class="h-full px-8 py-8 bg-[#F5F6F7]">
                {{ $slot }}
            </div>
            <!-- end:Page content -->
        </div>
    </div>
    @stack('scripts')
</body>

</html>
