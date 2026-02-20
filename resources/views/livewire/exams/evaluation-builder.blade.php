<div class="space-y-6 font-sans text-slate-600">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-50 opacity-50 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-yellow-50 opacity-50 filter blur-3xl"></div>
        
        <div class="relative z-10 w-full md:w-auto">
             <h2 class="text-2xl md:text-3xl font-bold text-[#335A92] mb-2">
                <i class="fas fa-tools mr-2 text-[#ECBD2D]"></i> Configuración de Evaluación
            </h2>
            <div class="flex items-center gap-2 text-slate-500 font-medium">
                <span class="bg-blue-50 text-[#335A92] px-2 py-0.5 rounded text-xs font-bold border border-blue-100">{{ $evaluation->exam->name }}</span>
                <i class="fas fa-chevron-right text-xs text-slate-300"></i>
                <span class="text-slate-700 font-bold">{{ $evaluation->name }}</span>
            </div>
        </div>
        
        <div class="relative z-10 flex flex-wrap gap-3 justify-center md:justify-end">
            <a href="{{ route('author.exams.manager') }}" class="px-5 py-2.5 bg-white text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm flex items-center justify-center border border-gray-200 shadow-sm">
                 <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
            <a href="{{ route('author.exams.question-bank') }}" class="px-5 py-2.5 bg-white text-[#335A92] font-bold rounded-xl hover:bg-blue-50 transition-all text-sm flex items-center justify-center border border-gray-200 shadow-sm">
                 <i class="fas fa-database mr-2"></i> Ir al Banco
            </a>
            <button wire:click="openAttachModal" class="px-5 py-2.5 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-yellow-400 transition-all text-sm flex items-center justify-center shadow-md hover:shadow-lg border border-yellow-400 transform hover:-translate-y-0.5">
                <i class="fas fa-plus-circle mr-2"></i> Asignar Categoría
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center shadow-sm">
            <i class="fas fa-check-circle mr-3 text-xl text-green-500"></i>
            <span class="font-medium ml-2">{{ session('message') }}</span>
        </div>
    @endif

    {{-- Attached Categories List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($evaluation->categories as $category)
            <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                {{-- Decoration --}}
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                
                <div class="p-6 relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 text-[#335A92] flex items-center justify-center shadow-sm border border-blue-100 transform group-hover:-rotate-6 transition-transform">
                             <i class="fas fa-layer-group text-lg"></i>
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="editConfig({{ $category->id }})" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:text-[#335A92] hover:bg-blue-50 transition flex items-center justify-center" title="Configurar">
                                <i class="fas fa-cog text-sm"></i>
                            </button>
                            <button onclick="confirmAction({ 
                                    title: '¿Remover categoría?', 
                                    text: '¿Estás seguro de que deseas quitar esta categoría de la evaluación?',
                                    confirmButtonText: 'Sí, remover',
                                    icon: 'warning'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        @this.call('detachCategory', {{ $category->id }})
                                    }
                                })" 
                                class="w-8 h-8 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition flex items-center justify-center" title="Eliminar">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-[#335A92] mb-1 line-clamp-1" title="{{ $category->name }}">{{ $category->name }}</h3>
                    
                    <div class="space-y-3 mt-5">
                        <!-- Weight -->
                        <div class="flex justify-between items-center text-sm p-2 bg-slate-50 rounded-lg">
                            <span class="text-slate-500 flex items-center font-medium">
                                <i class="fas fa-weight-hanging w-5 text-center mr-2 text-slate-400"></i>
                                Peso Total
                            </span>
                            <span class="font-bold text-[#335A92] text-base">{{ $category->pivot->weight_percent }}%</span>
                        </div>
                        
                         <!-- Questions -->
                        <div class="flex justify-between items-center text-sm p-2 bg-slate-50 rounded-lg">
                             <span class="text-slate-500 flex items-center font-medium">
                                <i class="fas fa-random w-5 text-center mr-2 text-slate-400"></i>
                                Preguntas
                            </span>
                            <span class="font-bold text-slate-700">{{ $category->pivot->questions_per_attempt }}</span>
                        </div>

                        <!-- Passing -->
                         <div class="flex justify-between items-center text-sm p-2 bg-slate-50 rounded-lg">
                             <span class="text-slate-500 flex items-center font-medium">
                                <i class="fas fa-check-circle w-5 text-center mr-2 text-slate-400"></i>
                                Mín. Aprobación
                            </span>
                            <span class="font-bold text-green-600">{{ $category->pivot->passing_percentage }}%</span>
                        </div>
                    </div>

                     {{-- Progress Bar Visual for Weight --}}
                     <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex justify-between text-[10px] uppercase font-bold text-slate-400 mb-1">
                            <span>Contribución al Examen</span>
                            <span>{{ $category->pivot->weight_percent }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-[#335A92] h-1.5 rounded-full" style="width: {{ $category->pivot->weight_percent }}%"></div>
                        </div>
                     </div>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 xl:col-span-3">
                <div class="text-center py-16 bg-white rounded-3xl shadow-sm border border-dashed border-gray-300">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i class="fas fa-clipboard-check text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#335A92] mb-2">Evaluación Vacía</h3>
                    <p class="text-slate-500 max-w-md mx-auto mb-8">Esta evaluación aún no tiene preguntas asignadas. Selecciona categorías de tu banco de preguntas para construir el examen dinámicamente.</p>
                    <button wire:click="openAttachModal" class="px-8 py-3 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-yellow-400 transition shadow-md hover:shadow-lg border border-yellow-400 transform hover:-translate-y-0.5">
                        <i class="fas fa-plus-circle mr-2"></i> Seleccionar Categorías
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Attach/Config Modal --}}
    @if($showAttachModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-opacity">
             <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 w-full max-w-lg p-8 relative transform transition-all scale-100">
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-[#335A92]">{{ $isEditingConfig ? 'Configurar Categoría' : 'Añadir Categoría a Evaluación' }}</h2>
                    <button wire:click="$set('showAttachModal', false)" class="text-slate-400 hover:text-slate-600 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-6">
                    @if(!$isEditingConfig)
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Seleccionar Categoría del Banco</label>
                            @if($availableCategories->isEmpty())
                                <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl text-sm mb-2 border border-yellow-100 flex items-start gap-3">
                                    <i class="fas fa-exclamation-triangle mt-0.5 text-yellow-500"></i>
                                    <div>
                                        <p class="font-bold">¡Sin categorías disponibles!</p>
                                        <p class="opacity-90 mt-1">No hay más categorías disponibles en tu banco que no estén ya en esta evaluación.</p>
                                        <a href="{{ route('author.exams.question-bank') }}" class="inline-block mt-2 underline font-bold text-yellow-900 hover:text-yellow-700">Ir al Banco de Preguntas</a>
                                    </div>
                                </div>
                            @else
                                <div class="relative">
                                    <select wire:model="selectedCategoryId" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] appearance-none transition-colors">
                                        <option value="">Selecciona una categoría...</option>
                                        @foreach($availableCategories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->questions_count }} preguntas)</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                @error('selectedCategoryId') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            @endif
                        </div>
                    @else
                         {{-- Informational display when editing --}}
                         <div class="p-4 bg-blue-50 text-[#335A92] rounded-xl text-sm border border-blue-100 flex items-center gap-3">
                            <i class="fas fa-info-circle text-lg"></i>
                            <div>
                                <p class="font-bold">Editando Configuración</p>
                                <p class="opacity-90">Ajusta los parámetros para esta categoría.</p>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-2xl border border-dashed border-gray-200">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-bold text-slate-500 mb-2">Peso (%)</label>
                            <div class="relative">
                                <input type="number" wire:model="configWeight" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] text-center font-bold text-lg shadow-sm transition-all" placeholder="0">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2 text-center font-medium">Valor del examen</p>
                            @error('configWeight') <span class="text-red-500 text-xs block mt-1 text-center font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-bold text-slate-500 mb-2">Preguntas</label>
                            <div class="relative">
                                <input type="number" wire:model="configQuestionsCount" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] text-center font-bold text-lg shadow-sm transition-all" placeholder="1">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">#</span>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2 text-center font-medium">Cantidad a mostrar</p>
                             @error('configQuestionsCount') <span class="text-red-500 text-xs block mt-1 text-center font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-2">
                             <label class="block text-xs uppercase tracking-wider font-bold text-slate-500 mb-2">Aprobación Mínima (%)</label>
                             <div class="relative">
                                 <input type="number" wire:model="configPassingPercentage" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] text-center font-bold text-lg shadow-sm transition-all" placeholder="60">
                                 <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                             </div>
                             <p class="text-[10px] text-slate-400 mt-2 text-center font-medium">Mínimo para aprobar esta categoría</p>
                             @error('configPassingPercentage') <span class="text-red-500 text-xs block mt-1 text-center font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <button wire:click="$set('showAttachModal', false)" class="px-5 py-2.5 bg-white border border-gray-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition shadow-sm">Cancelar</button>
                    @if(!$isEditingConfig && $availableCategories->isEmpty())
                        <button disabled class="px-5 py-2.5 bg-gray-200 text-gray-400 font-bold rounded-xl cursor-not-allowed">Guardar</button>
                    @else
                        <button wire:click="saveAttachment" class="px-5 py-2.5 bg-[#335A92] hover:bg-[#2a4a78] text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            {{ $isEditingConfig ? 'Actualizar Configuración' : 'Añadir a Evaluación' }}
                        </button>
                    @endif
                </div>
             </div>
        </div>
    @endif
</div>
@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmAction(config) {
        return Swal.fire({
            title: config.title,
            text: config.text,
            icon: config.icon || 'warning',
            showCancelButton: true,
            confirmButtonText: config.confirmButtonText || 'Sí, continuar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            background: '#ffffff',
            color: '#1e293b',
            iconColor: '#f59e0b',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-3xl border border-gray-100 shadow-2xl',
                confirmButton: 'px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-red-500/30 ml-3',
                cancelButton: 'px-6 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-slate-600 font-bold rounded-xl transition-all shadow-sm'
            }
        });
    }
</script>
@endpush
