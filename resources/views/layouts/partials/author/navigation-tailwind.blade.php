<nav class="fixed top-0 z-50 w-full bg-[#ECBD2D] border-b border-yellow-500 shadow-md transition-all duration-300"
    :class="sidebarOpen ? 'sm:pl-0' : ''">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button x-on:click="sidebarOpen = !sidebarOpen" data-drawer-target="logo-sidebar"
                    data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-[#335A92] rounded-lg hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-blue-800 transition-colors">
                    <span class="sr-only">Abrir menú lateral</span>
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('home') }}" class="flex ms-2 md:me-24 items-center gap-2 group">
                    <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" class="h-12 w-auto transition-transform group-hover:scale-105" alt="Academia Effi Logo" />
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    @auth
                        <div class="relative ml-3" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" type="button" 
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-200 transition transform hover:scale-105 shadow-sm" 
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Abrir menú de usuario</span>
                                    <img class="h-9 w-9 rounded-full object-cover border border-gray-200" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                                </button>
                            </div>

                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-xl py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 divide-y divide-gray-100" 
                                 role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
                                
                                <div class="px-4 py-3">
                                    <p class="text-xs text-gray-500">Conectado como</p>
                                    <p class="text-sm font-bold text-[#335A92] truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <div class="py-1">
                                    <a href="{{ route('profile.show') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#335A92]" role="menuitem">
                                        <i class="fas fa-user-circle mr-3 text-gray-400 group-hover:text-[#335A92] transition-colors"></i> Perfil
                                    </a>
                                </div>
                                
                                @can('Leer cursos')
                                <div class="py-1">
                                    <a href="{{ route('author.cursos.index') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#335A92]" role="menuitem">
                                        <i class="fas fa-chalkboard-teacher mr-3 text-gray-400 group-hover:text-[#335A92] transition-colors"></i> Instructor
                                    </a>
                                </div>
                                @endcan

                                @can('Ver Dashboard Alumno')
                                <div class="py-1">
                                    <a href="{{ route('alumnos.dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#335A92]" role="menuitem">
                                        <i class="fas fa-graduation-cap mr-3 text-gray-400 group-hover:text-[#335A92] transition-colors"></i> Mis Cursos
                                    </a>
                                </div>
                                @endcan
                                
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="group flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700" role="menuitem">
                                            <i class="fas fa-sign-out-alt mr-3 text-red-400 group-hover:text-red-600 transition-colors"></i> Cerrar Sesión
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
