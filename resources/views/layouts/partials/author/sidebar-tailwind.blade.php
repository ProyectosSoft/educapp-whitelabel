@php
    $links = [
        [
            'icon' => 'fa-solid fa-gauge-high',
            'name' => 'Cursos',
            'route' => route('author.cursos.index'),
            'active' => request()->routeIs('author.cursos.index'),
        ],
        [
            'icon' => 'fa-solid fa-chart-pie',
            'name' => 'Financiero',
            'route' => route('author.financiero'),
            'active' => request()->routeIs('author.financiero'),
        ],
        [
            'icon' => 'fa-solid fa-clipboard-list',
            'name' => 'Gestión Evaluaciones',
            'route' => route('author.exams.manager'),
            'active' => request()->routeIs('author.exams.manager'),
        ],
        [
            'icon' => 'fa-solid fa-layer-group',
            'name' => 'Niveles Dificultad',
            'route' => route('author.exams.difficulty-levels'),
            'active' => request()->routeIs('author.exams.difficulty-levels'),
        ],
        [
            'icon' => 'fa-solid fa-database',
            'name' => 'Banco Preguntas',
            'route' => route('author.exams.question-bank'),
            'active' => request()->routeIs('author.exams.question-bank'),
        ],
        [
            'icon' => 'fa-solid fa-check-double',
            'name' => 'Calificaciones',
            'route' => route('author.exams.grader'),
            'active' => request()->routeIs('author.exams.grader'),
        ],
        [
            'icon' => 'fa-solid fa-chart-line',
            'name' => 'Dashboard Global',
            'route' => route('author.exams.global-stats'),
            'active' => request()->routeIs('author.exams.global-stats'),
        ],
    ];
@endphp

<!-- Sidebar -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-[#335A92] shadow-xl"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    aria-label="Sidebar">
    
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white scrollbar-hide flex flex-col">
        <div class="mb-6 px-2">
           <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Instructor Panel</span>
        </div>
        
        <ul class="space-y-2 font-medium flex-1">
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['route'] }}"
                        class="flex items-center p-3 rounded-xl group transition-all duration-200 
                        {{ $link['active'] 
                            ? 'bg-[#335A92] text-white shadow-lg shadow-blue-500/20' 
                            : 'text-[#335A92] hover:bg-gray-100' 
                        }}">
                        
                        <i class="{{ $link['icon'] }} w-6 text-center text-lg {{ $link['active'] ? 'text-white' : 'text-[#335A92] group-hover:scale-110 transition-transform' }}"></i>
                        
                        <span class="ml-3 font-semibold">{{ $link['name'] }}</span>
                        
                        @if($link['active'])
                            <i class="fas fa-chevron-right ml-auto text-xs text-white opacity-70"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
        
        <!-- Bottom Section -->
        <div class="mt-auto pt-6 px-2 bg-white pb-2">
             <div class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-xl border border-slate-200 shadow-sm transition-all hover:bg-white hover:shadow-md">
                 <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold select-none mb-1.5">
                    <i class="fas fa-chalkboard-teacher text-[#335A92]"></i>
                    <span class="text-slate-700">Panel Instructor</span>
                 </div>
                 <div class="text-[10px] text-slate-400 text-center uppercase tracking-wider font-extrabold">
                    &copy; {{ date('Y') }} Academia Effi
                 </div>
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
