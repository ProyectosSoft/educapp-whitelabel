<div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="bg-white  rounded-lg shadow-lg p-6">
            <div class="flex">
                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                    alt="{{ Auth::user()->name }}" />
                <div class="ml-4 flex-1">
                    <h2 class="tetx-lg font-semibold">
                        Bienvenido, {{ Auth::user()->name }}
                    </h2>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-white  rounded-lg shadow-lg p-6 flex items-center">
            <div class="flex">
                <!-- Primer div con clases ml-4 (margin-left), rounded-full (bordes redondeados) y flex items-center -->
                <div class="ml-4 rounded-full bg-greenLime_500 flex items-center justify-center w-10 h-10">
                    <!-- Número de cursos del usuario -->
                    <span class="text-white"> {{ $NumCursos }} </span>
                </div>
                <!-- Segundo div con clases ml-4 (margin-left) y flex-1 (crecimiento flexible) -->
                <div class="ml-4 flex-1 flex items-center flex-col">
                    <!-- Contenido del segundo div -->
                    <h2 class="text-lg font-semibold">
                        Mis Cursos
                    </h2>
                    <!-- Enlace "Ver Mis Cursos" con un ID y evento onclick -->
                    <a href="#" wire:click="toggleMostrarTabla"
                        class="ml-2 text-sm text-blue-500 hover:underline">Ver Mis Cursos</a>
                    {{-- <a href="#" id="ocultar-cursos" class="ml-2 text-sm text-blue-500 hover:underline"
                    style="display: none;">Ocultar Mis Cursos</a> --}}
                </div>
            </div>
        </div>
        <div class="bg-white  rounded-lg shadow-lg p-6 flex items-center">
            <div class="flex">
                <!-- Primer div con clases ml-4 (margin-left), rounded-full (bordes redondeados) y flex items-center -->
                <div class="ml-4 rounded-full bg-greenLime_500 flex items-center justify-center w-10 h-10">
                    <!-- Número de cursos del usuario -->
                    <span class="text-white"> {{ $NumFavoritos }} </span>
                </div>
                <!-- Segundo div con clases ml-4 (margin-left) y flex-1 (crecimiento flexible) -->
                <div class="ml-4 flex-1 flex items-center flex-col">
                    <!-- Contenido del segundo div -->
                    <h2 class="text-lg font-semibold">
                        Mis Favoritos
                    </h2>
                    <!-- Enlace "Ver Mis Cursos" con un ID y evento onclick -->
                    <a href="#" wire:click="toggleMostrarTablaFav"
                        class="ml-2 text-sm text-blue-500 hover:underline">Ver Mis Favoritos</a>
                    {{-- <a href="#" id="ocultar-cursos" class="ml-2 text-sm text-blue-500 hover:underline"
                    style="display: none;">Ocultar Mis Cursos</a> --}}
                </div>
            </div>
        </div>
        <div class="bg-white  rounded-lg shadow-lg p-6 flex items-center">
            <div class="flex">
                <!-- Primer div con clases ml-4 (margin-left), rounded-full (bordes redondeados) y flex items-center -->
                <div class="ml-4 rounded-full bg-greenLime_500 flex items-center justify-center w-10 h-10">
                    <!-- Número de cursos del usuario -->
                    <span class="text-white"> {{ $NumCart }} </span>
                </div>
                <!-- Segundo div con clases ml-4 (margin-left) y flex-1 (crecimiento flexible) -->
                <div class="ml-4 flex-1 flex items-center flex-col">
                    <!-- Contenido del segundo div -->
                    <h2 class="text-lg font-semibold">
                        Mis Carrito
                    </h2>
                    <!-- Enlace "Ver Mis Cursos" con un ID y evento onclick -->
                    <a href="#" wire:click="toggleMostrarTablaCar"
                        class="ml-2 text-sm text-blue-500 hover:underline">Ver Mi Carrito</a>
                    {{-- <a href="#" id="ocultar-cursos" class="ml-2 text-sm text-blue-500 hover:underline"
                    style="display: none;">Ocultar Mis Cursos</a> --}}
                </div>
            </div>
        </div>
    </div>
    @if($mostrarTablaFav)
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-3">
        @foreach ($cursosEnWishlist as $curso)
            <article class="bg-greenLime_50 shadow-lg rounded-lg overflow-hidden flex flex-col">
                <img class="rounded-t-lg h-48 w-full object-cover"
                    src= "{{ 'data:image/image;base64,' . base64_encode(Storage::get($curso->image->url)) }}"
                    alt="">
                <div class="px-8 py-4 flex-1 flex flex-col">
                    <h1 class="text-xl text-greenLime_500  mb-2 leading-6">{{ Str::limit($curso->nombre, 35) }}
                    </h1>
                    <p class="text-greenLime_500 text-sm mb-2 mt-auto">Prof: {{ $curso->teacher->name }}</p>
                    <div class="flex">
                        <ul class="flex text-sm">
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $curso->rating >= 1 ? 'orange' : 'gray' }}_50"></i>
                            </li>
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $curso->rating >= 2 ? 'orange' : 'gray' }}_50"></i>
                            </li>
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $curso->rating >= 3 ? 'orange' : 'gray' }}_50"></i>
                            </li>
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $curso->rating >= 4 ? 'orange' : 'gray' }}_50"></i>
                            </li>
                            <li class="mr-1">
                                <i class="fas fa-star text-{{ $curso->rating >= 5 ? 'orange' : 'gray' }}_50"></i>
                            </li>
                        </ul>
                        <p class="text-sm text-greenLime_500 ml-auto">
                            <i class="fas fa-users"></i>
                            ({{ $curso->students_count }})
                        </p>
                    </div>
                    <a href={{ route('cursos.show', $curso) }}
                        class="block text-center w-full mt-4 bg-greenLime_500 hover: hover:bg-greenLime_400 text-white font-bold py-2 px-4 rounded-full mb-2">
                        <p class="text-greenLime_50 font-bold">Ir al curso </i></p>
                    </a>
                </div>
            </article>
        @endforeach
    </div>
    @endif
    @if ($mostrarTablaCar)
    <div class="max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8 py-8">
        <section class="bg-white rounded-3xl shadow-lg p-6 text-greenLime_500 imagen2">
            <h1 class="text-lg font-semibold mb-6"> CARRO DE COMPRAS</h1>

            @if (Cart::count())
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            {{-- <th class="w-1/12">Imagen</th> --}}
                            <th class="w-5/12">Nombre</th>
                            <th class="w-1/12">Cantidad</th>
                            <th class="w-1/12">Precio</th>
                            <th class="w-1/12">Total</th>
                            <th class="w-1/12">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( Cart::content() as $item)
                            <tr  class="border-b border-greenLime_400">
                                {{-- <td>
                                    <div>
                                        <img class="h-15 w-20 object-cover mr-4"  src="{{"data:image/image;base64," . base64_encode(Storage::url($item->options->image));}}" alt="">
                                    </div>
                                </td> --}}
                                <td>
                                    <div>
                                        <p> {{$item->name}} </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        {{$item->qty}}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        $ {{number_format($item->price,0,",",".")}}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        $ {{number_format($item->price * $item->qty,0,",",".")}}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center cursor-pointer hover:text-red-600"
                                         wire:click="delete('{{$item->rowId}}')"
                                         wire:loading.class="text-red-600 opacity-25"
                                         wire:target="delete('{{$item->rowid}}')">
                                        <i class="fas fa-trash"></i>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="" class="text-sm cursor-pointer hover:underline mt-3 inline-block text-greenLime_500"
                wire:click="destroy">
                    <i class="fas fa-trash"></i>
                    Borrar carrito de compras
                </a>
            @else
                <div class="flex flex-col items-center">
                    <x-cart/>
                    <p class="text-lg text-greenLime_500">TU CARRO DE COMPRAS ESTÁ VACÍO</p>
                    <x-button-enlace href="/" class="mt-4 px-16 ">
                        IR AL INICIO
                    </x-button-enlace>
                </div>
            @endif


        </section>
        @if(Cart::count())
            <div class="bg-white rounded-3xl shadow-lg px-6 py-4 mt-4 imagen2">
                <div class="flex justify-between">
                    <div>
                         <p class="text-gray-700 items-center">
                            <span class="font-bold text-lg">Total: </span>
                            {{Cart::subtotal()}}
                         </p>
                    </div>
                        <x-button-enlace href="{{route('orders.create')}}">
                            Continuar
                        </x-button-enlace>
                    </div>

                <div>
            </div>
        @endif
    </div>


    @endif
    @if ($mostrarTabla)
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-3">
            @foreach ($MisCursos as $curso)
                <article class="bg-greenLime_50 shadow-lg rounded-lg overflow-hidden flex flex-col">
                    <img class="rounded-t-lg h-48 w-full object-cover"
                        src= "{{ 'data:image/image;base64,' . base64_encode(Storage::get($curso->image->url)) }}"
                        alt="">
                    <div class="px-8 py-4 flex-1 flex flex-col">
                        <h1 class="text-xl text-greenLime_500  mb-2 leading-6">{{ Str::limit($curso->nombre, 35) }}
                        </h1>
                        <p class="text-greenLime_500 text-sm mb-2 mt-auto">Prof: {{ $curso->teacher->name }}</p>
                        <div class="flex">
                            <ul class="flex text-sm">
                                <li class="mr-1">
                                    <i class="fas fa-star text-{{ $curso->rating >= 1 ? 'orange' : 'gray' }}_50"></i>
                                </li>
                                <li class="mr-1">
                                    <i class="fas fa-star text-{{ $curso->rating >= 2 ? 'orange' : 'gray' }}_50"></i>
                                </li>
                                <li class="mr-1">
                                    <i class="fas fa-star text-{{ $curso->rating >= 3 ? 'orange' : 'gray' }}_50"></i>
                                </li>
                                <li class="mr-1">
                                    <i class="fas fa-star text-{{ $curso->rating >= 4 ? 'orange' : 'gray' }}_50"></i>
                                </li>
                                <li class="mr-1">
                                    <i class="fas fa-star text-{{ $curso->rating >= 5 ? 'orange' : 'gray' }}_50"></i>
                                </li>
                            </ul>
                            <p class="text-sm text-greenLime_500 ml-auto">
                                <i class="fas fa-users"></i>
                                ({{ $curso->students_count }})
                            </p>
                        </div>
                        <a href={{ route('cursos.show', $curso) }}
                            class="block text-center w-full mt-4 bg-greenLime_500 hover: hover:bg-greenLime_400 text-white font-bold py-2 px-4 rounded-full mb-2">
                            <p class="text-greenLime_50 font-bold">Ir al curso </i></p>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
