<div>
    {{-- Filter Header --}}
    <div class="bg-white border-b border-gray-100 py-6 mb-12 sticky top-0 z-30 shadow-sm/50 backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            
             <h2 class="text-2xl font-bold text-primary-900">Catálogo de Cursos</h2>

             <div class="flex flex-wrap items-center gap-3">
                
                {{-- Reset Filter --}}
                <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-primary-900 transition-colors flex items-center gap-2" wire:click="resetFilters">
                    <i class="fas fa-sync-alt text-xs"></i>
                    Todos
                </button>

                {{-- Dropdown Categoria --}}
                <div class="relative" x-data="{ open: false }">
                    <button class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-full hover:border-primary-500 hover:text-primary-700 transition-all shadow-sm flex items-center gap-2 font-medium text-sm" x-on:click="open = !open" @click.away="open = false">
                        <i class="fas fa-layer-group text-gray-400"></i>
                         Categoría
                        <i class="fas fa-chevron-down text-xs ml-1 text-gray-400"></i>
                    </button>
                    <!-- Dropdown Body -->
                    <div class="absolute right-0 w-56 mt-2 py-2 bg-white border border-gray-100 rounded-2xl shadow-xl z-50 origin-top-right transition-all duration-200" 
                         x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         style="display: none;">
                        @foreach ($categorias as $categoria)
                            <a class="cursor-pointer block px-4 py-2.5 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-900 transition-colors" 
                               wire:click="$set('categoria_id',{{$categoria->id}})" x-on:click="open = false">
                               {{$categoria->nombre}}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Dropdown Nivel --}}
                <div class="relative" x-data="{ open: false }">
                    <button class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-full hover:border-primary-500 hover:text-primary-700 transition-all shadow-sm flex items-center gap-2 font-medium text-sm" x-on:click="open = !open" @click.away="open = false">
                        <i class="fas fa-layer-group text-gray-400"></i>
                         Nivel
                        <i class="fas fa-chevron-down text-xs ml-1 text-gray-400"></i>
                    </button>
                    <!-- Dropdown Body -->
                    <div class="absolute right-0 w-56 mt-2 py-2 bg-white border border-gray-100 rounded-2xl shadow-xl z-50 origin-top-right transition-all duration-200" 
                         x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         style="display: none;">
                        @foreach ($niveles as $nivel)
                            <a class="cursor-pointer block px-4 py-2.5 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-900 transition-colors" 
                               wire:click="$set('nivel_id',{{$nivel->id}})" x-on:click="open = false">
                               {{$nivel->nombre}}
                            </a>
                        @endforeach
                    </div>
                </div>

             </div>
        </div>
    </div>

    {{-- Course Grid --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
        @if($courses->count())
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8 pb-12">
                @foreach ($courses as $course)
                    <x-course-card-afiliados :course="$course"/>
                @endforeach
            </div>
            
            <div class="py-8">
                {{$courses->links()}}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-6">
                    <i class="fas fa-search text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No se encontraron cursos</h3>
                <p class="text-gray-500 max-w-sm mx-auto">Intenta ajustar los filtros de búsqueda para encontrar lo que necesitas.</p>
                <button class="mt-6 px-6 py-3 bg-primary-50 text-primary-700 font-bold rounded-xl hover:bg-primary-100 transition" wire:click="resetFilters">
                    Limpiar Filtros
                </button>
            </div>
        @endif
    </div>
</div>
