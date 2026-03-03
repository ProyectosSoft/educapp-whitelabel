@php
    use Carbon\Carbon;
@endphp
<div>
    {{-- Main Container --}}
    <div class="space-y-8">
        
        {{-- Hero Header Section --}}
        <div class="bg-white rounded-[2rem] shadow-lg shadow-gray-200/50 ring-1 ring-gray-100 p-8 md:p-12 relative overflow-hidden group">
            <!-- Decorative background elements -->
            <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3 pointer-events-none transition-transform duration-700 group-hover:scale-110"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary-50/50 rounded-full blur-3xl transform -translate-x-1/3 translate-y-1/3 pointer-events-none transition-transform duration-700 group-hover:scale-105"></div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-8 relative z-10 text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="relative flex-shrink-0">
                        <div class="absolute inset-0 bg-primary-900 rounded-full blur-md opacity-20 transform translate-y-2"></div>
                        <img class="h-24 w-24 rounded-full border-4 border-white shadow-sm relative z-10 object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-primary-900 mb-2 tracking-tight">
                            Hola, <span class="text-secondary">{{ Auth::user()->name }}</span>
                        </h2>
                        <div class="flex items-center justify-center md:justify-start gap-3 mt-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary-50 text-primary-800 text-xs font-bold ring-1 ring-primary-100 shadow-sm">
                                <i class="fas fa-chart-pie text-secondary"></i> Panel Financiero
                            </span>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="inline-block mt-4 md:mt-0">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-600 hover:bg-red-50 px-4 py-2 rounded-xl transition-colors flex items-center gap-1.5 ring-1 ring-transparent hover:ring-red-100">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        {{-- Metrics Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Saldo Card --}}
            <div wire:click="toggleMostrarTabla('saldo_favor')" class="flex flex-col bg-white rounded-[2rem] p-6 md:p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:shadow-lg hover:shadow-green-500/10 hover:-translate-y-1 cursor-pointer group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                    <div class="px-3 py-1 bg-gray-50 rounded-lg ring-1 ring-gray-100">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Global</span>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-primary-900 mb-1">{{ $totalSaldo }}</h3>
                <p class="text-[11px] uppercase font-bold text-gray-500 tracking-wider">Mi Saldo a Favor</p>
                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between text-xs font-bold text-green-600">
                    <span>Ver detalles</span>
                    <i class="fas fa-chevron-right transform group-hover:translate-x-1 transition-transform"></i>
                </div>
            </div>

            {{-- Ventas (Compras) Card --}}
            <div wire:click="toggleMostrarTabla('compras')" class="flex flex-col bg-white rounded-[2rem] p-6 md:p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:shadow-lg hover:shadow-secondary/10 hover:-translate-y-1 cursor-pointer group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-secondary-50 text-secondary-700 flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-shopping-bag text-xl"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-primary-900 mb-1">{{ $totalVenta }}</h3>
                <p class="text-[11px] uppercase font-bold text-gray-500 tracking-wider">Mis Compras</p>
                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between text-xs font-bold text-secondary">
                    <span>Ver historial</span>
                    <i class="fas fa-chevron-right transform group-hover:translate-x-1 transition-transform"></i>
                </div>
            </div>

            {{-- Devoluciones Card --}}
            <div wire:click="toggleMostrarTabla('devoluciones')" class="flex flex-col bg-white rounded-[2rem] p-6 md:p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:shadow-lg hover:shadow-red-500/10 hover:-translate-y-1 cursor-pointer group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-undo-alt text-xl"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-primary-900 mb-1">{{ $totalDevolucion }}</h3>
                <p class="text-[11px] uppercase font-bold text-gray-500 tracking-wider">Solicitudes de Reembolso</p>
                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between text-xs font-bold text-red-600">
                    <span>Ver devoluciones</span>
                    <i class="fas fa-chevron-right transform group-hover:translate-x-1 transition-transform"></i>
                </div>
            </div>
        </div>

        {{-- Filters Section --}}
        <div x-data="{ open: false }" class="bg-white rounded-[2rem] shadow-sm ring-1 ring-gray-100 p-6 md:p-8">
            <div class="flex justify-between items-center cursor-pointer group" @click="open = !open">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-primary-50 text-primary-800 flex items-center justify-center mr-4 group-hover:bg-primary-900 group-hover:text-white transition-colors">
                        <i class="fas fa-sliders-h text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-primary-900 leading-tight">Búsqueda Avanzada</h3>
                        <p class="text-xs font-medium text-gray-500">Filtra tus transacciones por fecha o tipo</p>
                    </div>
                </div>
                <button class="bg-gray-50 text-gray-600 ring-1 ring-gray-200 py-2 px-4 rounded-xl text-xs font-bold hover:bg-gray-100 hover:text-primary-900 transition-all duration-300 shadow-sm flex items-center">
                    <span x-show="!open" class="flex items-center"><i class="fas fa-chevron-down mr-2"></i> Expandir</span>
                    <span x-show="open" class="flex items-center"><i class="fas fa-chevron-up mr-2"></i> Ocultar</span>
                </button>
            </div>

            <div x-show="open" x-collapse style="display: none;">
                <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5">
                    {{-- Date Inputs --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider ml-1">Fecha Inicio</label>
                        <input type="date" wire:model="startDate" wire:change="toggleMostrarTabla('Rango_Fecha')" 
                               class="w-full bg-gray-50 ring-1 ring-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-primary-500/30 transition-all outline-none hover:bg-white">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider ml-1">Fecha Fin</label>
                        <input type="date" wire:model="endDate" 
                               class="w-full bg-gray-50 ring-1 ring-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-primary-500/30 transition-all outline-none hover:bg-white">
                    </div>
                    
                    {{-- Text Inputs --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider ml-1">Instructor</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-chalkboard-teacher text-gray-400 text-xs"></i>
                            </div>
                            <input type="text" wire:model="filterNameIns" placeholder="Buscar instructor..."
                                   class="w-full bg-gray-50 ring-1 ring-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-primary-500/30 transition-all outline-none hover:bg-white">
                        </div>
                    </div>

                    {{-- Select Inputs --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider ml-1">Transacción</label>
                        <select wire:model="filterTransaction" class="w-full bg-gray-50 ring-1 ring-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-primary-500/30 transition-all outline-none hover:bg-white appearance-none cursor-pointer">
                            <option value="">Todas</option>
                            <option value="Devolucion">Devolución</option>
                            <option value="Saldo a Favor">Saldo a Favor</option>
                            <option value="Venta">Venta</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider ml-1">Estado</label>
                        <select wire:model="filterStatus" class="w-full bg-gray-50 ring-1 ring-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-primary-500/30 transition-all outline-none hover:bg-white appearance-none cursor-pointer">
                            <option value="">Todos</option>
                            <option value="1">Pendiente</option>
                            <option value="6">Pagada</option>
                            <option value="4">Reembolso</option>
                            <option value="5">Anulada</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end items-center gap-3 mt-6">
                    <button wire:click="resetFiltersAndTransactions" class="w-full sm:w-auto px-5 py-2.5 bg-white text-gray-500 font-bold rounded-xl hover:bg-gray-50 ring-1 ring-gray-200 transition-all text-xs flex items-center justify-center shadow-sm">
                        <i class="fas fa-sync-alt mr-2"></i> Limpiar Filtros
                    </button>
                    <button wire:click="applyFilters" class="w-full sm:w-auto px-6 py-2.5 bg-secondary text-white font-bold rounded-xl hover:bg-secondary-600 transition-all text-xs shadow-sm shadow-secondary/20 flex items-center justify-center transform hover:-translate-y-0.5">
                        <i class="fas fa-search mr-2"></i> Buscar
                    </button>
                </div>
            </div>
        </div>

        {{-- Transactions Table --}}
        @if ($transactions && $transactions->count() > 0)
            <div class="bg-white rounded-[2rem] shadow-sm ring-1 ring-gray-100 overflow-hidden">
                <div class="p-6 md:p-8 border-b border-gray-100 flex justify-between items-center bg-white relative z-10">
                    <h3 class="text-xl font-extrabold text-primary-900 tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-50 text-primary-800 rounded-xl flex items-center justify-center">
                            <i class="fas fa-history"></i>
                        </div>
                        Historial de Movimientos
                    </h3>
                    <span class="px-3 py-1.5 bg-gray-50 ring-1 ring-gray-100 rounded-lg text-xs font-bold text-gray-500">
                        {{ $transactions->count() }} res.
                    </span>
                </div>
                <div class="overflow-x-auto relative z-10">
                    <table class="w-full text-left text-sm text-gray-700">
                        <thead class="bg-primary-50 text-xs uppercase font-extrabold text-primary-900 tracking-wider">
                            <tr>
                                <th class="px-6 py-4 cursor-pointer hover:text-secondary transition-colors" wire:click="sortBy('date')">
                                    <div class="flex items-center gap-1.5"><span>Fecha</span> <i class="fas fa-sort text-[10px] opacity-70"></i></div>
                                </th>
                                <th class="px-6 py-4 cursor-pointer hover:text-secondary transition-colors hidden md:table-cell" wire:click="sortBy('instructor_name')">
                                    <div class="flex items-center gap-1.5"><span>Instructor</span> <i class="fas fa-sort text-[10px] opacity-70"></i></div>
                                </th>
                                <th class="px-6 py-4 cursor-pointer hover:text-secondary transition-colors" wire:click="sortBy('transaction')">
                                    <div class="flex items-center gap-1.5"><span>Descripción</span> <i class="fas fa-sort text-[10px] opacity-70"></i></div>
                                </th>
                                <th class="px-6 py-4 cursor-pointer hover:text-secondary transition-colors text-right" wire:click="sortBy('total')">
                                    <div class="flex items-center justify-end gap-1.5"><span>Total</span> <i class="fas fa-sort text-[10px] opacity-70"></i></div>
                                </th>
                                <th class="px-6 py-4 text-center">Estado</th>
                                <th class="px-6 py-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-gray-50 bg-white transition duration-300">
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-primary-900 text-sm">{{ \Carbon\Carbon::parse($transaction->date)->format('d M, Y') }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($transaction->date)->format('H:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-5 hidden md:table-cell">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-primary-50 text-primary-800 flex items-center justify-center font-bold text-xs ring-1 ring-primary-100">
                                                {{ substr($transaction->instructor_name ?? 'A', 0, 1) }}
                                            </div>
                                            <span class="font-semibold text-gray-700 text-sm">{{ $transaction->instructor_name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col gap-1.5 items-start">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] uppercase font-bold ring-1
                                                @if($transaction->transaction == 'Venta') bg-green-50 text-green-700 ring-green-200
                                                @elseif($transaction->transaction == 'Devolucion') bg-red-50 text-red-700 ring-red-200
                                                @elseif($transaction->transaction == 'Saldo a Favor') bg-secondary-50 text-secondary-700 ring-secondary-200
                                                @else bg-gray-50 text-gray-700 ring-gray-200 @endif">
                                                {{ $transaction->transaction }}
                                            </span>
                                            <div class="text-[10px] text-gray-400 font-mono tracking-wider">REF #{{ sprintf('%06d', $transaction->number) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <span class="font-extrabold text-primary-900 text-base">
                                            ${{ number_format($transaction->total, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @php
                                            $statusStyles = [
                                                1 => 'bg-amber-50 text-amber-700 ring-amber-200', 
                                                2 => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                                3 => 'bg-blue-50 text-blue-700 ring-blue-200', 
                                                4 => 'bg-orange-50 text-orange-700 ring-orange-200',
                                                5 => 'bg-rose-50 text-rose-700 ring-rose-200', 
                                                6 => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                            ];
                                            $statusNames = [
                                                1 => 'Pendiente', 2 => 'Recibido', 3 => 'Enviado',
                                                4 => 'Reembolso', 5 => 'Anulada', 6 => 'Aprobada'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] uppercase tracking-wider font-bold ring-1 {{ $statusStyles[$transaction->status] ?? 'bg-gray-50 ring-gray-200 text-gray-500' }}">
                                            @if($transaction->status == 1) <i class="fas fa-clock mr-1.5"></i> 
                                            @elseif($transaction->status == 6) <i class="fas fa-check-circle mr-1.5"></i>
                                            @endif
                                            {{ $statusNames[$transaction->status] ?? 'Desc.' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center items-center gap-2">
                                            @if ($transaction->transaction == 'Devolucion' && $transaction->status == 1)
                                                <button wire:click="acceptTransaction({{ $transaction->id }})" class="w-8 h-8 rounded-lg bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-colors duration-300 ring-1 ring-green-200 flex items-center justify-center transform hover:-translate-y-0.5" title="Aceptar">
                                                    <i class="fas fa-check text-xs"></i>
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
                                                   class="w-8 h-8 rounded-lg bg-primary-50 text-primary-800 hover:bg-primary-900 hover:text-white transition-colors duration-300 ring-1 ring-primary-100 flex items-center justify-center transform hover:-translate-y-0.5" 
                                                   title="Ver Comprobante">
                                                    <i class="fas fa-eye text-xs"></i>
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
            <div class="bg-white rounded-[2rem] p-12 md:p-16 text-center shadow-sm ring-1 ring-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary-50/50 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
                <div class="relative z-10 max-w-sm mx-auto">
                    <div class="w-20 h-20 bg-primary-50 text-primary-900 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm ring-1 ring-primary-100 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                        <i class="fas fa-file-invoice-dollar text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-primary-900 mb-3 tracking-tight">Sin Movimientos</h3>
                    <p class="text-gray-500 text-sm font-medium mb-8">No se encontraron transacciones con los parámetros actuales. Ajusta la búsqueda o intenta de nuevo.</p>
                    
                    <button wire:click="resetFiltersAndTransactions" class="inline-flex items-center justify-center px-6 py-3 bg-white text-gray-600 font-bold rounded-xl hover:bg-gray-50 shadow-sm ring-1 ring-gray-200 transition-all text-sm transform hover:-translate-y-0.5 w-full sm:w-auto">
                        <i class="fas fa-sync-alt mr-2 text-accent"></i> Restablecer Búsqueda
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
