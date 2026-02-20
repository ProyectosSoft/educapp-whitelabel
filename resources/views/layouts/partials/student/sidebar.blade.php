@php
    $links = [
        [
            'icon' => 'fa-solid fa-gauge-high',
            'name' => 'Dashboard',
            'route' => route('alumnos.dashboard'),
            'active' => request()->routeIs('alumnos.dashboard'),
        ],
        [
            'icon' => 'fa-solid fa-chart-pie',
            'name' => 'Financiero',
            'route' => route('alumnos.financiero'),
            'active' => request()->routeIs('alumnos.financiero'),
        ],
        [
            'icon' => 'fa-solid fa-clipboard-check',
            'name' => 'Mis Evaluaciones',
            'route' => route('student.evaluations.index'),
            'active' => request()->routeIs('student.evaluations.index'),
        ],
        [
            'icon' => 'fa-solid fa-search',
            'name' => 'Catálogo',
            'route' => route('cursos.index'),
            'active' => request()->routeIs('cursos.index'),
        ],
    ];
@endphp

<!-- Sidebar -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-primary-900 border-r border-primary-800 dark:bg-gray-800 dark:border-gray-700 shadow-xl"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    aria-label="Sidebar">
    
    <div class="h-full px-3 pb-4 overflow-y-auto bg-primary-900 dark:bg-gray-800 scrollbar-hide">
        <ul class="space-y-2 font-medium mt-4">
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['route'] }}"
                        class="flex items-center p-3 rounded-xl group transition-all duration-200 
                        {{ $link['active'] 
                            ? 'bg-primary-800 text-secondary border-l-4 border-secondary shadow-lg shadow-primary-900/50' 
                            : 'text-gray-300 hover:bg-primary-800 hover:text-white hover:pl-4' 
                        }}">
                        
                        <i class="{{ $link['icon'] }} w-6 text-center text-lg {{ $link['active'] ? 'text-secondary animate-pulse' : 'text-gray-400 group-hover:text-white' }}"></i>
                        
                        <span class="ml-3">{{ $link['name'] }}</span>
                        
                        @if($link['active'])
                            <i class="fas fa-chevron-right ml-auto text-xs text-secondary opacity-70"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
        
        <!-- Bottom Section (Optional) -->
        <div class="absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-primary-950/50 backdrop-blur-sm border-t border-primary-800">
             <div class="flex items-center space-x-3 text-white/50 text-xs">
                 <span>&copy; {{ date('Y') }} EducApp</span>
                 <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                 <span>Alumno</span>
             </div>
        </div>
    </div>
</aside>

<!-- Overlay for mobile only -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false" 
     class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 sm:hidden backdrop-blur-sm transition-opacity"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
</div>
