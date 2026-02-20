<nav class="sticky top-0 z-30 bg-white border-b border-gray-100 lg:hidden shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Header: Left side -->
            <div class="flex items-center gap-3">
                <!-- Hamburger button -->
                <button class="text-gray-500 hover:text-[#335A92] transition-colors lg:hidden p-2 rounded-lg hover:bg-gray-50 focus:outline-none" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                    <span class="sr-only">Abrir menú</span>
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <!-- Logo & Title Mobile -->
                <div class="flex items-center gap-2">
                    <img class="h-8 w-auto" src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" alt="Academia Effi">
                    <span class="text-sm font-bold text-[#335A92] hidden sm:block">Panel de Instructor</span>
                </div>
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">
               
               <!-- User Dropdown (Simplified for Mobile Header) -->
               <div class="relative ml-3" x-data="{ open: false }">
                    <div>
                        <button @click="open = !open" type="button" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full object-cover border border-gray-200" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
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
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
                        
                        <div class="px-4 py-2 border-b border-gray-100">
                             <p class="text-sm text-gray-500">Conectado como</p>
                             <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        </div>

                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#335A92]" role="menuitem" tabindex="-1" id="user-menu-item-0">Tu Perfil</a>
                        
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#335A92]" role="menuitem">Volver al Inicio</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 font-medium" role="menuitem" tabindex="-1" id="user-menu-item-2">Cerrar Sesión</a>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</nav>
