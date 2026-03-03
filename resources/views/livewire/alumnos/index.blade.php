<div>
    {{-- Hero Section Premium Corporativa --}}
    <div class="bg-white rounded-[2rem] shadow-lg shadow-gray-200/50 ring-1 ring-gray-100 p-8 md:p-12 relative overflow-hidden group mb-8">
        {{-- Abstract Corporate Decoration --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3 pointer-events-none transition-transform duration-700 group-hover:scale-110"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary-50/50 rounded-full blur-3xl transform -translate-x-1/3 translate-y-1/3 pointer-events-none transition-transform duration-700 group-hover:scale-105"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="relative flex-shrink-0">
                    <div class="absolute inset-0 bg-primary-900 rounded-full blur-md opacity-20 transform translate-y-2"></div>
                    <img class="h-24 w-24 rounded-full border-4 border-white shadow-sm relative z-10 object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    <div class="absolute -bottom-1 -right-1 bg-accent w-8 h-8 rounded-full border-2 border-white flex items-center justify-center shadow-md z-20">
                        <i class="fas fa-check text-primary-900 text-xs"></i>
                    </div>
                </div>
                
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-primary-900 mb-2 tracking-tight">
                        Hola, <span class="text-secondary">{{ Auth::user()->name }}</span>
                    </h1>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary-50 text-primary-800 text-xs font-bold ring-1 ring-primary-100 shadow-sm">
                            <i class="fas fa-user-graduate text-secondary"></i> Panel de Alumno
                        </span>
                        
                        <form action="{{ route('logout') }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5 ring-1 ring-transparent hover:ring-red-100">
                                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            {{-- Quick Stats Modernos --}}
            <div class="flex gap-4 md:gap-5 justify-center mt-4 md:mt-0">
                <div class="flex flex-col items-center bg-white rounded-2xl p-4 min-w-[100px] shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:shadow-lg hover:shadow-primary-900/10 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-primary-50 text-primary-800 flex items-center justify-center mb-2 group-hover:bg-primary-900 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-book-open text-lg"></i>
                    </div>
                    <span class="text-2xl font-black text-primary-900">{{ $NumCursos }}</span>
                    <span class="text-[10px] uppercase font-bold text-gray-500 tracking-wider">Cursos</span>
                </div>
                
                <div class="flex flex-col items-center bg-white rounded-2xl p-4 min-w-[100px] shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:shadow-lg hover:shadow-secondary/10 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-secondary-50 text-secondary-700 flex items-center justify-center mb-2 group-hover:bg-secondary group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-heart text-lg"></i>
                    </div>
                    <span class="text-2xl font-black text-secondary">{{ $NumFavoritos }}</span>
                    <span class="text-[10px] uppercase font-bold text-gray-500 tracking-wider">Favoritos</span>
                </div>
                
                <div class="flex flex-col items-center bg-white rounded-2xl p-4 min-w-[100px] shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:shadow-lg hover:shadow-accent/20 hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent-700 flex items-center justify-center mb-2 group-hover:bg-accent group-hover:text-primary-900 transition-colors duration-300">
                        <i class="fas fa-shopping-cart text-lg"></i>
                    </div>
                    <span class="text-2xl font-black text-gray-800">{{ $NumCart }}</span>
                    <span class="text-[10px] uppercase font-bold text-gray-500 tracking-wider">Carrito</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation Corporativos Limpios --}}
    <div class="mb-8 flex flex-wrap gap-2 p-1.5 bg-white ring-1 ring-gray-100 rounded-2xl shadow-sm w-full max-w-fit mx-auto md:mx-0">
        <button wire:click="toggleMostrarTabla" 
                class="px-5 py-2.5 font-bold text-sm tracking-wide rounded-xl transition-all duration-300 focus:outline-none flex items-center 
                {{ $mostrarTabla ? 'bg-primary-900 text-white shadow-md shadow-primary-900/20' : 'bg-transparent text-gray-500 hover:bg-primary-50 hover:text-primary-900' }}">
            <i class="fas fa-book-open mr-2 {{ $mostrarTabla ? 'text-accent' : '' }}"></i> Mis Cursos
        </button>

        <button wire:click="toggleMostrarTablaFav" 
                class="px-5 py-2.5 font-bold text-sm tracking-wide rounded-xl transition-all duration-300 focus:outline-none flex items-center 
                {{ $mostrarTablaFav ? 'bg-secondary text-white shadow-md shadow-secondary/20' : 'bg-transparent text-gray-500 hover:bg-secondary-50 hover:text-secondary' }}">
            <i class="fas fa-heart mr-2 {{ $mostrarTablaFav ? 'text-white' : '' }}"></i> Favoritos
        </button>

        <button wire:click="toggleMostrarTablaCar" 
                class="px-5 py-2.5 font-bold text-sm tracking-wide rounded-xl transition-all duration-300 focus:outline-none flex items-center 
                {{ $mostrarTablaCar ? 'bg-accent text-primary-950 shadow-md shadow-accent/20' : 'bg-transparent text-gray-500 hover:accent-50/50 hover:text-accent-700' }}">
            <i class="fas fa-shopping-cart mr-2 {{ $mostrarTablaCar ? 'text-primary-950' : '' }}"></i> Carrito
        </button>
    </div>

    {{-- Content Area --}}
    
    {{-- Mis Cursos --}}
    @if ($mostrarTabla)
        @if(count($MisCursos) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach ($MisCursos as $curso)
                    <article class="bg-white rounded-[2rem] shadow-sm ring-1 ring-gray-100 overflow-hidden group hover:shadow-xl hover:shadow-primary-900/10 hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                        <div class="relative overflow-hidden">
                            <img class="h-48 w-full object-cover transform group-hover:scale-105 transition duration-700" 
                                 src="{{ Storage::url($curso->image->url) }}" 
                                 alt="{{ $curso->nombre }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary-900/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            
                            {{-- Color Accent Bar --}}
                            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-accent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-lg text-xs font-bold text-primary-900 shadow-sm flex items-center ring-1 ring-gray-100">
                                <i class="fas fa-star text-accent mr-1.5"></i> {{ $curso->rating }}
                            </div>
                        </div>
                        
                        <div class="p-6 md:p-8 flex-1 flex flex-col z-10 bg-white">
                            <h2 class="text-xl font-extrabold text-primary-900 mb-3 leading-tight group-hover:text-secondary transition-colors duration-300">
                                {{ $curso->nombre }}
                            </h2>
                            <p class="text-sm text-gray-500 mb-6 flex items-center font-medium">
                                <span class="w-7 h-7 rounded-full bg-primary-50 text-secondary flex items-center justify-center mr-2.5">
                                    <i class="fas fa-chalkboard-teacher text-xs"></i>
                                </span>
                                {{ $curso->teacher->name }}
                            </p>
                            
                            <div class="mt-auto pt-5 border-t border-gray-100">
                                <a href="{{ route('cursos.show', $curso) }}" class="flex justify-between items-center w-full py-3.5 px-5 bg-primary-50 hover:bg-primary-900 text-primary-900 hover:text-white font-bold rounded-xl transition-all duration-300 group/btn shadow-sm">
                                    <span>Continuar</span>
                                    <i class="fas fa-arrow-right transform group-hover/btn:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
             <div class="bg-white rounded-[2rem] p-12 md:p-16 text-center ring-1 ring-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary-50/50 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
                <div class="relative z-10 max-w-md mx-auto">
                    <div class="w-20 h-20 bg-primary-50 text-primary-900 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm ring-1 ring-primary-100 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                        <i class="fas fa-book-open text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-primary-900 mb-3 tracking-tight">Aún no tienes cursos</h3>
                    <p class="text-gray-500 mb-8 font-medium">Explora nuestro catálogo completo y comienza a aprender una nueva habilidad hoy mismo.</p>
                    <a href="{{ route('cursos.index') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-accent text-primary-950 font-extrabold rounded-xl hover:bg-yellow-400 transition-all shadow-md shadow-accent/20 transform hover:-translate-y-0.5 w-full sm:w-auto">
                        <i class="fas fa-search mr-2"></i> Explorar Catálogo
                    </a>
                </div>
            </div>
        @endif
    @endif

    {{-- Favoritos --}}
    @if($mostrarTablaFav)
        @if(count($cursosEnWishlist) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach ($cursosEnWishlist as $curso)
                <article class="bg-white rounded-[2rem] shadow-sm ring-1 ring-gray-100 overflow-hidden group hover:shadow-xl hover:shadow-secondary/10 hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                    <div class="relative overflow-hidden">
                        <img class="h-48 w-full object-cover transform group-hover:scale-105 transition duration-700" 
                             src="{{ Storage::url($curso->image->url) }}" 
                             alt="{{ $curso->nombre }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary-900/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>

                        {{-- Color Accent Bar --}}
                        <div class="absolute bottom-0 left-0 w-full h-1.5 bg-secondary opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-lg text-xs font-bold text-secondary shadow-sm flex items-center ring-1 ring-gray-100">
                            <i class="fas fa-heart text-secondary mr-1.5"></i> Favorito
                        </div>
                    </div>
                    
                    <div class="p-6 md:p-8 flex-1 flex flex-col z-10 bg-white">
                        <h2 class="text-xl font-extrabold text-primary-900 mb-3 leading-tight group-hover:text-secondary transition-colors duration-300">
                            {{ $curso->nombre }}
                        </h2>
                        <p class="text-sm text-gray-500 mb-6 flex items-center font-medium">
                            <span class="w-7 h-7 rounded-full bg-secondary-50 text-secondary flex items-center justify-center mr-2.5">
                                <i class="fas fa-chalkboard-teacher text-xs"></i>
                            </span>
                            {{ $curso->teacher->name }}
                        </p>
                        
                        <div class="flex items-center justify-between mt-auto pt-5 border-t border-gray-100">
                            <span class="text-xs font-bold text-gray-500 flex items-center bg-gray-50 ring-1 ring-gray-100 px-3 py-1.5 rounded-lg">
                                <i class="fas fa-users mr-1.5 text-secondary"></i> {{ $curso->students_count }} res.
                            </span>
                            <a href="{{ route('cursos.show', $curso) }}" class="inline-flex items-center px-4 py-2 bg-secondary text-white rounded-lg font-bold hover:bg-secondary-600 transition-colors duration-300 shadow-sm shadow-secondary/20 text-sm">
                                Detalles
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        @else
             <div class="bg-white rounded-[2rem] p-12 md:p-16 text-center ring-1 ring-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-64 h-64 bg-secondary-50/50 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
                <div class="relative z-10 max-w-md mx-auto">
                    <div class="w-20 h-20 bg-secondary-50 text-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm ring-1 ring-secondary-100 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                        <i class="fas fa-heart-broken text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-primary-900 mb-3 tracking-tight">Lista vacía</h3>
                    <p class="text-gray-500 mb-2 font-medium">Guarda los cursos que te interesen y los verás aquí para considerarlos después.</p>
                </div>
            </div>
        @endif
    @endif

    {{-- Carrito --}}
    @if ($mostrarTablaCar)
        <section class="bg-white rounded-[2rem] shadow-lg shadow-gray-200/50 ring-1 ring-gray-100 overflow-hidden relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            
            <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 relative z-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-accent/10 text-accent-600 rounded-xl flex items-center justify-center mr-4 shadow-sm ring-1 ring-accent/20">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-extrabold text-primary-900 tracking-tight">Mi Carrito</h2>
                </div>
                
                @if (Cart::count())
                 <a href="javascript:void(0)" wire:click="destroy" class="text-xs font-bold text-red-500 hover:text-white uppercase tracking-wide transition flex items-center bg-white hover:bg-red-500 px-4 py-2 rounded-lg ring-1 ring-red-200 shadow-sm">
                    <i class="fas fa-trash-alt mr-2"></i> Vaciar
                </a>
                @endif
            </div>

            @if (Cart::count())
                <div class="overflow-x-auto relative z-10">
                    <table class="w-full text-left text-sm text-gray-700">
                        <thead class="bg-primary-50 text-xs uppercase font-extrabold text-primary-900 tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Curso</th>
                                <th class="px-6 py-4 text-center">Cant.</th>
                                <th class="px-6 py-4 text-right">Precio</th>
                                <th class="px-6 py-4 text-right">Subtotal</th>
                                <th class="px-6 py-4 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ( Cart::content() as $item)
                                <tr class="hover:bg-gray-50 bg-white transition duration-300">
                                    <td class="px-6 py-5 font-bold text-primary-900 text-sm flex items-center gap-3">
                                        <div class="w-1.5 h-1.5 rounded-full bg-accent"></div>
                                        {{$item->name}}
                                    </td>
                                    <td class="px-6 py-5 text-center font-semibold text-gray-600">{{$item->qty}}</td>
                                    <td class="px-6 py-5 text-right text-gray-500 font-medium">$ {{number_format($item->price,0,",",".")}}</td>
                                    <td class="px-6 py-5 text-right font-extrabold text-primary-900">$ {{number_format($item->price * $item->qty,0,",",".")}}</td>
                                    <td class="px-6 py-5 text-center">
                                        <button wire:click="delete('{{$item->rowId}}')" class="w-8 h-8 rounded-lg bg-white text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all focus:outline-none ring-1 ring-gray-200">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/50">
                             <tr>
                                <td colspan="3" class="px-6 py-5 text-right font-bold text-gray-500 uppercase text-xs tracking-widest">Total a Pagar:</td>
                                <td class="px-6 py-5 text-right font-black text-xl text-primary-900">$ {{Cart::subtotal()}}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="p-6 md:p-8 bg-white border-t border-gray-100 relative z-10 flex flex-col sm:flex-row justify-end items-center gap-6">
                    <span class="text-gray-500 font-medium text-xs flex items-center bg-gray-50 px-3 py-1.5 rounded-md ring-1 ring-gray-100">
                        <i class="fas fa-lock text-secondary mr-2"></i> Transacción Segura
                    </span>
                    <a href="{{route('orders.create')}}" class="inline-flex items-center justify-center px-8 py-3.5 bg-accent text-primary-950 font-extrabold rounded-xl hover:bg-yellow-400 transition-all shadow-md shadow-accent/20 transform hover:-translate-y-0.5 w-full sm:w-auto">
                        Ir al Pago <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

            @else
                <div class="flex flex-col items-center justify-center py-16 px-4 relative z-10 text-center">
                    <div class="w-20 h-20 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center mb-5 ring-1 ring-gray-100">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                    </div>
                    <p class="text-xl font-extrabold text-primary-900 mb-2">Tu carrito está vacío</p>
                    <p class="text-gray-500 mb-6 text-sm">Aún no has añadido ningún curso a tu carrito.</p>
                    <a href="/" class="inline-flex items-center px-6 py-3 bg-primary-900 text-white font-bold rounded-xl hover:bg-primary-800 transition shadow-md shadow-primary-900/20 text-sm">
                        <i class="fas fa-search mr-2 text-accent"></i> Explorar Cursos
                    </a>
                </div>
            @endif
        </section>
    @endif
</div>
