<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{ asset('img/cursos/Isotipo_EducApp_3 _V1.png') }}">
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
<style>
    .imagen_login{
       /* background-image: url("{{ asset('img/cursos/background_01.png') }}") !important; */
       background-image: url("{{ asset('img/cursos/Imagen9.png') }}") !important;
       height: auto;
       width: 100%;
       margin-left: auto;
       margin-right: auto;
       background-repeat: no-repeat;
       background-size: cover;
       background-position: center;
   }
</style>

<style>
    .backdrop-filter-login {
        backdrop-filter: blur(10px); /* Ajusta el valor de desenfoque según lo desees */
        background-color: rgba(255, 255, 255, 0.1); /* Ajusta el color y la opacidad del filtro */
        border-color: rgba(56, 31, 114, 1);
         /* Asegúrate de que esté detrás del contenido */
    }
</style>
