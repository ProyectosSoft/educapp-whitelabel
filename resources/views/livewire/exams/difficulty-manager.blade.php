<div class="space-y-6 font-sans text-slate-600">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-50 opacity-50 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-yellow-50 opacity-50 filter blur-3xl"></div>
        
        <div class="relative z-10 w-full md:w-auto">
             <h2 class="text-2xl md:text-3xl font-bold text-[#335A92] mb-2">
                <i class="fas fa-layer-group mr-2 text-[#ECBD2D]"></i> Niveles de Dificultad
            </h2>
            <p class="text-slate-500 text-base">Gestiona los puntajes base para las preguntas del sistema.</p>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row gap-3 w-full md:w-auto">
             <button wire:click="create" class="px-6 py-2.5 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-yellow-400 transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 border border-yellow-400 transform hover:-translate-y-0.5">
                <i class="fas fa-plus"></i> Nuevo Nivel
            </button>
        </div>
    </div>

    {{-- Feedback Messages --}}
    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center shadow-sm">
            <i class="fas fa-check-circle mr-3 text-xl text-green-500"></i>
            <span class="font-medium ml-2">{{ session('message') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center shadow-sm">
            <i class="fas fa-exclamation-triangle mr-3 text-xl text-red-500"></i>
            <span class="font-medium ml-2">{{ session('error') }}</span>
        </div>
    @endif

    {{-- List Table --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-wider">Nivel / Etiqueta</th>
                        <th class="px-6 py-4 text-center font-bold tracking-wider">Valor en Puntos</th>
                        <th class="px-6 py-4 text-right font-bold tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($levels as $level)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 font-bold text-slate-700">
                                {{ $level->name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-50 text-[#335A92] font-bold px-3 py-1 rounded-full text-xs border border-blue-100">
                                    {{ $level->points }} pts
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $level->id }})" class="p-2 text-slate-400 hover:text-[#335A92] hover:bg-blue-50 rounded-lg transition" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $level->id }})" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                        <i class="fas fa-layer-group text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="font-medium">No hay niveles de dificultad configurados.</p>
                                    <p class="text-xs mt-1">Crea uno nuevo para empezar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100">
                    <div class="px-6 pt-6 pb-4 sm:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-[#335A92]" id="modal-title">
                                {{ $selectedLevelId ? 'Editar Nivel' : 'Crear Nuevo Nivel' }}
                            </h3>
                            <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nombre del Nivel (Ej. Alta, Media)</label>
                                <input type="text" wire:model.defer="name" class="w-full rounded-xl border-gray-200 text-slate-700 shadow-sm focus:border-[#335A92] focus:ring focus:ring-blue-100 focus:ring-opacity-50 transition bg-slate-50 placeholder-slate-400" placeholder="Ej: Avanzado">
                                @error('name') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Valor en Puntos</label>
                                <div class="relative">
                                    <input type="number" wire:model.defer="points" class="w-full rounded-xl border-gray-200 text-slate-700 shadow-sm focus:border-[#335A92] focus:ring focus:ring-blue-100 focus:ring-opacity-50 transition bg-slate-50 placeholder-slate-400" placeholder="Ej. 10">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-slate-400 text-sm font-bold">pts</span>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-500 mt-2 font-medium">Este valor se usará para calcular la nota final del examen.</p>
                                @error('points') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-100">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md hover:shadow-lg px-6 py-2.5 bg-[#335A92] text-base font-bold text-white hover:bg-[#2a4a78] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#335A92] sm:ml-3 sm:w-auto sm:text-sm transition transform hover:-translate-y-0.5">
                            Guardar
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($isConfirmOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="closeConfirm"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10 border border-red-100">
                                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-slate-800">
                                    Eliminar Nivel de Dificultad
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500">
                                        ¿Estás seguro que deseas eliminar este nivel? Esta acción no se puede deshacer y podría afectar el cálculo de exámenes pasados.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button wire:click="destroy" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md hover:shadow-lg px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition transform hover:-translate-y-0.5">
                            Sí, Eliminar
                        </button>
                        <button wire:click="closeConfirm" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
