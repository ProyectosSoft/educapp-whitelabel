<x-app-layout>
    <section class="max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-5 gap-6 text-white">
            <a href="{{route('orders.index') . "?status=1"}}" class="bg-red-500 bg-opacity-50 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl"> {{$pendiente}} </p>
                <p class="uppercase text-center">Pendientes</p>
                <p class="text-center text-2xl">
                    <i class="fas fa-business-time"></i>
                </p>

            </a>



            <a href="{{route('orders.index') . "?status=2"}}" class="bg-gray-500 bg-opacity-50 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl"> {{$pagada}} </p>
                <p class="uppercase text-center">Pagadas</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-credit-card"></i>
                </p>
            </a>



            <a href="{{route('orders.index') . "?status=3"}}" class="bg-yellow-500 bg-opacity-50 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl"> {{$cancelada}} </p>
                <p class="uppercase text-center">Rechazadas</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-check-circle "></i>
                </p>
            </a>



            <a href="{{route('orders.index') . "?status=4"}}" class="bg-pink-500 bg-opacity-50 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl"> {{$cancelada}} </p>
                <p class="uppercase text-center">Rechazada</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-ban"></i>
                </p>
            </a>



        <a href="{{route('orders.index') . "?status=5"}}" class="bg-green-500 bg-opacity-50 rounded-lg px-12 pt-8 pb-4">
            <p class="text-center text-2xl"> {{$rechazada}} </p>
            <p class="uppercase text-center">Cancelada</p>
            <p class="text-center text-2xl mt-2">
                <i class="fas fa-times-circle"></i>
            </p>
        </a>
    </div>

    <section class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
        <h1 class="text-2xl mb-4">Pedidos recientes</h1>
        <ul>
            @foreach ($orders as $order)
                <li>
                    <a href="{{route('orders.show',$order)}}" class="flex items-center py-2 px-4 hover:bg-gray-100">
                        <span class="w-12 text-center">
                            @switch($order->status)
                                @case(1)
                                        <i class="fas fa-business-time text-red-500 opacity-50"></i>
                                    @break
                                @case(2)
                                        <i class="fas fa-credit-card text-gray-500 opacity-50"></i>
                                    @break
                                @case(3)
                                        <i class="fas fa-check-circle text-yellow-500 opacity-50"></i>
                                    @break
                                @case(4)
                                        <i class="fas fa-ban text-pink-500 opacity-50"></i>
                                    @break
                                @case(5)
                                        <i class="fas fa-times-circle text-green-500 opacity-50"></i>
                                    @break
                                @default

                            @endswitch
                        </span>
                        <span >
                            Orden: {{$order->id}}
                            <br>
                             {{$order->created_at->format('d-m-Y')}}
                        </span>
                        <div class="ml-auto">
                            <span class="font-bold">
                                @switch($order->status)
                                    @case(1)
                                            Pendiente
                                        @break
                                    @case(2)
                                            Pagada
                                        @break
                                    @case(3)
                                           Rechazadas
                                        @break
                                    @case(4)
                                            Rechazadas
                                        @break
                                    @case(5)
                                            canceladas
                                    @break
                                    @default
                                @endswitch
                            </span>
                            <br>
                            <span class="text-sm">
                                ${{number_format($order->total,2)}} USD
                            </span>
                        </div>
                        <span>
                            <i class="fas fa-angle-right ml-4"></i>
                        </span>
                    </a>
                </li>

            @endforeach
        </ul>
    </section>
</x-app-layout>
