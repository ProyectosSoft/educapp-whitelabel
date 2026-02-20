<div class="space-y-6 font-sans text-slate-600">
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-50 opacity-50 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-yellow-50 opacity-50 filter blur-3xl"></div>
        
        <div class="relative z-10 w-full md:w-auto">
             <h2 class="text-2xl md:text-3xl font-bold text-[#335A92] mb-2">
                <i class="fas fa-database mr-2 text-[#ECBD2D]"></i> Banco de Preguntas
            </h2>
            <p class="text-slate-500 text-base">Crea y gestiona tus categorías y preguntas para usar en múltiples exámenes.</p>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row gap-3 w-full md:w-auto items-center">
             <div class="relative w-full md:w-auto">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-slate-400"></i>
                </span>
                <input wire:model="search" type="text" 
                       class="w-full md:w-64 bg-slate-50 border border-gray-200 text-slate-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block pl-10 p-2.5 placeholder-slate-400 transition-all shadow-sm focus:bg-white" 
                       placeholder="Buscar categoría...">
            </div>

            <button wire:click="$set('showImportModal', true)" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 transition-all shadow-sm">
                <i class="fas fa-file-excel"></i> Importar
            </button>

            <button wire:click="$toggle('viewDeleted')" 
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm border {{ $viewDeleted ? 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' : 'bg-slate-50 text-slate-600 border-gray-200 hover:bg-gray-100' }}">
                <i class="fas {{ $viewDeleted ? 'fa-trash-restore' : 'fa-trash' }}"></i>
                {{ $viewDeleted ? 'Salir de Papelera' : 'Papelera' }}
            </button>
            
            <button wire:click="createCategory" class="px-5 py-2.5 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-yellow-400 transition-all text-sm flex items-center justify-center shadow-md hover:shadow-lg border border-yellow-400 transform hover:-translate-y-0.5">
                <i class="fas fa-folder-plus mr-2"></i> Nueva Categoría
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center shadow-sm">
            <i class="fas fa-check-circle mr-3 text-xl text-green-500"></i>
            <span class="font-medium ml-2">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        @forelse($categories as $category)
            <div x-data="{ open: false }" class="border-b border-gray-100 last:border-0 hover:bg-slate-50/50 transition-colors">
                {{-- Expandable Header --}}
                <div class="p-5 flex justify-between items-center cursor-pointer" @click="open = !open">
                    <div class="flex items-center gap-4">
                        <div class="transform transition-transform duration-200 text-slate-400" :class="open ? 'rotate-180' : ''">
                             <i class="fas fa-chevron-down"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#335A92] flex items-center gap-2">
                                <i class="fas fa-folder text-[#ECBD2D]"></i> {{ $category->name }}
                                @if($category->trashed())
                                    <span class="ml-2 px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600 border border-red-200">ELIMINADA</span>
                                @endif
                            </h3>
                            <div class="text-xs text-slate-500 mt-1 font-medium">
                                {{ $category->questions_count }} preguntas
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2" @click.stop>
                         @unless($viewDeleted)
                         <button wire:click="createQuestion({{ $category->id }})" class="px-3 py-1.5 bg-blue-50 text-[#335A92] rounded-lg text-xs font-bold hover:bg-blue-100 transition border border-blue-100 flex items-center shadow-sm">
                            <i class="fas fa-plus mr-1"></i> Pregunta
                        </button>
                        <button wire:click="editCategory({{ $category->id }})" class="p-2 text-slate-400 hover:text-[#335A92] transition">
                            <i class="fas fa-edit"></i>
                        </button>
                         <button onclick="confirmDeleteCategory({{ $category->id }}, '{{ addslashes($category->name) }}')" class="p-2 text-slate-400 hover:text-red-500 transition">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        @else
                            @if($category->trashed())
                                <button wire:click="restoreCategory({{ $category->id }})" class="px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-xs font-bold hover:bg-green-100 transition border border-green-200 shadow-sm">
                                    <i class="fas fa-trash-restore mr-1"></i> Restaurar
                                </button>
                            @endif
                        @endunless
                    </div>
                </div>

                {{-- Questions Body --}}
                <div x-show="open" class="bg-gray-50 border-t border-gray-100 p-4" x-transition>
                    @if($category->questions->isEmpty())
                        <div class="text-center text-slate-400 py-6 text-sm italic bg-white rounded-xl border border-dashed border-gray-200">
                            {{ $viewDeleted ? 'No hay preguntas eliminadas en esta categoría.' : 'No hay preguntas activas en esta categoría.' }}
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-3">
                            @foreach($category->questions as $q)
                                <div class="bg-white p-5 rounded-xl border border-gray-200 flex justify-between group hover:shadow-md transition-all {{ $viewDeleted ? 'opacity-75 grayscale' : '' }}">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded border {{ $q->type === 'closed' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-yellow-50 text-yellow-700 border-yellow-100' }}">
                                                {{ $q->type === 'closed' ? 'Cerrada' : 'Abierta' }}
                                            </span>
                                            @if($q->difficultyLevel)
                                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-purple-50 text-purple-700 border border-purple-100">
                                                    {{ $q->difficultyLevel->name }} ({{ $q->difficultyLevel->points }} pts)
                                                </span>
                                            @else
                                                 <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-gray-100 text-gray-500 border border-gray-200">
                                                    N/A
                                                </span>
                                            @endif
                                            @if($viewDeleted)
                                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-red-100 text-red-700 border border-red-200">Eliminada</span>
                                            @endif
                                        </div>
                                        <p class="text-slate-700 font-medium text-sm leading-relaxed">{{ $q->question_text }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity ml-4 justify-center">
                                        @if($viewDeleted)
                                            <button wire:click="restoreQuestion({{ $q->id }})" class="text-green-600 hover:text-green-700 font-bold text-xs bg-green-50 px-2 py-1 rounded border border-green-200 flex items-center" title="Restaurar"><i class="fas fa-trash-restore mr-1"></i> Restaurar</button>
                                        @else
                                            <button wire:click="editQuestion({{ $q->id }})" class="p-2 text-slate-400 hover:text-[#335A92] transition rounded-lg hover:bg-blue-50" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                                            <button wire:click="deleteQuestion({{ $q->id }})" class="p-2 text-slate-400 hover:text-red-500 transition rounded-lg hover:bg-red-50" title="Eliminar"><i class="fas fa-trash"></i></button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
             <div class="p-16 text-center">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-100">
                    <i class="fas fa-database text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-bold text-[#335A92] mb-2">Banco Vacío</h3>
                <p class="text-slate-500 max-w-md mx-auto">Aún no has creado ninguna categoría. Crea tu primera categoría para empezar a organizar tus preguntas de forma eficiente.</p>
                <button wire:click="createCategory" class="mt-6 px-6 py-3 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-yellow-400 transition-all shadow-md">
                    Crear mi primera categoría
                </button>
            </div>
        @endforelse
        <div class="p-4 bg-slate-50 border-t border-gray-200">
            {{ $categories->links() }}
        </div>
    </div>

    {{-- Modals --}}
    <!-- Import Modal -->
    @if($showImportModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 border border-gray-100 transform transition-all scale-100">
            <h3 class="text-xl font-bold text-[#335A92] mb-2">Importar Preguntas (Excel)</h3>
            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                Sube un archivo Excel (.xlsx) siguiendo el formato de nuestra plantilla.
                <a href="#" wire:click.prevent="downloadTemplate" class="text-[#335A92] hover:underline cursor-pointer font-bold ml-1">Descargar Plantilla</a>
            </p>

            <div class="space-y-4">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative mb-4 text-sm">
                        <strong class="font-bold flex items-center"><i class="fas fa-exclamation-circle mr-2"></i> ¡Atención!</strong>
                        <ul class="list-disc pl-5 mt-1 opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-[#335A92] hover:bg-blue-50/30 transition-all cursor-pointer relative group">
                    <input type="file" wire:model="importFile" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="fileImport">
                    <div class="pointer-events-none">
                        @if($importFile)
                            <div class="text-green-600 font-bold flex flex-col items-center animate-pulse">
                                <i class="fas fa-file-excel text-4xl mb-3"></i>
                                <span class="text-sm">{{ $importFile->getClientOriginalName() }}</span>
                            </div>
                        @else
                            <div class="text-slate-400 group-hover:text-[#335A92] flex flex-col items-center transition-colors">
                                <i class="fas fa-cloud-upload-alt text-4xl mb-3"></i>
                                <span class="text-sm font-medium">Click para seleccionar archivo</span>
                                <span class="text-xs mt-1 text-slate-300">Máximo 10MB</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div wire:loading wire:target="importFile" class="w-full mt-4">
                    <div class="flex items-center justify-center gap-2 text-[#335A92] text-sm font-bold">
                        <i class="fas fa-circle-notch fa-spin"></i> Subiendo archivo...
                    </div>
                </div>

                <div wire:loading wire:target="importQuestions" class="w-full mt-2">
                    <div class="flex items-center justify-center gap-2 text-[#ECBD2D] text-sm font-bold">
                        <i class="fas fa-spinner fa-spin"></i> Procesando datos...
                    </div>
                </div>

                @error('importFile') 
                    <div class="p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-lg font-bold shadow-sm mt-4 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2 text-lg"></i> {{$message}}
                    </div> 
                @enderror
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button wire:click="$set('showImportModal', false)" class="px-5 py-2.5 bg-white text-slate-600 border border-gray-200 rounded-xl hover:bg-gray-50 font-medium transition shadow-sm">Cancelar</button>
                <button type="button" wire:click="importQuestions"
                    class="px-5 py-2.5 bg-[#335A92] text-white rounded-xl font-bold hover:bg-[#2a4a78] transition shadow-md hover:shadow-lg flex items-center">
                    <span wire:loading.remove wire:target="importQuestions"><i class="fas fa-upload mr-2"></i> Subir e Importar</span>
                    <span wire:loading wire:target="importQuestions"><i class="fas fa-spinner fa-spin mr-2"></i> Procesando...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Category Modal -->
    @if($showCategoryModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 border border-gray-100 transform transition-all scale-100">
            <h3 class="text-xl font-bold text-[#335A92] mb-6">{{ $catId ? 'Editar Categoría' : 'Nueva Categoría' }}</h3>
            <div class="space-y-5">
                <div>
                     <label class="block text-sm font-bold text-slate-700 mb-2">Nombre de la Categoría</label>
                     <input type="text" wire:model="catName" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-2.5 text-slate-800 focus:ring-[#335A92] focus:border-[#335A92] transition-colors" placeholder="Ej: Matemáticas Básicas">
                     @error('catName') <span class="text-red-500 text-xs mt-1 block font-medium">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button wire:click="$set('showCategoryModal', false)" class="px-5 py-2.5 bg-white text-slate-600 border border-gray-200 rounded-xl hover:bg-gray-50 font-medium transition shadow-sm">Cancelar</button>
                <button wire:click="saveCategory" class="px-5 py-2.5 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-yellow-400 transition shadow-md border border-yellow-400">Guardar</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Question Modal -->
    @if($showQuestionModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl border border-gray-100 max-h-[90vh] flex flex-col transform transition-all scale-100">
            <div class="p-6 border-b border-gray-100 shrink-0 bg-slate-50/50 rounded-t-2xl">
                <h3 class="text-xl font-bold text-[#335A92]">{{ $qId ? 'Editar Pregunta' : 'Nueva Pregunta' }}</h3>
            </div>
            
            <div class="p-8 flex-1 overflow-y-auto space-y-6">
            
            @if($difficultyLevels->isEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded-r-lg shadow-sm" role="alert">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3 text-lg"></i>
                        <div>
                            <p class="font-bold mb-1">¡Faltan Niveles de Dificultad!</p>
                            <p class="text-sm mb-3 opacity-90">No tienes niveles de dificultad configurados. Es necesario tener al menos uno para crear preguntas.</p>
                            <a href="{{ route('exams.difficulty-levels') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs font-bold rounded-lg transition border border-yellow-200">
                                <i class="fas fa-external-link-alt mr-2"></i> Configurar Niveles
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tipo de Pregunta</label>
                    <div class="relative">
                        <select wire:model="qType" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] appearance-none">
                            <option value="closed">Cerrada / Selección Múltiple</option>
                            <option value="open">Abierta / Desarrollo</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nivel de Dificultad</label>
                    <div class="relative">
                        <select wire:model="qDifficultyLevelId" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] appearance-none">
                            @foreach($difficultyLevels as $level)
                                <option value="{{ $level->id }}">
                                    {{ $level->name }} ({{ $level->points }} pts)
                                </option>
                            @endforeach
                        </select>
                         <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                     @error('qDifficultyLevelId') <span class="text-red-500 text-xs mt-1 block">{{$message}}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Enunciado de la Pregunta</label>
                <textarea wire:model="qText" rows="3" class="w-full bg-slate-50 border border-gray-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-[#335A92] focus:border-[#335A92] transition-colors" placeholder="Escribe aquí tu pregunta..."></textarea>
                @error('qText') <span class="text-red-500 text-xs mt-1 block font-medium">{{$message}}</span> @enderror
            </div>

            @if($qType === 'closed')
                <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl shadow-inner">
                     <div class="flex justify-between mb-4 items-center">
                         <label class="text-sm font-bold text-slate-700 flex items-center"><i class="fas fa-list-ul mr-2 text-[#335A92]"></i> Opciones de Respuesta</label>
                         <button wire:click="addOption" class="text-xs text-[#335A92] font-bold bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition border border-blue-100 flex items-center">
                            <i class="fas fa-plus mr-1"></i> Agregar Opción
                        </button>
                     </div>
                     @error('qOptions') <div class="text-red-500 text-xs mb-3 font-medium bg-red-50 p-2 rounded border border-red-100">{{$message}}</div> @enderror
                     
                     <div class="space-y-3">
                        @foreach($qOptions as $index => $opt)
                            @php
                                $isDeleted = !empty($opt['deleted_at']);
                            @endphp
                            <div class="flex items-center gap-3 bg-white p-2 rounded-xl border border-gray-200 shadow-sm transition-all hover:border-gray-300 {{ $isDeleted ? 'opacity-60 bg-red-50' : '' }}">
                                <div class="tooltip" data-tip="Marcar como correcta">
                                    <input type="radio" name="copt" class="w-5 h-5 text-green-500 border-gray-300 focus:ring-green-500 cursor-pointer"
                                        wire:click="$set('qOptions.{{$index}}.is_correct', true); @foreach($qOptions as $i=>$o) @if($i!=$index) $set('qOptions.{{$i}}.is_correct', false); @endif @endforeach"
                                        @if($opt['is_correct']) checked @endif>
                                </div>
                                
                                <div class="flex-1 relative">
                                    <input type="text" wire:model="qOptions.{{$index}}.text" class="w-full border-0 focus:ring-0 text-slate-700 text-sm bg-transparent placeholder-slate-400" placeholder="Escribe una opción...">
                                    @if($isDeleted)
                                        <span class="absolute right-0 top-1/2 transform -translate-y-1/2 text-[10px] uppercase font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded-full border border-red-200">
                                            Eliminada
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-1 border-l pl-2 border-gray-100">
                                    @if($isDeleted)
                                         <button wire:click="restoreOption({{$index}})" class="p-2 text-green-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="Restaurar ahora">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    @endif

                                    <button wire:click="removeOption({{$index}})" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Eliminar de la lista">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                     </div>
                </div>
            @endif

            </div>
            <div class="flex justify-end gap-3 p-6 border-t border-gray-100 shrink-0 bg-slate-50/50 rounded-b-2xl">
                 <button wire:click="$set('showQuestionModal', false)" class="px-5 py-2.5 bg-white text-slate-600 border border-gray-200 rounded-xl hover:bg-gray-50 font-medium transition shadow-sm">Cancelar</button>
                 <button wire:click="saveQuestion" class="px-6 py-2.5 bg-[#335A92] text-white rounded-xl font-bold hover:bg-[#2a4a78] transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center">
                    <span wire:loading.remove wire:target="saveQuestion"><i class="fas fa-save mr-2"></i> Guardar Pregunta</span>
                    <span wire:loading wire:target="saveQuestion"><i class="fas fa-spinner fa-spin mr-2"></i> Guardando...</span>
                 </button>
            </div>
        </div>
    </div>
    @endif
</div>
@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeleteCategory(id, name) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `La categoría "${name}" se moverá a la papelera.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
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
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('deleteCategory', id);
            }
        })
    }

    document.addEventListener('livewire:load', function () {
        Livewire.on('swal:success', data => {
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: 'success',
                confirmButtonText: 'Aceptar',
                background: '#ffffff', 
                color: '#1e293b',
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-3xl border border-gray-100 shadow-2xl',
                    confirmButton: 'px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-500/30'
                }
            });
        });

        Livewire.on('swal:error', data => {
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: 'error',
                confirmButtonText: 'Cerrar',
                background: '#ffffff',
                color: '#1e293b',
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-3xl border border-gray-100 shadow-2xl',
                    confirmButton: 'px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-red-500/30'
                }
            });
        });
    });
</script>
@endpush
