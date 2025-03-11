<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Centro de acondicionamiento fisico de Bucaramanga"/>
        <meta name="keywords" content="vitalfutclub, vitalfut, entrenamiento, futbol, colombia, bucaramanga" />
        <meta name="author" content="Sergio Andres Becerra" />
         <meta name="copyright" content="vitalfutclub" />
         <meta name="robots" content="follow"/>
         <meta http-equiv="cache-control" content="no-cache"/>

        <link href="{{asset('img/vital-circle.png')}}" rel="icon">
       <link href="{{asset('img/vital-circle.png')}}" rel="apple-touch-icon">

        <title>VitalFutClub</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <main class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </main>
        @livewireScripts

    </body>
</html>
