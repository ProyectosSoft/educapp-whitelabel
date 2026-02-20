<nav class="fixed top-0 z-50 w-full bg-primary-900 border-b border-primary-800 shadow-lg dark:bg-gray-800 dark:border-gray-700 transition-all duration-300"
    :class="sidebarOpen ? 'sm:pl-0' : ''">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button x-on:click="sidebarOpen = !sidebarOpen" data-drawer-target="logo-sidebar"
                    data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-300 rounded-lg hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-700">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('home') }}" class="flex ms-2 md:me-24 items-center gap-2 group">
                    <img src="{{ asset('img/cursos/LOGO_ANIMADO_MORADO.gif') }}" class="h-10 bg-white rounded-full p-1" alt="EducApp Logo" />
                    <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap text-white tracking-tight group-hover:text-secondary transition-colors">EducApp</span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-secondary/50 rounded-full focus:outline-none focus:border-secondary transition transform hover:scale-105 shadow-lg shadow-black/20">
                                        <img class="h-9 w-9 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-primary-800 hover:bg-primary-700 focus:outline-none focus:bg-primary-700 active:bg-primary-900 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Administrar Cuenta') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-circle mr-2 text-primary-500"></i> Perfil
                                    </div>
                                </x-dropdown-link>
                                
                                @can('Leer cursos')
                                    <x-dropdown-link href="{{ route('author.cursos.index') }}">
                                        <div class="flex items-center">
                                            <i class="fas fa-chalkboard-teacher mr-2 text-secondary-600"></i> Instructor
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('Ver Dashboard Alumno')
                                    <x-dropdown-link href="{{ route('alumnos.dashboard') }}">
                                        <div class="flex items-center">
                                             <i class="fas fa-graduation-cap mr-2 text-blue-500"></i> Mis Cursos
                                        </div>
                                    </x-dropdown-link>
                                    
                                    <x-dropdown-link href="{{ route('student.evaluations.index') }}">
                                        <div class="flex items-center">
                                            <i class="fas fa-clipboard-check mr-2 text-green-500"></i> Mis Evaluaciones
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                <div class="border-t border-gray-100"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        <div class="flex items-center text-red-600">
                                            <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                                        </div>
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
