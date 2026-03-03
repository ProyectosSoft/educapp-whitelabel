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

<!-- Sidebar Premium Corporate Style -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-primary-900 border-r border-primary-800 shadow-xl"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    aria-label="Sidebar">
    
    <div class="h-full px-3 pb-4 overflow-y-auto bg-primary-900 scrollbar-hide flex flex-col">
        <ul class="space-y-2 font-medium mt-4 flex-1">
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['route'] }}"
                        class="flex items-center p-3 rounded-r-xl rounded-l-none group transition-all duration-300 ease-in-out relative
                        {{ $link['active'] 
                            ? 'bg-primary-800 text-secondary border-l-4 border-secondary shadow-md shadow-black/20 font-bold' 
                            : 'text-gray-300 hover:bg-primary-800 hover:text-white border-l-4 border-transparent hover:border-gray-500' 
                        }}">
                        
                        <div class="flex items-center justify-center w-8">
                            <i class="{{ $link['icon'] }} text-lg z-10 transition-transform duration-300 group-hover:scale-110 
                                {{ $link['active'] ? 'text-secondary' : 'text-gray-400 group-hover:text-gray-200' }}"></i>
                        </div>
                        
                        <span class="ml-2 text-sm tracking-wide z-10">{{ $link['name'] }}</span>
                        
                        @if($link['active'])
                            <i class="fas fa-chevron-right ml-auto text-xs text-secondary opacity-70"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
        
        <!-- Bottom Section -->
        <div class="mt-auto border-t border-primary-800 pt-4 px-2">
             <div class="flex flex-col items-center justify-center p-3 bg-primary-950/50 rounded-xl border border-primary-800">
                 <div class="flex items-center space-x-2 text-gray-400 text-xs font-semibold select-none mb-1.5">
                    <i class="fas fa-user-graduate text-secondary"></i>
                    <span class="text-gray-300">Panel Alumno</span>
                 </div>
                 <div class="text-[10px] text-gray-500 text-center uppercase tracking-wider font-bold">
                    &copy; {{ date('Y') }} Academia Effi
                 </div>
             </div>
        </div>
    </div>
</aside>

<!-- Overlay for mobile only -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false" 
     class="fixed inset-0 z-30 bg-primary-950/50 backdrop-blur-sm sm:hidden transition-opacity"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
</div>
