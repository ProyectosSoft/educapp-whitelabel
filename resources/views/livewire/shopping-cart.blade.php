<div class="max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8 py-8">
    <section class="bg-white rounded-3xl shadow-lg p-6 text-greenLime_500 imagen2">
        <h1 class="text-lg font-semibold mb-6"> CARRO DE COMPRAS</h1>

        @if ($carlist->count())
            @isset($carlist)
                @if ($carlist->count())
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
                            @foreach ($carlist as $item)
                                <tr class="border-b border-greenLime_400">
                                    {{-- <td>
                            <div>
                                <img class="h-15 w-20 object-cover mr-4"  src="{{"data:image/image;base64," . base64_encode(Storage::url($item->options->image));}}" alt="">
                            </div>
                        </td> --}}
                                    <td>
                                        <div>
                                            <p> {{ $item->nombre }} </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            {{ 1 }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            $ {{ number_format($item->price, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            $ {{ number_format($item->total, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center cursor-pointer hover:text-red-600"
                                            wire:click="delete('{{ $item->id }}')"
                                            wire:loading.class="text-red-600 opacity-25"
                                            wire:target="delete('{{ $item->id }}')">
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
                        <p class="text-lg text-greenLime_500">No se encuentran cursos agregados al carrito</p>
                        <x-button-enlace href="/" class="mt-4 px-16 ">
                            IR AL INICIO
                        </x-button-enlace>
                    </div>
                @endif
            @endisset
        @else
            <div class="flex flex-col items-center">
                <p class="text-lg text-greenLime_500">No se encuentran cursos agregados al carrito</p>
                <x-button-enlace href="/" class="mt-4 px-16 ">
                    IR AL INICIO
                </x-button-enlace>
            </div>
        @endif
    </section>


    @if ($carlist->count())
        <div class="bg-white rounded-3xl shadow-lg px-6 py-4 mt-4 imagen2">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-700 items-center">
                        <span class="font-bold text-lg">Total: </span>
                        $ {{ number_format($carlist->sum('total'), 0, ',', '.') }}
                    </p>
                </div>
                <x-button-enlace href="{{ route('orders.create') }}">
                    Continuar
                </x-button-enlace>
            </div>

            <div>
            </div>
    @endif
</div>
