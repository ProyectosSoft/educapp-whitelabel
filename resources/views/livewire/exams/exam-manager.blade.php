<div class="space-y-6 font-sans text-slate-600">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
        {{-- Decorative Blur --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-50 opacity-50 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-yellow-50 opacity-50 filter blur-3xl"></div>
        
        <div class="relative z-10 w-full md:w-auto">
             <h2 class="text-2xl md:text-3xl font-bold text-[#335A92] mb-2">
                <i class="fas fa-clipboard-check mr-2 text-[#ECBD2D]"></i> Gestión de Evaluaciones
            </h2>
            <p class="text-slate-500 text-base">Administra la configuración y parámetros de los exámenes.</p>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row gap-3 w-full md:w-auto items-center">
            <div class="relative w-full md:w-auto">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-slate-400"></i>
                </span>
                <input wire:model="search" type="text" 
                       class="w-full md:w-64 bg-slate-50 border border-gray-200 text-slate-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block pl-10 p-2.5 placeholder-slate-400 transition-all shadow-sm focus:bg-white" 
                       placeholder="Buscar evaluación...">
            </div>
            
            <a href="{{ route('author.exams.difficulty-levels') }}" class="px-5 py-2.5 bg-white text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm flex items-center justify-center shadow-sm border border-gray-200">
                <i class="fas fa-tachometer-alt mr-2 text-[#335A92]"></i> Dificultad
            </a>

            <button wire:click="create" class="px-5 py-2.5 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-yellow-400 transition-all text-sm flex items-center justify-center shadow-md hover:shadow-lg border border-yellow-400 transform hover:-translate-y-0.5">
                <i class="fas fa-plus-circle mr-2"></i> Nueva Evaluación
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center shadow-sm">
            <i class="fas fa-check-circle mr-3 text-xl text-green-500"></i>
            <span class="font-medium ml-2">{{ session('message') }}</span>
        </div>
    @endif

    {{-- Evaluations List --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-wider">Nombre</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Examen Padre</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Configuración</th>
                        <th class="px-6 py-4 text-center font-bold tracking-wider">Estado</th>
                        <th class="px-6 py-4 text-center font-bold tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($evaluations as $eval)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 font-bold text-slate-700 text-base">{{ $eval->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $eval->exam->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                <div class="flex flex-col space-y-1.5">
                                    <span class="flex items-center"><i class="fas fa-redo-alt w-4 mr-1.5 text-[#335A92]"></i> Intentos: <strong class="ml-1">{{ $eval->max_attempts }}</strong></span>
                                    <span class="flex items-center"><i class="fas fa-clock w-4 mr-1.5 text-[#335A92]"></i> Tiempo: <strong class="ml-1">{{ $eval->time_limit_minutes ?? 'Infinito' }} min</strong></span>
                                    <span class="flex items-center"><i class="fas fa-percentage w-4 mr-1.5 text-[#335A92]"></i> Aprueba: <strong class="ml-1">{{ $eval->passing_score }}%</strong></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $eval->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                    <span class="w-2 h-2 mr-2 {{ $eval->is_active ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></span>
                                    {{ $eval->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('author.exams.builder', $eval->id) }}" class="inline-flex p-2 text-[#ECBD2D] hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition" title="Gestionar Preguntas">
                                    <i class="fas fa-layer-group text-lg"></i>
                                </a>
                                <button wire:click="edit({{ $eval->id }})" class="inline-flex p-2 text-slate-400 hover:text-[#335A92] hover:bg-blue-50 rounded-lg transition" title="Editar Configuración">
                                    <i class="fas fa-edit text-lg"></i>
                                </button>
                                <a href="{{ route('author.exams.monitoring', $eval->id) }}" class="inline-flex p-2 text-purple-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition" title="Ver Resultados">
                                    <i class="fas fa-list-alt text-lg"></i>
                                </a>
                                <a href="{{ route('author.exams.statistics', $eval->id) }}" class="inline-flex p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Ver Estadísticas">
                                    <i class="fas fa-chart-pie text-lg"></i>
                                </a>
                                <button onclick="confirmDelete({{ $eval->id }})" class="inline-flex p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Eliminar">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                        <i class="fas fa-clipboard-list text-3xl text-slate-300"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-700 mb-1">Sin Evaluaciones</h3>
                                    <p class="text-slate-500 font-medium">No se encontraron evaluaciones configuradas.</p>
                                    <button wire:click="create" class="mt-4 text-[#335A92] font-bold hover:underline">Crear primera evaluación</button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-gray-200">
            {{ $evaluations->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal Override -->
    @if($isCreating || $isEditing)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-opacity">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl border border-gray-100 p-8 relative transform transition-all scale-100 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-2xl font-bold text-[#335A92] flex items-center gap-2">
                        <i class="fas {{ $isEditing ? 'fa-edit' : 'fa-plus-circle' }} text-[#ECBD2D]"></i>
                        {{ $isEditing ? 'Editar Evaluación' : 'Nueva Evaluación' }}
                    </h2>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition bg-slate-50 p-2 rounded-full hover:bg-slate-100">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nombre de la Evaluación</label>
                        <input type="text" wire:model="evalName" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors placeholder-slate-400" placeholder="Ej: Examen Final de Matemáticas">
                        @error('evalName') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Categoría</label>
                            <div class="relative">
                                <select wire:model="evalCategoryId" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors appearance-none">
                                    <option value="">Seleccione Categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            @error('evalCategoryId') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Subcategoría</label>
                            <div class="relative">
                                <select wire:model="evalSubcategoryId" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors appearance-none">
                                    <option value="">Seleccione Subcategoría</option>
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                             @error('evalSubcategoryId') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                        <h4 class="text-[#335A92] font-bold mb-4 flex items-center"><i class="fas fa-cogs mr-2"></i> Configuración de Ejecución</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Intentos Máximos</label>
                                <input type="number" wire:model="evalNumRequests" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors">
                                @error('evalNumRequests') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tiempo Límite (min)</label>
                                <input type="number" wire:model="evalTimeLimit" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors" placeholder="0 = Infinito">
                                <p class="text-[10px] text-slate-400 mt-1">Dejar en 0 para tiempo ilimitado</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Puntaje Aprobar (%)</label>
                                <input type="number" wire:model="evalPassingScore" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors">
                                @error('evalPassingScore') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Espera entre intentos (min)</label>
                                <input type="number" wire:model="evalWaitTime" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="evalIsActive" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                            <span class="ml-3 text-sm font-bold text-slate-700">Evaluación Activa</span>
                        </label>
                        <span class="ml-auto text-xs text-slate-400">Si se desactiva, los alumnos no podrán verla.</span>
                    </div>

                    <div class="flex items-center p-4 bg-indigo-50/50 rounded-xl border border-indigo-100">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="evalIsPublic" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-500"></div>
                            <span class="ml-3 text-sm font-bold text-slate-700">Examen Público (Visible en Home)</span>
                        </label>
                    </div>
                    
                    @if(!$evalIsPublic)
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-6 rounded-xl border border-gray-200 transition-all">
                            <div class="col-span-2 mb-2">
                                <h5 class="text-sm font-bold text-slate-600"><i class="fas fa-lock mr-2 text-slate-400"></i> Restricciones de Acceso</h5>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Empresa</label>
                                <div class="relative">
                                    <select wire:model="evalEmpresaId" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors appearance-none">
                                        <option value="">Seleccione Empresa...</option>
                                        @foreach($empresas as $empresa)
                                            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                @error('evalEmpresaId') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Departamento</label>
                                 <div class="relative">
                                    <select wire:model="evalDepartamentoId" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors appearance-none">
                                        <option value="">Todos los departamentos</option>
                                        @foreach($departamentosFilter as $depto)
                                            <option value="{{ $depto->id }}">{{ $depto->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                 @error('evalDepartamentoId') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                         </div>
                    @endif
                </div>

                <div class="mt-8 flex justify-end space-x-3 pt-6 border-t border-gray-100 bg-white sticky bottom-0 z-10">
                    <button wire:click="closeModal" class="px-6 py-3 bg-white border border-gray-200 hover:bg-gray-50 text-slate-700 rounded-xl font-bold transition-colors shadow-sm">Cancelar</button>
                    <button wire:click="{{ $isEditing ? 'update' : 'store' }}" class="px-6 py-3 bg-[#335A92] hover:bg-[#2a4a78] text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        {{ $isEditing ? 'Guardar Cambios' : 'Crear Evaluación' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(evaluationId) {
        Swal.fire({
            title: '¿Eliminar evaluación?',
            text: "Esta acción no se puede deshacer. Se perderán las configuraciones y asignaciones.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            background: '#ffffff',
            color: '#1e293b',
            iconColor: '#ef4444',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-3xl border border-gray-100 shadow-2xl',
                confirmButton: 'px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-red-500/30 ml-3',
                cancelButton: 'px-6 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-slate-600 font-bold rounded-xl transition-all shadow-sm'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', evaluationId);
            }
        });
    }
</script>
@endpush
