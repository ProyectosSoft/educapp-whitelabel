<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Academia Effi') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-white text-slate-600" x-data="{ sidebarOpen: false }">
        
        <div class="flex h-screen overflow-hidden bg-white">
            
            @include('layouts.partials.author.sidebar')

            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-white">
                
                @include('layouts.partials.author.navigation')

                <main class="w-full grow p-6 lg:p-10 mt-16 lg:mt-0">
                    {{ $slot }}
                </main>

            </div>

        </div>

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        @stack('js')
        {{ $js ?? '' }}
        
    </body>
</html>
