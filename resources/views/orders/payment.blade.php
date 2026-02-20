<x-app-layout>
    @php

        // SDK de Mercado Pago
        require base_path('vendor/autoload.php');
        // Agrega credenciales
        MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));
        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();
        // Crea un ítem en la preferencia

        foreach ($items as $course) {
            $item = new MercadoPago\Item();
            $item->title = $course->nombre;
            $item->quantity = $course->quantity;
            $item->unit_price = $course->price;

            $courses[] = $item;
        }

        $preference->back_urls = [
            'success' => route('orders.pay', $order),
            // "failure" => route('payment.cancelled'),
            // "pending" => route('payment.pending'),
        ];
        $preference->auto_return = 'approved';
        $preference->items = $courses;
        $preference->save();

    @endphp

    <div class="grid grid-cols-5 gap-6 max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8 py-8">
        <div class="col-span-3">
            <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
                <p class="text-gray-700 uppercase"><span class="font-semibold">Número de Orden:</span>
                    orden-{{ $order->id }} </p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="grid grid-cols-2 gap-6 text-gray-700">
                    <div>
                        <p class="text-lg font-semibold uppercase">Datos de Contacto</P>

                        <p class="text-sm">Nombre: {{ $order->contact }} </p>
                        <p class="text-sm">Telefono: {{ $order->phone }} </p>
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
                                    <h1 class="font-bold"> {{ $item->nombre }} </h1>
                                </td>
                                <td class="text-center">
                                    <p class="font-semibold"> ${{ number_format($item->price, 0, ',', '.') }}
                                        {{ $item->currency }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="font-semibold"> {{ $item->quantity }} </p>
                                </td>
                                <td class="text-center">
                                    {{-- <p class="font-semibold"> ${{number_format($item->price * $item->quantity , 0, ',', '.')}} {{$item->currency}}</p> --}}
                                    <p class="font-semibold"> ${{ number_format($item->total, 0, ',', '.') }}
                                        {{ $item->currency }}</p>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-span-2">
            {{-- <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center">
                    <img class="h-12" src="{{asset('img/logo_pago.png')}}" alt="">
                    <div class="text-gray-700">
                        <p class="text-lg font-semibold" >
                            Descuento: ${{number_format($order->subtotal,2)}} COP
                        </p>
                        <p class="text-lg font-semibold" >
                            Subtotal: ${{number_format( $order->total-0,2)}} COP
                       </p>
                       <p class="text-lg font-semibold" >
                            Pago: ${{number_format($order->total,2)}} COP
                       </p>
                       <div class="cho-container">
                        <!-- Aquí se mostrará el botón de pago de Mercado Pago -->
                       </div>
                    </div>
                </div>
            </div> --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center">
                    <img class="h-12" src="{{ asset('img/logo_pago.png') }}" alt="Logo de Pago">
                    <div class="text-gray-700">
                        <p class="text-lg font-semibold">
                            Descuento: ${{ number_format(0, 0, ',', '.') }} COP
                        </p>
                        <p class="text-lg font-semibold">
                            Subtotal: ${{ number_format($order->total, 0, ',', '.') }} COP
                        </p>
                        <p class="text-lg font-semibold">
                            Saldo a Favor: ${{ number_format($order->Saldo_Favor, 0, ',', '.') }} COP
                        </p>
                        <p class="text-lg font-semibold">
                            Pago: ${{ number_format($order->total, 0, ',', '.') }} COP
                        </p>
                        @if ($order->total == 0)
                            <form action="{{ route('orders.zeroPayment', $order) }}" method="post">
                                @csrf
                                <button
                                    class="font-bold py-2 px-4 w-full rounded-full bg-greenLime_500 text-greenLime_50 hover:bg-greenLime_400 mt-4 block text-center">
                                    Pagar</button>
                            </form>
                        @else
                            <div class="cho-container" id="payment-button">
                                <!-- Aquí se mostrará el botón de pago de Mercado Pago -->
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        // Agrega credenciales de SDK
        const mp = new MercadoPago("{{ config('services.mercadopago.key') }}", {
            locale: 'es-AR'
        });
        // Inicializa el checkout
        mp.checkout({
            preference: {
                id: '{{ $preference->id }}'
            },
            render: {
                container: '.cho-container', // Indica dónde se mostrará el botón de pago
                label: 'Pagar', // Cambia el texto del botón de pago (opcional)
            }
        });
    </script>
</x-app-layout>
