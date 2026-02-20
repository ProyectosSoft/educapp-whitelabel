@php
    $nav_links=[
        [
            'name' => 'Inicio',
            'route' => route('home'),
            'active' =>request()->routeIs('home')
        ],
        [
            'name' =>'Cursos',
            'route'=>route('cursos.index'),
            'active' =>request()->routeIs('cursos.*')
        ],
        [
            'name' => 'Para Empresas',
            'route' => route('register-business'),
            'active' => request()->routeIs('register-business'),
            'special' => true
        ],
];
@endphp

<nav x-data="{ open: false }" class="bg-gradient-to-r from-primary-900 via-primary-800 to-primary-700 shadow-lg rounded-b-3xl relative z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="group">
                        {{-- Assuming x-application-mark renders the logo. We add a white filter/color if needed via class or context --}}
                        <div class="bg-white/10 p-2 rounded-lg group-hover:bg-white/20 transition">
                            <x-application-mark class="block h-10 w-auto text-white" /> 
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    @foreach ($nav_links as $nav_link)
                        @if(isset($nav_link['special']) && $nav_link['special'])
                            <a href="{{ $nav_link['route'] }}" class="inline-flex items-center px-5 py-2 text-sm font-bold text-primary-900 bg-accent hover:bg-white hover:text-accent transition duration-200 ease-in-out rounded-full shadow-lg transform hover:-translate-y-0.5">
                                <i class="fas fa-building mr-2"></i> {{ $nav_link['name'] }}
                            </a>
                        @else
                            <a href="{{ $nav_link['route'] }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ $nav_link['active'] ? 'text-white border-b-2 border-accent' : 'text-primary-100 hover:text-white hover:border-b-2 hover:border-white/50' }}">
                                {{ $nav_link['name'] }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>
                            <x-slot name="content">
                                <div class="w-60">
                                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Team') }}</div>
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">{{ __('Team Settings') }}</x-dropdown-link>
                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">{{ __('Create New Team') }}</x-dropdown-link>
                                    @endcan
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>
                                        <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Switch Teams') }}</div>
                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition">
                                        <img class="h-10 w-10 rounded-full object-cover border-2 border-accent" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-primary-900 bg-secondary hover:bg-secondary-300 focus:outline-none transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Account') }}</div>
                                <x-dropdown-link href="{{ route('profile.show') }}">Perfil</x-dropdown-link>
                                @can('Leer cursos')
                                    <x-dropdown-link href="{{ route('afiliados.financiero') }}">Financiero</x-dropdown-link>
                                @endcan
                                @can('Ver dashboard')
                                    <x-dropdown-link href="{{ route('admin.home') }}">Administrador</x-dropdown-link>
                                @endcan
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</x-dropdown-link>
                                @endif
                                <div class="border-t border-gray-200"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">{{ __('Log Out') }}</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="font-semibold text-primary-100 hover:text-white transition">Ingresar</a>
                            <a href="{{ route('register') }}" class="px-5 py-2 bg-white text-primary-900 font-bold rounded-full hover:bg-gray-100 transition shadow-lg">Registrarse</a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-primary-100 hover:text-white hover:bg-primary-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-primary-800 border-t border-primary-700 rounded-b-3xl">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @foreach ($nav_links as $nav_link )
                <a href="{{ $nav_link['route'] }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $nav_link['active'] ? 'text-white bg-primary-900' : 'text-primary-100 hover:text-white hover:bg-primary-700' }} transition">
                    @if(isset($nav_link['special']) && $nav_link['special'])
                        <i class="fas fa-building mr-2 text-accent"></i>
                    @endif
                    {{ $nav_link['name'] }}
                </a>
            @endforeach
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-4 border-t border-primary-700 px-4">
                <div class="flex items-center">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-accent" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif
                    <div>
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-primary-200">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="text-primary-100 hover:text-white">Perfil</x-responsive-nav-link>
                    @can('Leer cursos')
                        <x-dropdown-link href="{{ route('author.cursos.index') }}">Instructor</x-dropdown-link>
                    @endcan
                    <form method="POST" action="{{ route('logout') }}" x-data>
                         @csrf
                         <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-primary-100 hover:text-white">{{ __('Log Out') }}</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="py-4 border-t border-primary-700 px-4 space-y-2">
                <a href="{{ route('login') }}" class="block text-center px-4 py-2 border border-primary-200 text-primary-100 rounded-full hover:text-white hover:border-white transition">Login</a>
                <a href="{{ route('register') }}" class="block text-center px-4 py-2 bg-accent text-primary-900 font-bold rounded-full hover:bg-yellow-300 transition">Registrar</a>
            </div>
        @endauth
    </div>
</nav>
