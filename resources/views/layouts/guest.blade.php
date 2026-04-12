<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Default title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Browser Tab Icon -->
    <link rel="icon" href="{{ asset('images/mcu-logo.png') }}" type="image/x-icon">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: url('/images/mcu-background-image.jpg');
            backdrop-filter: brightness(70%);
        }
    </style>
</head>

<body class="antialiased">
    <!-- body layout -->
    <div
        class="min-h-screen flex sm:flex flex-col justify-center items-center sm:justify-center sm:items-center pt-6 sm:pt-0 max-sm:mx-2 max-sm:mt-auto">
        <!-- Log in/register/forgot password form layout -->
        <div
            class="bg-white max-md:w-full w-auto max-w-[550px] mt-2 px-4 py-4 shadow-log border-4 border-gray text-black overflow-hidden max-sm:max-h-[100vh] sm:overflow-y-auto max-sm:relative rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>