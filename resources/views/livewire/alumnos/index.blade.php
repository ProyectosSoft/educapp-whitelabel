<div>
    {{-- Hero Section --}}
    <div class="relative bg-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        {{-- Decorative Blur --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary-400 opacity-20 filter blur-3xl"></div>
        
        <div class="relative px-8 py-10 flex flex-col md:flex-row items-center justify-between z-10">
            <div class="flex items-center mb-6 md:mb-0">
                <img class="h-20 w-20 rounded-full border-2 border-secondary shadow-lg object-cover" src="{{ Auth::user()->profile_photo_url }}"
                    alt="{{ Auth::user()->name }}" />
                <div class="ml-6">
                    <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Panel de Alumno</p>
                    <h1 class="text-3xl font-bold text-white leading-tight">Hola, {{ Auth::user()->name }}</h1>
                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="text-sm text-gray-400 hover:text-white transition flex items-center group">
                            <i class="fas fa-sign-out-alt mr-2 group-hover:text-red-400 transition-colors"></i> Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- Quick Stats --}}
            <div class="flex gap-4">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 text-center border border-white/10 min-w-[100px]">
                    <span class="block text-2xl font-bold text-white">{{ $NumCursos }}</span>
                    <span class="text-[10px] text-gray-300 uppercase tracking-wider font-semibold">Mis Cursos</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 text-center border border-white/10 min-w-[100px]">
                    <span class="block text-2xl font-bold text-secondary">{{ $NumFavoritos }}</span>
                    <span class="text-[10px] text-gray-300 uppercase tracking-wider font-semibold">Favoritos</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 text-center border border-white/10 min-w-[100px]">
                    <span class="block text-2xl font-bold text-white">{{ $NumCart }}</span>
                    <span class="text-[10px] text-gray-300 uppercase tracking-wider font-semibold">Carrito</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="mb-8 flex space-x-1 border-b border-gray-200 dark:border-gray-700">
        <button wire:click="toggleMostrarTabla" 
                class="pb-4 px-4 font-bold text-sm uppercase tracking-wide border-b-2 transition-all duration-300 focus:outline-none flex items-center
                {{ $mostrarTabla ? 'border-primary-600 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
            <i class="fas fa-book-open mr-2"></i> Mis Cursos
        </button>

        <button wire:click="toggleMostrarTablaFav" 
                class="pb-4 px-4 font-bold text-sm uppercase tracking-wide border-b-2 transition-all duration-300 focus:outline-none flex items-center
                {{ $mostrarTablaFav ? 'border-secondary text-secondary-600 dark:text-secondary-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
            <i class="fas fa-heart mr-2"></i> Favoritos
        </button>

        <button wire:click="toggleMostrarTablaCar" 
                class="pb-4 px-4 font-bold text-sm uppercase tracking-wide border-b-2 transition-all duration-300 focus:outline-none flex items-center
                {{ $mostrarTablaCar ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
            <i class="fas fa-shopping-cart mr-2"></i> Carrito
        </button>
    </div>

    {{-- Content Area --}}
    
    {{-- Mis Cursos --}}
    @if ($mostrarTabla)
        @if(count($MisCursos) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($MisCursos as $curso)
                    <article class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                        <div class="relative overflow-hidden">
                            <img class="h-48 w-full object-cover transform group-hover:scale-110 transition duration-500" 
                                 src="{{ Storage::url($curso->image->url) }}" 
                                 alt="{{ $curso->nombre }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold text-gray-800 shadow-sm flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1"></i> {{ $curso->rating }}
                            </div>
                        </div>
                        
                        <div class="p-6 flex-1 flex flex-col">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 leading-tight group-hover:text-primary-600 transition-colors">
                                {{ $curso->nombre }}
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 flex items-center uppercase tracking-wide font-semibold">
                                <i class="fas fa-chalkboard-teacher mr-2 text-primary-400"></i> {{ $curso->teacher->name }}
                            </p>
                            
                            <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                                <a href="{{ route('cursos.show', $curso) }}" class="block w-full py-3 bg-primary-600 hover:bg-primary-700 text-white text-center font-bold rounded-xl transition duration-200 shadow-lg shadow-primary-900/20 transform hover:scale-[1.02]">
                                    Continuar <i class="fas fa-play-circle ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
             <div class="bg-gray-50 dark:bg-gray-800 rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book-open text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Aún no tienes cursos</h3>
                <p class="text-gray-500 dark:text-gray-400 mt-2 mb-6">Explora nuestro catálogo y comienza a aprender hoy mismo.</p>
                <a href="{{ route('cursos.index') }}" class="inline-flex items-center px-6 py-3 bg-secondary text-primary-900 font-bold rounded-xl hover:bg-secondary-400 transition shadow-lg shadow-secondary/20">
                    <i class="fas fa-search mr-2"></i> Explorar Cursos
                </a>
            </div>
        @endif
    @endif

    {{-- Favoritos --}}
    @if($mostrarTablaFav)
        @if(count($cursosEnWishlist) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($cursosEnWishlist as $curso)
                <article class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                    <div class="relative overflow-hidden">
                        <img class="h-48 w-full object-cover transform group-hover:scale-110 transition duration-500" 
                             src="{{ Storage::url($curso->image->url) }}" 
                             alt="{{ $curso->nombre }}">
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold text-gray-800 shadow-sm flex items-center">
                            <i class="fas fa-heart text-red-500 mr-1"></i> Favorito
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 leading-tight group-hover:text-secondary transition-colors">
                            {{ $curso->nombre }}
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 flex items-center uppercase tracking-wide font-semibold">
                            <i class="fas fa-chalkboard-teacher mr-2 text-secondary"></i> {{ $curso->teacher->name }}
                        </p>
                        
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                             <span class="text-xs font-bold text-gray-500 dark:text-gray-400"><i class="fas fa-users mr-1"></i> {{ $curso->students_count }} alumnos</span>
                            <a href="{{ route('cursos.show', $curso) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white rounded-lg text-xs font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        @else
             <div class="bg-gray-50 dark:bg-gray-800 rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart-broken text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tu lista de deseos está vacía</h3>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Guarda los cursos que te interesen para después.</p>
            </div>
        @endif
    @endif

    {{-- Carrito --}}
    @if ($mostrarTablaCar)
        <section class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/50">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Mi Carrito de Compras</h2>
                @if (Cart::count())
                 <a href="javascript:void(0)" wire:click="destroy" class="text-xs font-bold text-red-500 hover:text-red-700 uppercase tracking-wide transition flex items-center bg-red-50 dark:bg-red-900/20 px-3 py-1.5 rounded-lg border border-red-100 dark:border-red-800/30">
                    <i class="fas fa-trash-alt mr-2"></i> Vaciar
                </a>
                @endif
            </div>

            @if (Cart::count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase font-bold text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-4">Curso</th>
                                <th class="px-6 py-4 text-center">Cant.</th>
                                <th class="px-6 py-4 text-center">Precio</th>
                                <th class="px-6 py-4 text-center">Subtotal</th>
                                <th class="px-6 py-4 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ( Cart::content() as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{$item->name}}</td>
                                    <td class="px-6 py-4 text-center">{{$item->qty}}</td>
                                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-300">$ {{number_format($item->price,0,",",".")}}</td>
                                    <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">$ {{number_format($item->price * $item->qty,0,",",".")}}</td>
                                    <td class="px-6 py-4 text-center">
                                        <button wire:click="delete('{{$item->rowId}}')" class="text-gray-400 hover:text-red-500 transition focus:outline-none transform hover:scale-110">
                                            <i class="fas fa-times-circle text-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
                             <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">Total a Pagar:</td>
                                <td class="px-6 py-4 text-center font-bold text-xl text-green-600 dark:text-green-400">{{Cart::subtotal()}}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="p-6 bg-gray-50 dark:bg-gray-800 text-right">
                     <a href="{{route('orders.create')}}" class="inline-flex items-center px-8 py-3 bg-secondary text-primary-900 font-bold rounded-xl hover:bg-secondary-400 transition shadow-lg shadow-secondary/20 transform hover:-translate-y-0.5">
                        Proceder al Pago <i class="fas fa-credit-card ml-2"></i>
                    </a>
                </div>

            @else
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-lg text-gray-500 dark:text-gray-400 font-medium mb-1">Tu carrito está vacío</p>
                    <a href="/" class="mt-4 text-secondary font-bold hover:text-secondary-400 hover:underline">
                        Explorar Cursos
                    </a>
                </div>
            @endif
        </section>
    @endif
</div>
