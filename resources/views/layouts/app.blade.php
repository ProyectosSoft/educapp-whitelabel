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
        .imagen{
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
            .imagen2{
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
             .imagen_login{
                background-image: url("{{ asset('img/cursos/Fondo_login_f.png') }}") !important;
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
            .logo{
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
                border-radius: 24px; /* Puedes ajustar el valor según tus preferencias */
                overflow: hidden; /* Para asegurarte de que los bordes redondeados se apliquen correctamente */
            }
        </style>

<style>
    .backdrop-filter {
        backdrop-filter: blur(5px); /* Ajusta el valor de desenfoque según lo desees */
        background-color: rgba(0, 0, 0, 0); /* Ajusta el color y la opacidad del filtro */
        border-color: rgba(56, 31, 114, 1);
         /* Asegúrate de que esté detrás del contenido */
    }
</style>

<style>
    #payment-button {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #payment-button button {
        background-color: #381F72; /* Color de fondo del botón */
        color: #00FFA2; /* Color del texto del botón */
        padding: 0px 16px; /* Espaciado interno del botón */
        text-align: center; /* Alineación del texto */
        text-decoration: none; /* Sin subrayado */
        display: inline-block; /* Mostrar como bloque en línea */
        font-size: 16px; /* Tamaño de fuente */
        margin: 16px 0px 0px; /* Espaciado externo */
        cursor: pointer; /* Cambiar el cursor al pasar sobre el botón */
        border: none; /* Sin borde */
        border-radius: 9999px; /* Bordes redondeados */
        transition: background-color 0.3s ease;/* Transición suave para el cambio de color */
        width: 100%;/* Ancho completo */
        font-weight: bold; /* Negrilla para la letra */
    }

    #payment-button button:hover {
        background-color: #4F269C; /* Color de fondo al pasar el mouse */
    }
</style>

    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-200">
        @livewire('navigation')


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    @isset($js)
        {{ $js }}
    @endisset

    <script>
        function dropdown() {
            return {
                open: false,
                show() {
                    if (this.open) {
                        //se cierra el menu
                        this.open = false;
                        document.getElemenstByTagName('html')[0].style.overflow = 'auto';
                    } else {
                        //abre el menu
                        this.open = true;
                        document.getElementsByTagName('html')[0].style.overflow = 'hidden';
                    }
                },
                close() {
                    this.open = false;
                    document.getElementsByTagName('html')[0].style.overflow = 'auto';
                }
            }
        }
    </script>
    @stack('script')
</body>

</html>
