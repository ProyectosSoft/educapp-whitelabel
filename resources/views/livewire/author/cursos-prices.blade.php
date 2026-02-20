<div>
     <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
             <!-- Header Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-white">Tarifas y Precios</h1>
                    <p class="text-indigo-100 text-sm mt-1">Configura los precios y descuentos para tu curso.</p>
                </div>
                <div x-data="{ open: @entangle('openForm2') }">
                     <button wire:click="abrirFormulario" class="bg-white text-indigo-600 hover:bg-gray-50 font-bold py-2 px-4 rounded-xl shadow-sm transition flex items-center text-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Tarifa
                    </button>
                </div>
            </div>

            <div class="px-8 py-8" x-data="{ open: @entangle('openForm2') }">
                 <!-- Formulario para agregar y editar -->
                <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="mb-8 bg-gray-50 rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-tag text-indigo-500 mr-2"></i>
                        {{ $priceId ? 'Editar Tarifa' : 'Crear Nueva Tarifa' }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="col-span-2">
                            <label for="nombre" class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre de la Tarifa</label>
                            <input id="nombre" wire:model="nombre" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ej: Precio Estándar, Promoción Navideña...">
                            @error('nombre') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                         <!-- Valor -->
                         <div>
                            <label for="valor" class="block text-xs font-bold text-gray-500 uppercase mb-1">Valor</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input id="valor" wire:model="valor" type="number" class="form-input w-full pl-7 bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
                            </div>
                            @error('valor') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Moneda -->
                        <div>
                             <label for="moneda" class="block text-xs font-bold text-gray-500 uppercase mb-1">Moneda</label>
                             <select id="moneda" wire:model="moneda" class="form-select w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccionar...</option>
                                @foreach ($monedas as $moneda)
                                    <option value="{{ $moneda->id }}">{{ $moneda->abreviatura }}</option>
                                @endforeach
                            </select>
                             @error('moneda') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Descuentos -->
                        <div>
                             <label for="descuentomin" class="block text-xs font-bold text-gray-500 uppercase mb-1">Descuento Mínimo</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input id="descuentomin" wire:model="descuentomin" type="number" class="form-input w-full pl-7 bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
                             </div>
                             @error('descuentomin') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                             <label for="descuentomax" class="block text-xs font-bold text-gray-500 uppercase mb-1">Descuento Máximo</label>
                             <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input id="descuentomax" wire:model="descuentomax" type="number" class="form-input w-full pl-7 bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
                             </div>
                             @error('descuentomax') <span class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                         <button wire:click="$set('openForm2', false)" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancelar
                        </button>
                        <button wire:click="saveOrUpdate" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-md">
                            {{ $priceId ? 'Actualizar Tarifa' : 'Crear Tarifa' }}
                        </button>
                    </div>
                </div>

                <!-- Tabla de Precios -->
                @if ($prices->count())
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre Tarifa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Valor Base</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rango Descuento</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Moneda</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($prices as $price)
                                    <tr class="hover:bg-indigo-50/30 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $price->nombre }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-green-600">$ {{ number_format($price->valor, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <div class="flex flex-col text-xs">
                                                <span class="text-gray-500">Min: <span class="font-medium text-gray-700">$ {{ number_format($price->dctoMin, 0, ',', '.') }}</span></span>
                                                <span class="text-gray-500">Max: <span class="font-medium text-gray-700">$ {{ number_format($price->dctoMax, 0, ',', '.') }}</span></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $price->moneda->abreviatura }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="edit({{ $price->id }})" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
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
                            <i class="fas fa-dollar-sign text-3xl text-indigo-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">No hay tarifas configuradas</h3>
                        <p class="text-sm mb-4 max-w-sm">Agrega precios a tu curso para empezar a vender.</p>
                        <button wire:click="abrirFormulario" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">
                            + Crear primera tarifa
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
