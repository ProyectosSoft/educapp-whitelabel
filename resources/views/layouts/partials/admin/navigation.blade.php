<nav class="fixed top-0 z-50 w-full bg-white/90 backdrop-blur-xl border-b border-gray-100 shadow-sm transition-all duration-300"
    :class="sidebarOpen ? 'sm:pl-0' : ''">
    <div class="px-4 py-3 lg:px-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end gap-4">
                <button x-on:click="sidebarOpen = !sidebarOpen" data-drawer-target="logo-sidebar"
                    data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('home') }}" class="flex items-center gap-3 group ml-2">
                    <div class="bg-gradient-to-r from-secondary via-primary-700 to-primary-900 px-3 py-1.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform group-hover:scale-105">
                        <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" class="h-9 w-auto object-contain" alt="Academia Effi ERP" />
                    </div>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-white rounded-full focus:outline-none focus:border-gray-300 transition transform hover:scale-105 shadow-md shadow-gray-200 ring-1 ring-gray-100">
                                        <img class="h-9 w-9 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm leading-4 font-bold rounded-full text-primary-900 bg-white hover:bg-gray-50 focus:outline-none focus:bg-gray-50 active:bg-gray-100 transition ease-in-out duration-150 shadow-sm">
                                            {{ Auth::user()->name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    {{ __('Administrar Cuenta') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    <div class="flex items-center font-medium text-gray-700">
                                        <i class="fas fa-user-circle mr-2 text-primary-500"></i> Perfil
                                    </div>
                                </x-dropdown-link>
                                
                                @can('Leer cursos')
                                    <x-dropdown-link href="{{ route('author.cursos.index') }}">
                                        <div class="flex items-center font-medium text-gray-700">
                                            <i class="fas fa-chalkboard-teacher mr-2 text-secondary-600"></i> Instructor
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('Ver Dashboard Alumno')
                                    <x-dropdown-link href="{{ route('alumnos.dashboard') }}">
                                        <div class="flex items-center font-medium text-gray-700">
                                            <i class="fas fa-graduation-cap mr-2 text-blue-500"></i> Mis Cursos
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                <div class="border-t border-gray-100 my-1"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        <div class="flex items-center text-red-600 font-bold">
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
