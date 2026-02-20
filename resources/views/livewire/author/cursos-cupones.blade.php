<div>
     <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
             <!-- Header Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-white">Cupones de Descuento</h1>
                    <p class="text-indigo-100 text-sm mt-1">Crea y gestiona códigos promocionales para tu curso.</p>
                </div>
                <div x-data="{ open: @entangle('openForm') }">
                     <button wire:click="abrirFormulario" class="bg-white text-indigo-600 hover:bg-gray-50 font-bold py-2 px-4 rounded-xl shadow-sm transition flex items-center text-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Nuevo Cupón
                    </button>
                </div>
            </div>

            <div class="px-8 py-8" x-data="{ open: @entangle('openForm') }">
                 <!-- Formulario para agregar y editar -->
                <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="mb-8 bg-gray-50 rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-tag text-indigo-500 mr-2"></i>
                        {{ $cuponId ? 'Editar Cupón' : 'Crear Nuevo Cupón' }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="nombre" class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre</label>
                            <input id="nombre" wire:model="nombre" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ej: Lanzamiento, Black Friday...">
                            @error('nombre') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Código -->
                         <div class="col-span-2 md:col-span-1">
                            <label for="codigo" class="block text-xs font-bold text-gray-500 uppercase mb-1">Código</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-ticket-alt text-gray-400"></i>
                                </div>
                                <input id="codigo" wire:model="codigo" class="form-input w-full pl-10 bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 font-mono uppercase" placeholder="CODIGO123">
                            </div>
                            @error('codigo') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fechas -->
                        <div>
                             <label for="fecha_inicio" class="block text-xs font-bold text-gray-500 uppercase mb-1">Fecha Inicio</label>
                             <input id="fecha_inicio" type="date" wire:model="fecha_inicio" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                             @error('fechaInicio') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                         <div>
                             <label for="fecha_final" class="block text-xs font-bold text-gray-500 uppercase mb-1">Fecha Final</label>
                             <input id="fecha_final" type="date" wire:model="fecha_final" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                             @error('fechaFinal') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Valor y Cantidad -->
                         <div>
                            <label for="valor" class="block text-xs font-bold text-gray-500 uppercase mb-1">Descuento (COP)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input id="valor" wire:model="valor" type="number" class="form-input w-full pl-7 bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
                            </div>
                            @error('valor') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="cantidad" class="block text-xs font-bold text-gray-500 uppercase mb-1">Límite de Canjes</label>
                            <input id="cantidad" wire:model="cantidad" type="number" min="0" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="0 para ilimitado">
                             @error('cantidad') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                         <!-- Estado -->
                        <div class="col-span-2">
                             <label for="estado" class="block text-xs font-bold text-gray-500 uppercase mb-1">Estado</label>
                            <select id="estado" wire:model="estado" class="form-select w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="2">Seleccionar...</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                             @error('estado') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                         <button wire:click="$set('openForm', false)" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancelar
                        </button>
                        <button wire:click="storeOrUpdate" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-md">
                            {{ $cuponId ? 'Actualizar Cupón' : 'Crear Cupón' }}
                        </button>
                    </div>
                </div>

                <!-- Tabla de Cupones -->
                @if ($cupones->isNotEmpty())
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info Cupón</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Vigencia</th>
                                     <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Descuento</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($cupones as $cupon)
                                    <tr class="hover:bg-indigo-50/30 transition duration-150">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $cupon->nombre }}</div>
                                            <div class="text-xs font-mono text-indigo-600 bg-indigo-50 inline-block px-1.5 py-0.5 rounded mt-1 border border-indigo-100">{{ $cupon->codigo }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Cant: {{ $cupon->cantidad == 0 ? 'Ilimitado' : $cupon->cantidad }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <div class="flex flex-col">
                                                <span><span class="font-medium text-xs text-gray-400">Inicio:</span> {{ \Carbon\Carbon::parse($cupon->fecha_inicio)->format('d/m/Y') }}</span>
                                                <span class="mt-1"><span class="font-medium text-xs text-gray-400">Fin:</span> {{ \Carbon\Carbon::parse($cupon->fecha_fin)->format('d/m/Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                             <div class="text-sm font-bold text-green-600">$ {{ number_format($cupon->valor, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cupon->estado == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $cupon->estado == 1 ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="edit({{ $cupon->id }})" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                                <i class="fas fa-edit mr-1"></i> Editar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                   <div class="flex flex-col items-center justify-center py-12 text-center text-gray-500 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50">
                        <div class="bg-indigo-50 rounded-full p-4 mb-3">
                            <i class="fas fa-ticket-alt text-3xl text-indigo-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">No tienes cupones creados</h3>
                        <p class="text-sm mb-4 max-w-sm">Crea cupones de descuento para impulsar las ventas de tu curso.</p>
                        <button wire:click="abrirFormulario" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">
                            + Crear primer cupón
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
