<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--Font awesome-->
    <script src="https://kit.fontawesome.com/5bb25d4814.js" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://vjs.zencdn.net/8.6.1/video-js.css" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glider-js/1.7.8/glider.min.js"
        integrity="sha512-AZURF+lGBgrV0WM7dsCFwaQEltUV5964wxMv+TSzbb6G1/Poa9sFxaCed8l8CcFRTiP7FsCgCyOm/kf1LARyxA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Styles -->
    <link rel="icon" type="image/png" href="{{ asset('img/cursos/Isotipo_EducApp_3 _V1.png') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glider-js/1.7.8/glider.min.css"
        integrity="sha512-YM6sLXVMZqkCspZoZeIPGXrhD9wxlxEF7MzniuvegURqrTGV2xTfqq1v9FJnczH+5OGFl5V78RgHZGaK34ylVg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .disabled {
            pointer-events: none;
            /* Deshabilitar clics */
            opacity: 0.5;
            /* Cambiar la opacidad para indicar visualmente que está deshabilitado */
            cursor: not-allowed;
            /* Cambiar el cursor para indicar visualmente que está deshabilitado */
        }
    </style>

    <style>
        .imagen {
            background-image: url("{{ asset('img/cursos/fondotrama.png') }}");
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
        .imagen2 {
            background-image: url("{{ asset('img/cursos/fondotramacolor.png') }}");
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
        .imagen_login {
            /* background-image: url("{{ asset('img/cursos/Fondo_login.png') }}"); */
            background-image: url("{{ asset('img/cursos/Fondo_login_f.png') }}");
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
        .logo {
            background-image: url("{{ asset('img/cursos/Logo2.png') }}");
            height: 100%;
            width: 20%;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
        }
    </style>

    <style>
        .rounded-video {
            border-radius: 24px;
            /* Puedes ajustar el valor según tus preferencias */
            overflow: hidden;
            /* Para asegurarte de que los bordes redondeados se apliquen correctamente */
        }
    </style>
    <style>
        .placeholder-white::placeholder {
            color: white;
        }
    </style>
    <style>
        #payment-button {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        #payment-button button {
            background-color: #4CAF50; /* Color de fondo del botón */
            color: white; /* Color del texto del botón */
            padding: 15px 32px; /* Espaciado interno del botón */
            text-align: center; /* Alineación del texto */
            text-decoration: none; /* Sin subrayado */
            display: inline-block; /* Mostrar como bloque en línea */
            font-size: 16px; /* Tamaño de fuente */
            margin: 4px 2px; /* Espaciado externo */
            cursor: pointer; /* Cambiar el cursor al pasar sobre el botón */
            border: none; /* Sin borde */
            border-radius: 8px; /* Bordes redondeados */
            transition: background-color 0.3s ease; /* Transición suave para el cambio de color */
        }

        #payment-button button:hover {
            background-color: #45a049; /* Color de fondo al pasar el mouse */
        }
    </style>



    @livewireStyles
</head>

<body class="font-sans antialiased" x-data="{
    sidebarOpen: false,
}" :class="{
    'overflow-hidden': sidebarOpen,
}">

    <div class="fixed inset-0 bg-gray-900  bg-opacity-50 z-20 sm:hidden" style="display: none;" x-show="sidebarOpen"
        x-on:click="sidebarOpen=false">

    </div>

    @include('layouts.partials.alumnos.navigation')

    @include('layouts.partials.alumnos.sidebar')


    {{-- <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            {{ $slot }}
        </div>
    </div> --}}
    <div class="p-6 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-24">
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>
