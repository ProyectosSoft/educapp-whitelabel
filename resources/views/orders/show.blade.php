<x-app-layout>
    <div class="max-w-5xl mx-auto  px-4 sm:px-6 lg:px-8 py-12">

            <div class="bg-white rounded-lg shadow-lg px-12 py-8 mb-6">
                <div class="flex items-center ">
                    <div class="{{($order->status==2) ? 'bg-blue-400' : 'bg-gray-400'}}   rounded-full h-12 w-12 bg-blue-400 flex items-center justify-center">
                        <i class="fas fa-check text-white text-xl"></i>
                    </div>
                    <div class="ml-6">
                        <p> Recibido </p>
                    </div>
                </div>

            </div>
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 flex items-center">
            <p class="text-gray-700 uppercase"><span class="font-semibold">Número de Orden:</span>
                Orden-{{$order->id}} </p>
                @if ($order->status==1)
                    <x-button-enlace class="ml-auto" href="{{route('orders.payment', $order)}}">
                        Ir a Pagar
                    </x-button-enlace>
                @endif
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-2 gap-6 text-gray-700">
                <div>
                    <p class="text-lg font-semibold uppercase">Datos de Contacto</P>

                    <p class="text-sm">Nombre: {{$order->contact}} </p>
                    <p class="text-sm">Telefono: {{$order->phone}} </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg text-gray-700 p-6 mb-6">
            <p class="text-xl font-semibold mb-4">Resumen</p>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        {{-- <th></th> --}}
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($items as $item)
                        <tr>
                            {{-- <td class="flex">
                                <div>
                                    <img class="w-20 h-15 object-cover"
                                    src="{{$item->options->image}}" alt="">
                                </div>
                            </td> --}}
                            <td class="text-center">
                                <h1 class="font-bold" > {{$item->nombre}} </h1>
                            </td>
                            <td class="text-center">
                                <p class="font-semibold"> ${{number_format($item->price,2)}} {{$item->currency}}</p>
                            </td>
                            <td  class="text-center">
                                <p class="font-semibold"> {{$item->quantity}} </p>
                            </td>
                            <td class="text-center">
                                <p class="font-semibold"> ${{number_format($item->price * $item->quantity,2)}} {{$item->currency}}</p>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
