<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Footplus') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    
    {{-- Chargement des icones --}}
    <script src="https://kit.fontawesome.com/097058085d.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[url('/public/images/fonds04.jpg')] bg-cover" id="app">
    <div class="min-h-screen">
        <!-- Page Heading -->
        <header class="w-full h-48 bg-red-800">
            <div class="w-full flex">@include('layouts.header')</div>
            <div class="w-full bg-red-800">@include('layouts.navigation')</div>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

    </div>
</body>

</html>