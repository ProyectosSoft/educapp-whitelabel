@php
    use Carbon\Carbon;
@endphp
<div>
    {{-- Main Container --}}
    <div class="space-y-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-[#335A92] p-8 rounded-[2rem] shadow-xl relative overflow-hidden">
            {{-- Abstract bg decoration --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-1 bg-white/20 rounded-full">
                    <img class="h-16 w-16 rounded-full object-cover border-4 border-white shadow-md" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
                <div class="ml-5">
                    <p class="text-xs text-[#ECBD2D] font-bold uppercase tracking-wider mb-1">Panel Financiero</p>
                    <h2 class="text-3xl font-bold text-white tracking-tight">
                        Hola, {{ Auth::user()->name }}
                    </h2>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="relative z-10 w-full md:w-auto">
                @csrf
                <button type="submit" class="w-full md:w-auto px-6 py-3 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all text-sm font-bold backdrop-blur-sm border border-white/20 flex items-center justify-center shadow-lg">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                </button>
            </form>
        </div>

        {{-- Metrics Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Saldo Card --}}
            <div class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-8 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div class="absolute right-0 top-0 h-full w-1.5 bg-green-500"></div>
                <div class="flex items-center justify-between mb-6">
                    <div class="p-4 bg-green-50 rounded-2xl text-green-600 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-wallet text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-bold text-gray-800 mb-1 tracked-tight">{{ $totalSaldo }}</h3>
                <p class="text-sm text-gray-400 font-bold uppercase tracking-wider">Saldo Disponible</p>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="#" wire:click.prevent="toggleMostrarTabla('saldo_favor')" class="text-sm font-bold text-green-600 hover:text-green-700 flex items-center group-hover:translate-x-1 transition-transform">
                        Ver detalles <i class="fas fa-arrow-right ml-2 text-xs bg-green-100 p-1 rounded-full"></i>
                    </a>
                </div>
            </div>

            {{-- Ventas Card --}}
            <div class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-8 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div class="absolute right-0 top-0 h-full w-1.5 bg-[#335A92]"></div>
                <div class="flex items-center justify-between mb-6">
                    <div class="p-4 bg-blue-50 rounded-2xl text-[#335A92] shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-bold text-gray-800 mb-1 tracked-tight">{{ $totalVenta }}</h3>
                <p class="text-sm text-gray-400 font-bold uppercase tracking-wider">Ventas Totales</p>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="#" wire:click.prevent="toggleMostrarTabla('compras')" class="text-sm font-bold text-[#335A92] hover:text-[#284672] flex items-center group-hover:translate-x-1 transition-transform">
                        Ver historial <i class="fas fa-arrow-right ml-2 text-xs bg-blue-100 p-1 rounded-full"></i>
                    </a>
                </div>
            </div>

            {{-- Devoluciones Card --}}
            <div class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-8 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div class="absolute right-0 top-0 h-full w-1.5 bg-red-500"></div>
                <div class="flex items-center justify-between mb-6">
                    <div class="p-4 bg-red-50 rounded-2xl text-red-500 shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-undo text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-bold text-gray-800 mb-1 tracked-tight">{{ $totalDevolucion }}</h3>
                <p class="text-sm text-gray-400 font-bold uppercase tracking-wider">Devoluciones</p>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="#" wire:click.prevent="toggleMostrarTabla('devoluciones')" class="text-sm font-bold text-red-500 hover:text-red-700 flex items-center group-hover:translate-x-1 transition-transform">
                        Ver casos <i class="fas fa-arrow-right ml-2 text-xs bg-red-100 p-1 rounded-full"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Filters Section --}}
        <div x-data="{ open: false }" class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-8">
            <div class="flex justify-between items-center cursor-pointer select-none" @click="open = !open">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <div class="bg-[#335A92]/10 p-2.5 rounded-xl mr-3 text-[#335A92]">
                         <i class="fas fa-filter"></i>
                    </div>
                    Filtros Avanzados
                </h3>
                <button class="bg-gray-100 text-gray-600 py-2.5 px-5 rounded-xl text-xs font-bold hover:bg-gray-200 transition uppercase tracking-wide flex items-center">
                    <span x-show="!open">Mostrar <i class="fas fa-chevron-down ml-2"></i></span>
                    <span x-show="open" style="display: none;">Ocultar <i class="fas fa-chevron-up ml-2"></i></span>
                </button>
            </div>

            <div x-show="open" x-collapse style="display: none;" class="mt-8 border-t border-gray-100 pt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Date Inputs --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#335A92] uppercase ml-1">Fecha Inicio</label>
                        <input type="date" wire:model="startDate" wire:change="toggleMostrarTabla('Rango_Fecha')" 
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-[#335A92] focus:border-[#335A92] transition-shadow">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#335A92] uppercase ml-1">Fecha Fin</label>
                        <input type="date" wire:model="endDate" 
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-[#335A92] focus:border-[#335A92] transition-shadow">
                    </div>
                    
                    {{-- Text Inputs --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#335A92] uppercase ml-1">Alumno</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                            <input type="text" wire:model="filterName" placeholder="Buscar por nombre..."
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-[#335A92] focus:border-[#335A92] transition-shadow placeholder-gray-400">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#335A92] uppercase ml-1">Instructor</label>
                        <div class="relative">
                            <i class="fas fa-chalkboard-teacher absolute left-4 top-3.5 text-gray-400"></i>
                             <input type="text" wire:model="filterNameIns" placeholder="Buscar instructor..."
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-[#335A92] focus:border-[#335A92] transition-shadow placeholder-gray-400">
                        </div>
                    </div>

                    {{-- Select Inputs --}}
                    <div class="space-y-2">
                         <label class="text-xs font-bold text-[#335A92] uppercase ml-1">Tipo Transacción</label>
                        <select wire:model="filterTransaction" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-[#335A92] focus:border-[#335A92] transition-shadow appearance-none">
                            <option value=" ">Todos</option>
                            <option value="Devolucion">Devolución</option>
                            <option value="Saldo a Favor">Saldo a Favor</option>
                            <option value="Venta">Venta</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                         <label class="text-xs font-bold text-[#335A92] uppercase ml-1">Estado</label>
                        <select wire:model="filterStatus" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-[#335A92] focus:border-[#335A92] transition-shadow appearance-none">
                            <option value=" ">Todos</option>
                            <option value="1">Pendiente</option>
                            <option value="6">Pagada</option>
                            <option value="4">Reembolso</option>
                            <option value="5">Anulada</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
                    <button wire:click="resetFiltersAndTransactions" class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all text-sm flex items-center">
                        <i class="fas fa-undo mr-2 text-xs"></i> Restablecer
                    </button>
                    <button wire:click="applyFilters" class="px-8 py-3 bg-[#335A92] text-white font-bold rounded-xl hover:bg-[#284672] transition-all text-sm shadow-lg shadow-blue-900/20 flex items-center transform hover:-translate-y-0.5">
                        <i class="fas fa-filter mr-2 text-xs"></i> Aplicar Filtros
                    </button>
                </div>
            </div>
        </div>

        {{-- Transactions Content --}}
        @if ($transactions)
             <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/50">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Resultados de Búsqueda</h3>
                        <p class="text-sm text-gray-500 font-medium mt-1">{{ count($transactions) }} registros encontrados</p>
                    </div>
                    
                    @if(count($selectedTransactions) > 0)
                        <button wire:click="pagarSeleccionados" class="px-6 py-3 bg-green-500 text-white text-sm font-bold rounded-xl shadow-lg hover:bg-green-600 transition flex items-center animate-pulse transform hover:scale-105">
                            <i class="fas fa-dollar-sign mr-2"></i> Pagar Seleccionados ({{ count($selectedTransactions) }})
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                         <thead class="text-xs text-white uppercase bg-[#335A92] border-b border-[#335A92]">
                            <tr>
                                <th class="px-6 py-5 w-10 text-center">
                                    <input type="checkbox" wire:model="selectAll" class="rounded border-gray-300 text-[#ECBD2D] focus:ring-[#ECBD2D]">
                                </th>
                                <th class="px-6 py-5 cursor-pointer hover:text-gray-200 transition-colors" wire:click="sortBy('date')">Fecha <i class="fas fa-sort ml-1 opacity-50"></i></th>
                                <th class="px-6 py-5 cursor-pointer hover:text-gray-200 transition-colors" wire:click="sortBy('name')">Alumno <i class="fas fa-sort ml-1 opacity-50"></i></th>
                                <th class="px-6 py-5 cursor-pointer hover:text-gray-200 transition-colors" wire:click="sortBy('transaction')">Tipo <i class="fas fa-sort ml-1 opacity-50"></i></th>
                                <th class="px-6 py-5 cursor-pointer hover:text-gray-200 transition-colors" wire:click="sortBy('total')">Total <i class="fas fa-sort ml-1 opacity-50"></i></th>
                                <th class="px-6 py-5 text-center">Estado</th>
                                <th class="px-6 py-5 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-[#335A92]/5 transition duration-150 {{ $this->isSelected($transaction) ? 'bg-blue-50' : '' }}">
                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox" wire:model="selectedTransactions" value="{{ json_encode($transaction) }}"
                                               class="rounded border-gray-300 text-[#335A92] focus:ring-[#335A92]/50 w-5 h-5 cursor-pointer"
                                               @if (!($transaction->transaction == 'Venta' && $transaction->status == 6 && $transaction->auxstatus == 1)) disabled @endif>
                                    </td>
                                    <td class="px-6 py-5 font-bold text-gray-700">
                                        {{ \Carbon\Carbon::parse($transaction->date)->format('d M, Y') }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#335A92]">{{ $transaction->name }}</span>
                                            <span class="text-xs text-gray-400 font-medium mt-0.5">Instr: {{ Str::limit($transaction->instructor_name, 20) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border
                                            @if($transaction->transaction == 'Venta') bg-green-100 text-green-700 border-green-200
                                            @elseif($transaction->transaction == 'Devolucion') bg-red-100 text-red-700 border-red-200
                                            @else bg-blue-100 text-blue-700 border-blue-200 @endif">
                                            {{ $transaction->transaction }}
                                        </span>
                                        <div class="text-[10px] text-gray-400 mt-1.5 font-mono">ID: #{{ sprintf('%04d', $transaction->number) }}</div>
                                    </td>
                                    <td class="px-6 py-5 font-bold text-gray-800 text-base">
                                        ${{ number_format($transaction->total, 2) }}
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                         @php
                                            $statusColors = [
                                                1 => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                2 => 'bg-green-100 text-green-800 border-green-200',
                                                3 => 'bg-blue-100 text-blue-800 border-blue-200',
                                                4 => 'bg-orange-100 text-orange-800 border-orange-200',
                                                5 => 'bg-red-100 text-red-800 border-red-200',
                                                6 => 'bg-green-100 text-green-800 border-green-200',
                                            ];
                                            $statusNames = [
                                                1 => 'Pendiente', 2 => 'Recibido', 3 => 'Enviado',
                                                4 => 'Reembolso', 5 => 'Anulada', 6 => 'Pagada'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-md text-xs font-bold border {{ $statusColors[$transaction->status] ?? 'bg-gray-100' }}">
                                            {{ $statusNames[$transaction->status] ?? 'Desc.' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center space-x-2">
                                            @if ($transaction->transaction == 'Devolucion' && $transaction->status == 1)
                                                <button wire:click="acceptTransaction({{ $transaction->id }})" class="w-9 h-9 rounded-lg bg-green-50 text-green-600 border border-green-200 hover:bg-green-600 hover:text-white transition shadow-sm flex items-center justify-center" title="Aceptar">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif

                                            @php
                                                $routes = [
                                                    'Venta' => 'documentosfinancieros.factura_venta',
                                                    'Devolucion' => 'documentosfinancieros.devolucion',
                                                    'Saldo a Favor' => 'documentosfinancieros.saldo_favor',
                                                    'Comprobante Pago' => 'admin.dashboard.comprobante_de_pago'
                                                ];
                                                $route = $routes[$transaction->transaction] ?? null;
                                            @endphp

                                            @if($route)
                                                <a href="{{ route($route, ['transactionNumber' => $transaction->number]) }}" 
                                                   class="w-9 h-9 rounded-lg bg-gray-50 text-gray-400 border border-gray-200 hover:bg-[#335A92] hover:text-white hover:border-[#335A92] transition shadow-sm flex items-center justify-center transform hover:-translate-y-0.5" 
                                                   title="Ver Documento">
                                                    <i class="fas fa-file-invoice text-sm"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-16 text-center">
                 <div class="bg-gray-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6 border border-gray-100">
                    <i class="fas fa-comments-dollar text-5xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">No se encontraron transacciones</h3>
                <p class="text-gray-500 max-w-sm mx-auto">Intenta ajustar los filtros de fecha o búsqueda para encontrar lo que necesitas.</p>
            </div>
        @endif
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('transactionAccepted', transactionId => {
                    Swal.fire({
                        title: "¿Confirmar Aceptación?",
                        text: "Esta acción procesará la transacción seleccionada.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#335A92",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, aceptar",
                        cancelButtonText: "Cancelar",
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'bg-[#335A92] text-white font-bold py-2.5 px-6 rounded-xl shadow-md',
                            cancelButton: 'bg-gray-200 text-gray-800 font-bold py-2.5 px-6 rounded-xl shadow-sm'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.emit('confirmAcceptTransaction', transactionId);
                        }
                    });
                });

                @this.on('alert', event => {
                    Swal.fire({
                        icon: event.type,
                        title: event.type === 'success' ? '¡Operación Exitosa!' : '¡Error!',
                        text: event.message,
                        confirmButtonColor: "#335A92",
                         customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'bg-[#335A92] text-white font-bold py-2.5 px-6 rounded-xl shadow-md'
                        },
                        buttonsStyling: false
                    });
                });
            });
        </script>
    @endpush
</div>
