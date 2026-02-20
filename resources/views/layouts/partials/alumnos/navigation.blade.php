<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button x-on:click="sidebarOpen = !sidebarOpen" data-drawer-target="logo-sidebar"
                    data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg  hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="https://educapp.net" class="flex ms-2 md:me-24">
                    <img src="{{ asset('img/cursos/LOGO_ANIMADO_MORADO.gif') }}" class="h-8 me-3" alt="FlowBite Logo" />
                    <span>
                        <img src="{{ asset('img/cursos/Logo_EducApp_6_V1_Mo.png') }}" class="h-8 me-3"
                            alt="FlowBite Logo" /></span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
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
                                    <div class=" text-greenLime_400">
                                        {{ __('Manage Account') }}
                                    </div>
                                </div>

                                {{-- <x-dropdown-link href="{{ route('orders.show') }}">
                                    Mis Ordenes
                                </x-dropdown-link> --}}

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    <div class=" text-greenLime_400">
                                        Perfil
                                    </div>
                                </x-dropdown-link>
                                @can('Leer cursos')
                                    <x-dropdown-link href="{{ route('author.cursos.index') }}">
                                        Autor
                                    </x-dropdown-link>
                                @endcan

                                @can('Ver Dashboard Alumno')
                                    <x-dropdown-link href="{{ route('alumnos.dashboard') }}">
                                        <div class=" text-greenLime_400">
                                            Mis Cursos
                                        </div>
                                    </x-dropdown-link>
                                    
                                    <x-dropdown-link href="{{ route('student.evaluations.index') }}">
                                        <div class=" text-greenLime_400">
                                            Mis Evaluaciones
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('Ver Dashboard Instructor')
                                    <x-dropdown-link href="{{ route('author.financiero') }}">
                                        <div class=" text-greenLime_400">
                                            Financiero
                                        </div>
                                    </x-dropdown-link>
                                @endcan
                                @can('Ver Dashboard Afiliado')
                                    <x-dropdown-link href="{{ route('afiliados.dashboard') }}">
                                        <div class=" text-greenLime_400">
                                            Mis Cursos
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('Ver Dashboard Admin')
                                    <x-dropdown-link href="{{ route('admin.financiero') }}">
                                        <div class=" text-greenLime_400">
                                            Financiero
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('Ver dashboard')
                                    <x-dropdown-link href="{{ route('admin.home') }}">
                                        Administrador
                                    </x-dropdown-link>
                                @endcan



                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        <div class=" text-greenLime_400">
                                            {{ __('Log Out') }}
                                        </div>
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
