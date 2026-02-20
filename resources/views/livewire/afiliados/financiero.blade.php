@php
    use Carbon\Carbon;
@endphp
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
                <div class="ml-2 bg-greenLime_500 rounded-lg px-4 py-2 flex items-center justify-center">
                    <span class="text-white text-sm">{{ $totalSaldo }}</span>
                </div>
                <!-- Segundo div con clases ml-4 (margin-left) y flex-1 (crecimiento flexible) -->
                <div class="ml-2 flex-1 flex items-center flex-col">
                    <!-- Contenido del segundo div -->
                    <h2 class="text-lg font-semibold">
                        Mi Saldo
                    </h2>
                    <!-- Enlace "Ver Mis Cursos" con un ID y evento onclick -->
                    <a href="#" wire:click="toggleMostrarTabla('saldo_favor')"
                        class="ml-2 text-sm text-blue-500 hover:underline">Ver Mi Saldo</a>
                    {{-- <a href="#" id="ocultar-cursos" class="ml-2 text-sm text-blue-500 hover:underline"
                    style="display: none;">Ocultar Mis Cursos</a> --}}
                </div>
            </div>
        </div>
        <div class="bg-white  rounded-lg shadow-lg p-6 flex items-center">
            <div class="flex">
                <!-- Primer div con clases ml-4 (margin-left), rounded-full (bordes redondeados) y flex items-center -->
                <div class="ml-2 bg-greenLime_500 rounded-lg px-4 py-2 flex items-center justify-center">
                    <span class="text-white text-sm">{{ $totalVenta }}</span>
                </div>
                <!-- Segundo div con clases ml-4 (margin-left) y flex-1 (crecimiento flexible) -->
                <div class="ml-2 flex-1 flex items-center flex-col">
                    <!-- Contenido del segundo div -->
                    <h2 class="text-lg font-semibold">
                        Mis Compras
                    </h2>
                    <!-- Enlace "Ver Mis Cursos" con un ID y evento onclick -->
                    <a href="#" wire:click="toggleMostrarTabla('compras')"
                        class="ml-2 text-sm text-blue-500 hover:underline">Ver Mis Compras</a>
                    {{-- <a href="#" id="ocultar-cursos" class="ml-2 text-sm text-blue-500 hover:underline"
                    style="display: none;">Ocultar Mis Cursos</a> --}}
                </div>
            </div>
        </div>
        <div class="bg-white  rounded-lg shadow-lg p-6 flex items-center">
            <div class="flex">
                <!-- Primer div con clases ml-4 (margin-left), rounded-full (bordes redondeados) y flex items-center -->
                <div class="ml-2 bg-greenLime_500 rounded-lg px-4 py-2 flex items-center justify-center">
                    <span class="text-white text-sm">{{ $totalDevolucion }}</span>
                </div>
                <!-- Segundo div con clases ml-4 (margin-left) y flex-1 (crecimiento flexible) -->
                <div class="ml-2 flex-1 flex items-center flex-col">
                    <!-- Contenido del segundo div -->
                    <h2 class="text-lg font-semibold">
                        Mis Devoluciones
                    </h2>
                    <!-- Enlace "Ver Mis Cursos" con un ID y evento onclick -->
                    <a href="#" wire:click="toggleMostrarTabla('devoluciones')"
                        class="ml-2 text-sm text-blue-500 hover:underline">Ver Mis Devoluciones</a>
                    {{-- <a href="#" id="ocultar-cursos" class="ml-2 text-sm text-blue-500 hover:underline"
                    style="display: none;">Ocultar Mis Cursos</a> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <!-- Chips de filtro con estilo activable -->
<div class="flex justify-center mt-4">
    <div class="flex space-x-2">
        @foreach ($filtros as $filtro)
            <div wire:click="toggleFiltro('{{ $filtro }}')"
                class="cursor-pointer transition duration-300 ease-in-out rounded-full px-3 py-1 text-sm text-white
                @if (in_array($filtro, $filtrosSeleccionados)) bg-greenLime_500 @else bg-gray-300 text-gray-800 @endif">
                {{ ucfirst($filtro) }}
            </div>
        @endforeach
        <!-- Filtros seleccionados -->
        @foreach ($filtrosSeleccionados as $filtroSeleccionado)
            <div wire:click="toggleFiltro('{{ $filtroSeleccionado }}')"
                class="cursor-pointer transition duration-300 ease-in-out rounded-full px-3 py-1 text-sm text-white bg-greenLime_500">
                {{ ucfirst($filtroSeleccionado) }}
            </div>
        @endforeach
    </div>
</div> --}}




    <div class="bg-white  rounded-lg shadow-lg p-6 flex items-center">
        <div class="flex space-x-4 mt-10">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-800">Filtros:</h3>
            </div>
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                <input type="date" id="start_date" wire:model="startDate"
                    class="bg-white border border-gray-300 rounded-sm px-4 py-2">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                <input type="date" id="end_date" wire:model="endDate"
                    class="bg-white border border-gray-300 rounded-sm px-4 py-2">
            </div>
            <input type="text" wire:model="filterName" placeholder="Nombre"
                class="bg-white border border-gray-300 rounded-sm px-4 py-2">
            <select wire:model="filterTransaction" class="bg-white border border-gray-300 rounded-sm px-4 py-2">
                <option value=" "> Tipo de Transacción </option>
                <option value="Compra">Compra</option>
                <option value="Venta">Venta</option>
                <!-- Agrega más opciones según tu caso -->
            </select>
            <input type="number" wire:model="filterNumber" placeholder="Número"
                class="bg-white border border-gray-300 rounded-sm px-4 py-2">
        </div>
    </div>
    @if ($transactions)
        <div class="hidden sm:block mt-4">
            <table class="w-full table-fixed">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="w-1/4 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm"
                            wire:click="sortBy('date')">
                            Fecha
                            @if ($sortField === 'date')
                                {!! $sortAsc ? '&#x25B2;' : '&#x25BC;' !!}
                            @endif
                        </th>
                        <th class="w-1/4 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm"
                            wire:click="sortBy('name')">
                            Nombre
                            @if ($sortField === 'name')
                                {!! $sortAsc ? '&#x25B2;' : '&#x25BC;' !!}
                            @endif
                        </th>
                        <th class="w-1/4 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm"
                            wire:click="sortBy('transaction')">
                            Transacción
                            @if ($sortField === 'transaction')
                                {!! $sortAsc ? '&#x25B2;' : '&#x25BC;' !!}
                            @endif
                        </th>
                        <th class="w-1/5 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm"
                            wire:click="sortBy('number')">
                            Número
                            @if ($sortField === 'number')
                                {!! $sortAsc ? '&#x25B2;' : '&#x25BC;' !!}
                            @endif
                        </th>
                        <th class="w-2/4 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm"
                            wire:click="sortBy('curso_name')">
                            Curso
                            @if ($sortField === 'curso_name')
                                {!! $sortAsc ? '&#x25B2;' : '&#x25BC;' !!}
                            @endif
                        </th>
                        <th class="w-2/4 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm"
                            wire:click="sortBy('detail')">
                            Detalle
                            @if ($sortField === 'detail')
                                {!! $sortAsc ? '&#x25B2;' : '&#x25BC;' !!}
                            @endif
                        </th>
                        <th class="w-1/4 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm"
                            wire:click="sortBy('total')">
                            Total
                            @if ($sortField === 'total')
                                {!! $sortAsc ? '&#x25B2;' : '&#x25BC;' !!}
                            @endif
                        </th>
                        <th class="w-1/4 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm">Observación</th>
                        <th class="w-1/4 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm"
                            wire:click="sortBy('status')">
                            Estado
                            @if ($sortField === 'status')
                                {!! $sortAsc ? '&#x25B2;' : '&#x25BC;' !!}
                            @endif
                        </th>
                        {{-- <th class="w-1/4 py-2 px-4 text-left text-gray-600 font-bold uppercase text-sm">Acciones</th> --}}
                    </tr>
                </thead>
                <tbody class="bg-white">

                    @foreach ($transactions as $transaction)
                        <tr>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                {{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 truncate text-sm">{{ $transaction->name }}
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">{{ $transaction->transaction }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                {{ sprintf('%04d', $transaction->number) }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">{{ $transaction->curso_name }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">{{ $transaction->detail }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                {{ number_format($transaction->total, 2) }}$</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">{{ $transaction->observation }}
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                <span
                                    class="text-white py-1 px-2 rounded-full text-xs @switch($transaction->status)
                                    @case(1)
                                        bg-yellow-500
                                    @break

                                    @case(2)
                                        bg-green-500
                                    @break

                                    @case(3)
                                        bg-red-500
                                    @break

                                    @case(4)
                                        bg-orange-500
                                    @break

                                    @case(5)
                                        bg-red-500
                                    @break

                                    @case(6)
                                        bg-green-500
                                    @break

                                    @default
                                        bg-gray-500
                                @endswitch
                            ">
                                    @switch($transaction->status)
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
                                            Reembolso
                                        @break

                                        @case(5)
                                            canceladas
                                        @break

                                        @case(6)
                                            Pagada
                                        @break

                                        @default
                                    @endswitch
                                </span>
                            </td>
                            {{-- <!-- Contenido de cada fila -->
                            <td class="py-4 px-6 border-b border-gray-200 text-sm">
                                <!-- Botones con iconos para aceptar, cancelar y agregar observaciones -->
                                @if ($transaction->transaction == 'Devolucion')
                                    <!-- Botón que llama al método acceptTransaction -->
                                    <button wire:click="acceptTransaction({{ $transaction->id }})" class="mr-2"
                                        title="Aceptar">
                                        <i class="fas fa-check text-green-500"></i>
                                    </button>
                                @endif
                                <!-- Botón que llama al método cancelTransaction -->
                                <button wire:click="cancelTransaction({{ $transaction->id }})" class="mr-2"
                                    title="Cancelar">
                                    <i class="fas fa-times text-red-500"></i>
                                </button>
                                <button wire:click="addObservation({{ $transaction->id }})" title="Observación">
                                    <i class="fas fa-comment text-blue-500"></i>
                                </button>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No hay transacciones disponibles.</p>
    @endif
    <div class="sm:hidden mt-4">
        <!-- Tarjeta visible en pantallas pequeñas -->
        <div class="bg-gray-100 p-2 rounded-lg mb-4">
            <div class="flex justify-between">
                <div class="flex flex-col">
                    <span><strong>Fecha:</strong></span>
                    <span>01/01/1900</span>
                    <span><strong>Nombre:</strong></span>
                    <span>johndoe@gmail.com</span>
                    <span><strong>Tipo Transacción:</strong></span>
                    <span>Venta</span>
                    <span>555-555-555</span>
                    <span><strong>Observación:</strong></span>
                    <span>Creación: REMISIÓN DE VENTA: PPAL-3340
                        (transacción vigente)
                        Cliente: 1551354132. CC: 1020455861</span>
                    <span><strong>Estado:</strong></span>
                    <span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">Activa</span>
                    <span><strong>Acciones:</strong></span>
                    <span><select class="bg-white border border-gray-300 rounded-sm px-4 py-2 w-full">
                            <option value="" selected>Elegir</option>
                            <option value="editar">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </option>
                            <option value="eliminar">
                                <i class="fas fa-trash-alt mr-2"></i>Eliminar
                            </option>
                            <option value="detalles">
                                <i class="fas fa-info-circle mr-2"></i>Detalles
                            </option>
                        </select></span>
                </div>
            </div>
        </div>
        <!-- Tarjeta visible en pantallas pequeñas -->
        <div class="bg-gray-100 p-2 rounded-lg mb-4">
            <div class="flex justify-between">
                <div class="flex flex-col">
                    <span><strong>Fecha:</strong></span>
                    <span>01/01/1900</span>
                    <span><strong>Nombre:</strong></span>
                    <span>johndoe@gmail.com</span>
                    <span><strong>Tipo Transacción:</strong></span>
                    <span>Venta</span>
                    <span>555-555-555</span>
                    <span><strong>Observación:</strong></span>
                    <span>Creación: REMISIÓN DE VENTA: PPAL-3340
                        (transacción vigente)
                        Cliente: 1551354132. CC: 1020455861</span>
                    <span><strong>Estado:</strong></span>
                    <span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">Activa</span>
                    <span><strong>Acciones:</strong></span>
                    <span><select class="bg-white border border-gray-300 rounded-sm px-4 py-2 w-full">
                            <option value="" selected>Elegir</option>
                            <option value="editar">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </option>
                            <option value="eliminar">
                                <i class="fas fa-trash-alt mr-2"></i>Eliminar
                            </option>
                            <option value="detalles">
                                <i class="fas fa-info-circle mr-2"></i>Detalles
                            </option>
                        </select></span>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('transactionAccepted', transactionId => {
                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "¡No podrás revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "¡Sí, aceptarlo!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.emit('confirmAcceptTransaction', transactionId);
                            Swal.fire({
                                title: "¡Aceptado!",
                                text: "La transacción ha sido aceptada.",
                                icon: "success"
                            });
                        }
                    });
                });
            });
        </script>
        {{-- <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('filtroToggle', filtro => {
                    const chip = document.querySelector(`[wire\:click="toggleFiltro('${filtro}')"]`);
                    if (chip) {
                        chip.classList.toggle('bg-greenLime_500');
                        chip.classList.toggle('text-gray-800');
                    }
                });
            });
        </script> --}}
    @endpush


</div>
