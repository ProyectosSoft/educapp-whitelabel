

<header class="bg-gradient-to-b from-secondary via-primary-700 to-primary-900 sticky top-4 z-50 shadow-2xl rounded-2xl mx-4 border-none" x-data="dropdown()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center h-20 justify-between md:justify-start">
        
        {{-- Left Toggle (Cursos) --}}
        <a :class="{ 'bg-white/20 text-white': open, 'text-blue-100 hover:text-white hover:bg-white/10': !open }" 
           x-on:click="show()"
           class="flex flex-col items-center cursor-pointer font-medium h-full justify-center order-last md:order-first px-6 md:px-4 transition-colors duration-200 rounded-bl-[30px]">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span class="text-xs hidden md:block mt-1 font-bold uppercase tracking-wider">Cursos</span>
        </a>

        {{-- Logo: Academia Effi ERP --}}
        <a href="/" class="flex items-center ml-6 md:ml-6 hover:opacity-80 transition-opacity">
             <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" class="h-14 w-auto object-contain" alt="Academia Effi ERP">
        </a>

        {{-- Search Bar --}}
        <div class="flex-1 hidden md:block mx-8 max-w-2xl">
            @livewire('search')
        </div>
        
        {{-- internal/Business Button --}}
        <div class="hidden md:flex items-center ml-auto mr-4">
             <a href="{{ route('register-business') }}" class="px-5 py-2.5 rounded-xl bg-white/10 text-white font-bold hover:bg-white hover:text-secondary transition-all duration-200 border border-white/20 hover:border-white text-sm flex items-center whitespace-nowrap gap-2">
                <i class="fas fa-building text-blue-100 group-hover:text-secondary"></i>
                <span>Portal Empresa</span>
            </a>
        </div>

        {{-- User Actions --}}
        <div class="mx-6 md:mx-0 relative hidden md:flex items-center gap-4">
            @livewire('dropdown-wishlist') 
            @livewire('dropdown-cart')
            
             <div class="h-8 w-px bg-white/20 mx-2"></div>

            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-white/50 transition shadow-sm hover:shadow-md">
                                <img class="h-9 w-9 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                    alt="{{ Auth::user()->name }}" />
                            </button>
                        @else
                            <button type="button" class="inline-flex items-center gap-2 px-3 py-2 border border-white/20 text-sm leading-4 font-bold rounded-lg text-white bg-white/10 hover:text-secondary hover:bg-white focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-blue-100 group-hover:text-secondary"></i>
                            </button>
                        @endif
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400 uppercase font-bold tracking-wider">
                            {{ __('Mi Cuenta') }}
                        </div>

                        <x-dropdown-link href="{{ route('profile.show') }}">
                             <i class="fas fa-user-circle mr-2 text-primary-400"></i> Perfil
                        </x-dropdown-link>

                        @can('Leer cursos')
                            <x-dropdown-link href="{{ route('author.cursos.index') }}">
                                <i class="fas fa-chalkboard-teacher mr-2 text-primary-400"></i> Instructor
                            </x-dropdown-link>
                        @endcan

                        @can('Ver Dashboard Alumno')
                            <x-dropdown-link href="{{ route('alumnos.dashboard') }}">
                                <i class="fas fa-book-reader mr-2 text-primary-400"></i> Mis Cursos
                            </x-dropdown-link>
                            
                            <x-dropdown-link href="{{ route('student.evaluations.index') }}">
                                <i class="fas fa-tasks mr-2 text-primary-400"></i> Mis Evaluaciones
                            </x-dropdown-link>
                        @endcan

                        @can('Ver Dashboard Instructor')
                            <x-dropdown-link href="{{ route('author.financiero') }}">
                                <div class="text-gray-600">Financiero</div>
                            </x-dropdown-link>
                        @endcan
                        
                        @can('Ver Dashboard Afiliado')
                            <x-dropdown-link href="{{ route('afiliados.dashboard') }}">
                                <div class="text-gray-600">Mis Cursos</div>
                            </x-dropdown-link>
                        @endcan

                        @can('Ver Dashboard Admin')
                            <x-dropdown-link href="{{ route('admin.financiero') }}">
                                <div class="text-gray-600">Financiero</div>
                            </x-dropdown-link>
                        @endcan
                        
                        @can('Ver dashboard')
                            <x-dropdown-link href="{{ route('admin.home') }}">
                                <i class="fas fa-cog mr-2 text-primary-400"></i> Administrador
                            </x-dropdown-link>
                        @endcan

                        <div class="border-t border-gray-100 my-1"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @else
                <div class="flex items-center gap-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <i class="fas fa-user-circle text-blue-100 hover:text-white text-3xl cursor-pointer transition"></i>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt mr-2"></i> {{ __('Log in') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('register') }}">
                                <i class="fas fa-id-card mr-2"></i> {{ __('Register') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth
        </div>
        
        {{-- Mobile Cart/Wishlist --}}
        <div class="hidden md:block mt-2">
           {{-- Already handled in desktop block --}}
        </div>
    </div>

    {{-- Mobile Menu --}}
    <nav id="navigation-menu" :class="{ 'block': open, 'hidden': !open }" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="absolute w-full z-40 left-0 top-full">
        
        {{-- Desktop Dropdown Panel --}}
        <div class="hidden md:block max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4" x-on:click.away="close()">
            <div class="bg-white rounded-3xl shadow-2xl grid grid-cols-12 overflow-hidden border border-gray-100" style="min-height: 400px;" x-data="{ selected: {{ $categorias->first()->id ?? 'null' }} }">
                
                {{-- Sidebar Categories --}}
                <div class="col-span-3 bg-gray-50 py-4 flex flex-col border-r border-gray-100">
                    <p class="px-6 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Categorías</p>
                    @foreach ($categorias as $categoria)
                        <a @mouseover="selected = {{ $categoria->id }}"
                        :class="{ 'bg-white text-secondary shadow-md transform scale-[1.02]': selected == {{ $categoria->id }}, 'text-gray-600 hover:bg-gray-100 hover:text-gray-900': selected != {{ $categoria->id }} }"
                        class="px-6 py-3 text-sm font-bold flex items-center transition-all duration-200 cursor-pointer mx-2 rounded-xl mb-1">
                            <span class="mr-3 text-lg" :class="{ 'text-secondary': selected == {{ $categoria->id }}, 'text-gray-400': selected != {{ $categoria->id }} }">
                                {!! $categoria->icon !!}
                            </span>
                            {{ $categoria->nombre }}
                        </a>
                    @endforeach
                </div>

                {{-- Content Area --}}
                <div class="col-span-9 p-8 bg-white relative">
                    @if(!$categorias->count())
                        <div class="flex flex-col items-center justify-center h-full text-gray-400">
                             <i class="fas fa-inbox text-4xl mb-4"></i>
                             <p>No hay categorías disponibles</p>
                        </div>
                    @endif

                    @foreach ($categorias as $categoria)
                        <div x-show="selected == {{ $categoria->id }}" 
                             x-transition:enter="transition ease-out duration-300" 
                             x-transition:enter-start="opacity-0 translate-x-4" 
                             x-transition:enter-end="opacity-100 translate-x-0" 
                             class="absolute inset-0 p-8 overflow-y-auto"
                             style="display: none;">
                            
                            <div class="mb-6 pb-4 border-b border-gray-100">
                                <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                                    <span class="mr-3 text-secondary text-3xl">{!! $categoria->icon !!}</span>
                                    {{ $categoria->nombre }}
                                </h3>
                            </div>
                            
                            <x-navigation-subcategories :categoria="$categoria" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Phone Menu --}}
        <div class="bg-white h-[calc(100vh-5rem)] overflow-y-auto md:hidden pb-10 shadow-inner">
            <div class="px-4 py-3 mb-2 bg-gray-50 border-b border-gray-100">
                @livewire('search')
            </div>

            <p class="text-xs uppercase font-bold text-gray-400 px-4 my-2 mt-4">Empresas</p>
             <a href="{{ route('register-business') }}" class="py-3 px-4 text-sm flex items-center text-gray-600 hover:bg-gray-50 transition-colors">
                <span class="flex justify-center w-8 mr-2 text-primary-500">
                    <i class="fas fa-building"></i>
                </span>
                Portal Empresa
            </a>

            <div class="border-t border-gray-100 my-2"></div>
            
            <p class="text-xs uppercase font-bold text-gray-400 px-4 my-2">Usuarios</p>
            @livewire('cart-mobil')

            @auth
                <a href="{{ route('profile.show') }}" class="py-3 px-4 text-sm flex items-center text-gray-600 hover:bg-gray-50">
                    <span class="flex justify-center w-8 mr-2 text-primary-500"><i class="far fa-address-card"></i></span>
                    Perfil
                </a>
                <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="py-3 px-4 text-sm flex items-center text-red-500 hover:bg-red-50">
                    <span class="flex justify-center w-8 mr-2"><i class="fas fa-sign-out-alt"></i></span>
                    Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            @else
                <a href="{{ route('login') }}" class="py-3 px-4 text-sm flex items-center text-gray-600 hover:bg-gray-50">
                    <span class="flex justify-center w-8 mr-2 text-primary-500"><i class="fas fa-user-circle"></i></span>
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="py-3 px-4 text-sm flex items-center text-gray-600 hover:bg-gray-50">
                    <span class="flex justify-center w-8 mr-2 text-primary-500"><i class="fas fa-fingerprint"></i></span>
                    Registro
                </a>
            @endauth
        </div>
    </nav>
</header>
