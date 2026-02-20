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
        /* Force SweetAlert2 Light Theme & Corporate Styles */
        div:where(.swal2-container) div:where(.swal2-popup) {
            background: #ffffff !important;
            color: #1f2937 !important;
            border-radius: 1rem !important;
        }
        div:where(.swal2-container) button.swal2-styled.swal2-confirm {
            background-color: #335A92 !important;
            border-radius: 0.75rem !important;
            font-weight: bold !important;
        }
        div:where(.swal2-container) button.swal2-styled.swal2-cancel {
            background-color: #f3f4f6 !important;
            color: #374151 !important;
            border-radius: 0.75rem !important;
            font-weight: bold !important;
        }
        div:where(.swal2-icon) {
            border-color: #e5e7eb !important;
        }
    </style>
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-50" x-data="{
    sidebarOpen: false,
}" :class="{
    'overflow-hidden': sidebarOpen,
}">

    <div class="fixed inset-0 bg-gray-900  bg-opacity-50 z-20 sm:hidden" style="display: none" x-show="sidebarOpen"
        x-on:click="sidebarOpen=false">

    </div>

    @include('layouts.partials.admin.navigation')

    @include('layouts.partials.admin.sidebar')



    {{-- <div class="p-4 sm:ml-64"> --}}
    <main class="p-4 sm:p-6 lg:p-8 mt-20 transition-all duration-300 ease-in-out" :class="sidebarOpen ? 'sm:ml-64' : 'sm:ml-64'">
        {{ $slot }}
    </main>
    {{-- </div> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
    @stack('js')
    {{ $js ?? '' }}
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Apply Corporate Colors to Global Alerts
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#fff',
                color: '#335A92'
            });

            @if (session('swal'))
                Swal.fire({!! json_encode(session('swal')) !!});
            @endif

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: {!! json_encode(session('success')) !!},
                    confirmButtonColor: '#335A92', // Corporate Blue
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'px-6 py-2.5 rounded-xl'
                    }
                });
            @endif

            @if (session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Información',
                    text: {!! json_encode(session('info')) !!},
                    confirmButtonColor: '#335A92', // Corporate Blue
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'px-6 py-2.5 rounded-xl'
                    }
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: {!! json_encode(session('error')) !!},
                    confirmButtonColor: '#FC0B29', // Corporate Danger
                    confirmButtonText: 'Entendido',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'px-6 py-2.5 rounded-xl'
                    }
                });
            @endif
            
            @if ($errors->any())
                 Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                    confirmButtonColor: '#FC0B29', // Corporate Danger
                    confirmButtonText: 'Revisar',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'px-6 py-2.5 rounded-xl'
                    }
                });
            @endif
        });
    </script>
</body>

</html>
