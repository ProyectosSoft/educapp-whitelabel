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
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/5bb25d4814.js" crossorigin="anonymous"></script>

    <style>
        [x-cloak] { display: none !important; }
        /* Custom scrollbar for sidebar */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
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
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900" 
      x-data="{ 
          sidebarOpen: localStorage.getItem('sidebarOpen') ? localStorage.getItem('sidebarOpen') === 'true' : window.innerWidth >= 640 
      }"
      x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val))">
    
    @include('layouts.partials.author.navigation-tailwind')

    @include('layouts.partials.author.sidebar-tailwind')

    <div class="p-4 mt-16 transition-all duration-300"
         :class="sidebarOpen ? 'sm:ml-64' : ''">
        <div class="p-4 rounded-2xl min-h-screen">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
    
    <script>
        window.addEventListener('swal', event => {
            Swal.fire(event.detail);
        });
    </script>
    @stack('js')
    {{ $js ?? '' }}
</body>
</html>
