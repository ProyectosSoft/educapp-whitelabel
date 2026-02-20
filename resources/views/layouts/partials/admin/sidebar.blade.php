@php
    $links = [];
    
    if (auth()->user()->hasRole('Administrador de Empresa')) {
        $links = [
            [
                'name' => 'Mi Empresa',
                'route' => route('admin.empresas.edit', auth()->user()->empresa_id),
                'active' => request()->routeIs('admin.empresas.edit'),
                'icon' => 'fa-solid fa-building',
                'can' => true
            ],
            [
                'name' => 'Mis Cursos',
                'route' => route('admin.empresas.cursos.index'), 
                'active' => request()->routeIs('admin.empresas.cursos.*'),
                'icon' => 'fa-solid fa-graduation-cap',
                'can' => true
            ],
            [
                'name' => 'Mis Categorías',
                'route' => route('admin.empresas.categorias.index'), 
                'active' => request()->routeIs('admin.empresas.categorias.*'),
                'icon' => 'fa-solid fa-layer-group',
                'can' => true
            ],
            [
                'name' => 'Mis Subcategorías',
                'route' => route('admin.empresas.subcategorias.index'), 
                'active' => request()->routeIs('admin.empresas.subcategorias.*'),
                'icon' => 'fa-solid fa-tags',
                'can' => true
            ],
            [
                'name' => 'Mis Instructores',
                'route' => route('admin.empresas.instructores.index'),
                'active' => request()->routeIs('admin.empresas.instructores.*'),
                'icon' => 'fa-solid fa-chalkboard-user',
                'can' => true
            ],
            [
                'name' => 'Mis Alumnos',
                'route' => route('admin.empresas.alumnos.index'),
                'active' => request()->routeIs('admin.empresas.alumnos.*'),
                'icon' => 'fa-solid fa-user-graduate',
                'can' => true
            ],
            [
                'name' => 'Mis Certificaciones',
                'route' => route('admin.empresas.certificaciones.index'),
                'active' => request()->routeIs('admin.empresas.certificaciones.*'),
                'icon' => 'fa-solid fa-award',
                'can' => true
            ],
        ];
    } else {
        $links = [
            [
                'icon' => 'fa-solid fa-gauge-high',
                'name' => 'Dashboard',
                'route' => route('admin.home'),
                'active' => request()->routeIs('admin.home'),
                'can' => 'Ver dashboard',
            ],
            [
                'icon' => 'fa-solid fa-users-gear',
                'name' => 'Lista de Roles',
                'route' => route('admin.roles.index'),
                'active' => request()->routeIs('admin.roles.*'),
                'can' => 'Listar role',
            ],
            [
                'icon' => 'fa-solid fa-users',
                'name' => 'Usuarios',
                'route' => route('admin.users.index'),
                'active' => request()->routeIs('admin.users.*'),
                'can' => 'Leer usuarios',
            ],
            [
                'icon' => 'fa-solid fa-clock-rotate-left',
                'name' => 'Auditoría',
                'route' => route('admin.audits.index'),
                'active' => request()->routeIs('admin.audits.index'),
                'can' => 'Ver dashboard',
            ],
            [
                'icon' => 'fa-solid fa-chart-line',
                'name' => 'Auditoría Cursos',
                'route' => route('admin.audits.courses'),
                'active' => request()->routeIs('admin.audits.courses'),
                'can' => 'Ver dashboard',
            ],
            [
                'icon' => 'fa-solid fa-layer-group',
                'name' => 'Categorías',
                'route' => route('admin.categorias.index'),
                'active' => request()->routeIs('admin.categorias.*'),
                'can' => 'Ver dashboard',
            ],
            [
                'icon' => 'fa-solid fa-folder-tree',
                'name' => 'Subcategorías',
                'route' => route('admin.subcategorias.index'),
                'active' => request()->routeIs('admin.subcategorias.*'),
                'can' => 'Ver dashboard',
            ],
            [
                'icon' => 'fa-solid fa-list-check',
                'name' => 'Pendientes',
                'route' => route('admin.cursos.index'),
                'active' => request()->routeIs('admin.cursos.index'),
                'can' => 'Ver dashboard',
            ],
            [
                'icon' => 'fa-solid fa-building',
                'name' => 'Empresas',
                'route' => route('admin.empresas.index'),
                'active' => request()->routeIs('admin.empresas.*'),
                'can' => 'Ver dashboard',
            ],
            [
                'icon' => 'fa-solid fa-chart-pie',
                'name' => 'Financiero',
                'route' => route('admin.financiero'),
                'active' => request()->routeIs('admin.financiero'),
                'can' => 'Ver dashboard',
            ],
             [
                'icon' => 'fa-solid fa-gear',
                'name' => 'Configuración',
                'route' => route('admin.settings'),
                'active' => request()->routeIs('admin.settings'),
                'can' => 'Ver dashboard',
            ],
        ];
    }
@endphp

<!-- Sidebar Clean White Style -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-24 transition-transform bg-white border-r border-gray-100 shadow-[4px_0_24px_rgba(0,0,0,0.02)]"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    aria-label="Sidebar">
    
    <div class="h-full px-4 pb-8 overflow-y-auto bg-white scrollbar-hide flex flex-col">
        <div class="mb-4 px-2">
            <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Navegación</span>
        </div>

        <ul class="space-y-2 font-medium flex-1">
            @foreach ($links as $link)
                @if ( ($link['can'] === true) || (is_string($link['can']) && auth()->user()->can($link['can'])) )
                    <li>
                        <a href="{{ $link['route'] }}"
                            class="flex items-center px-4 py-3 rounded-2xl group transition-all duration-300 ease-out relative overflow-hidden
                            {{ $link['active'] 
                                ? 'bg-primary-900 text-white shadow-lg shadow-primary-900/30 scale-[1.02]' 
                                : 'text-gray-500 hover:bg-gray-50 hover:text-primary-900 hover:shadow-md hover:shadow-gray-200/50' 
                            }}">
                            
                            {{-- Active Indicator Glow --}}
                            @if($link['active'])
                                <div class="absolute top-0 right-0 w-20 h-full bg-gradient-to-l from-white/10 to-transparent pointer-events-none"></div>
                            @endif

                            <i class="{{ $link['icon'] }} w-5 text-center text-lg z-10 transition-transform duration-300 group-hover:scale-110 
                                {{ $link['active'] ? 'text-accent' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                            
                            <span class="ml-3 text-sm font-bold tracking-wide z-10">{{ $link['name'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
        
        <!-- Bottom Section -->
        <div class="mt-auto pt-6 border-t border-gray-50">
             <div class="flex items-center justify-center p-4 bg-gray-50/50 rounded-2xl border border-gray-100">
                 <div class="flex items-center space-x-2 text-gray-400 text-xs font-semibold select-none">
                    <i class="fas fa-shield-alt text-gray-300"></i>
                    <span>Panel Seguro</span>
                 </div>
             </div>
        </div>
    </div>
</aside>

<!-- Overlay for mobile only -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false" 
     class="fixed inset-0 z-30 bg-primary-900/10 backdrop-blur-sm sm:hidden transition-opacity"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
</div>
