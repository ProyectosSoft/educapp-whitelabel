@php
    use Carbon\Carbon;
@endphp
<div>
    {{-- Main Container --}}
    <div class="space-y-6">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-primary-900 p-6 rounded-3xl shadow-xl relative overflow-hidden">
            {{-- Decorative Blur --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary-400 opacity-20 filter blur-3xl"></div>
            
            <div class="flex items-center relative z-10">
                <img class="h-14 w-14 rounded-full object-cover border-2 border-secondary shadow-lg shadow-black/30" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                <div class="ml-4">
                    <p class="text-xs text-secondary font-bold uppercase tracking-wider">Panel Financiero</p>
                    <h2 class="text-xl md:text-2xl font-bold text-white">
                        Bienvenido, {{ Auth::user()->name }}
                    </h2>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="relative z-10">
                @csrf
                <button type="submit" class="px-4 py-2 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all text-sm font-medium backdrop-blur-sm border border-white/10 flex items-center">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                </button>
            </form>
        </div>

        {{-- Metrics Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Saldo Card --}}
            <div wire:click="toggleMostrarTabla('saldo_favor')" class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden group hover:shadow-xl transition-all duration-300 cursor-pointer">
                <div class="absolute right-0 top-0 h-full w-2 bg-gradient-to-b from-green-400 to-green-600"></div>
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-2xl text-green-600 dark:text-green-400">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 dark:text-white mb-1">{{ $totalSaldo }}</h3>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Mi Saldo</p>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <span class="text-sm font-bold text-green-600 hover:text-green-700 flex items-center group-hover:translate-x-1 transition-transform">
                        Ver detalles <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </span>
                </div>
            </div>

            {{-- Ventas Card --}}
            <div wire:click="toggleMostrarTabla('compras')" class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden group hover:shadow-xl transition-all duration-300 cursor-pointer">
                <div class="absolute right-0 top-0 h-full w-2 bg-gradient-to-b from-secondary to-teal-400"></div>
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-teal-50 dark:bg-teal-900/20 rounded-2xl text-secondary-600 dark:text-secondary-400">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 dark:text-white mb-1">{{ $totalVenta }}</h3>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Mis Ventas</p>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <span class="text-sm font-bold text-secondary-600 hover:text-secondary-700 flex items-center group-hover:translate-x-1 transition-transform">
                        Ver historial <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </span>
                </div>
            </div>

            {{-- Devoluciones Card --}}
            <div wire:click="toggleMostrarTabla('devoluciones')" class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden group hover:shadow-xl transition-all duration-300 cursor-pointer">
                <div class="absolute right-0 top-0 h-full w-2 bg-gradient-to-b from-red-400 to-red-600"></div>
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-2xl text-red-600 dark:text-red-400">
                        <i class="fas fa-undo text-xl"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 dark:text-white mb-1">{{ $totalDevolucion }}</h3>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Devoluciones</p>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <span class="text-sm font-bold text-red-600 hover:text-red-700 flex items-center group-hover:translate-x-1 transition-transform">
                        Ver devoluciones <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </span>
                </div>
            </div>
        </div>

        {{-- Filters Section --}}
        <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-filter text-primary-600 mr-2 bg-primary-50 p-2 rounded-lg"></i>
                    Filtros Avanzados
                </h3>
                <button class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 py-2 px-4 rounded-xl text-sm font-bold hover:bg-gray-200 transition">
                    <span x-show="!open"><i class="fas fa-chevron-down mr-2"></i> Mostrar</span>
                    <span x-show="open"><i class="fas fa-chevron-up mr-2"></i> Ocultar</span>
                </button>
            </div>

            <div x-show="open" x-collapse class="mt-6 border-t border-gray-100 dark:border-gray-700 pt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Date Inputs --}}
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase">Fecha Inicio</label>
                        <input type="date" wire:model="startDate" wire:change="toggleMostrarTabla('Rango_Fecha')" 
                               class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase">Fecha Fin</label>
                        <input type="date" wire:model="endDate" 
                               class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                    </div>
                    
                    {{-- Text Inputs --}}
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase">Alumno</label>
                        <input type="text" wire:model="filterName" placeholder="Nombre..."
                               class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase">Instructor</label>
                        <input type="text" wire:model="filterNameIns" placeholder="Instructor..."
                               class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                    </div>

                    {{-- Select Inputs --}}
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase">Transacción</label>
                        <select wire:model="filterTransaction" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                            <option value="">Todas</option>
                            <option value="Devolucion">Devolución</option>
                            <option value="Saldo a Favor">Saldo a Favor</option>
                            <option value="Venta">Venta</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase">Estado</label>
                        <select wire:model="filterStatus" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                            <option value="">Todos</option>
                            <option value="1">Pendiente</option>
                            <option value="6">Pagada</option>
                            <option value="4">Reembolso</option>
                            <option value="5">Anulada</option>
                        </select>
                    </div>
                     <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase">Número</label>
                        <input type="number" wire:model="filterNumber" placeholder="No. Ref..."
                               class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button wire:click="resetFiltersAndTransactions" class="px-4 py-2 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all text-sm flex items-center">
                        <i class="fas fa-undo mr-2 text-xs"></i> Restablecer
                    </button>
                    <button wire:click="applyFilters" class="px-6 py-2 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all text-sm shadow-lg shadow-primary-900/20 flex items-center">
                        <i class="fas fa-search mr-2 text-xs"></i> Buscar
                    </button>
                </div>
            </div>
        </div>

        {{-- Transactions Table --}}
        @if ($transactions && $transactions->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4 cursor-pointer hover:text-primary-600" wire:click="sortBy('date')">Fecha</th>
                                <th class="px-6 py-4 cursor-pointer hover:text-primary-600" wire:click="sortBy('name')">Alumno</th>
                                <th class="px-6 py-4 cursor-pointer hover:text-primary-600" wire:click="sortBy('instructor_name')">Instructor</th>
                                <th class="px-6 py-4 cursor-pointer hover:text-primary-600" wire:click="sortBy('transaction')">Tipo</th>
                                <th class="px-6 py-4 cursor-pointer hover:text-primary-600" wire:click="sortBy('total')">Total</th>
                                <th class="px-6 py-4 text-center">Estado</th>
                                <th class="px-6 py-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $transaction->name }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $transaction->instructor_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-md text-xs font-bold
                                            @if($transaction->transaction == 'Venta') bg-green-100 text-green-700
                                            @elseif($transaction->transaction == 'Devolucion') bg-red-100 text-red-700
                                            @else bg-blue-100 text-blue-700 @endif">
                                            {{ $transaction->transaction }}
                                        </span>
                                        <div class="text-xs text-gray-400 mt-1 font-mono">#{{ sprintf('%04d', $transaction->number) }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800 dark:text-white">
                                        ${{ number_format($transaction->total, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                         @php
                                            $statusColors = [
                                                1 => 'bg-yellow-100 text-yellow-800', 2 => 'bg-green-100 text-green-800',
                                                3 => 'bg-blue-100 text-blue-800', 4 => 'bg-orange-100 text-orange-800',
                                                5 => 'bg-red-100 text-red-800', 6 => 'bg-green-100 text-green-800',
                                            ];
                                            $statusNames = [
                                                1 => 'Pendiente', 2 => 'Recibido', 3 => 'Enviado',
                                                4 => 'Reembolso', 5 => 'Anulada', 6 => 'Pagada'
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $statusColors[$transaction->status] ?? 'bg-gray-100' }}">
                                            {{ $statusNames[$transaction->status] ?? 'Desc.' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            @if ($transaction->transaction == 'Devolucion' && $transaction->status == 1)
                                                <button wire:click="acceptTransaction({{ $transaction->id }})" class="w-8 h-8 rounded-full bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition shadow-sm flex items-center justify-center" title="Aceptar">
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
                                                   class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 hover:bg-primary-600 hover:text-white transition shadow-sm flex items-center justify-center" 
                                                   title="Ver Documento">
                                                    <i class="fas fa-file-alt"></i>
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
            <div class="bg-gray-50 dark:bg-gray-800 rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search-dollar text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">No se encontraron transacciones</h3>
                <p class="text-gray-500">Intenta ajustar los filtros de búsqueda.</p>
            </div>
        @endif
    </div>
</div>
