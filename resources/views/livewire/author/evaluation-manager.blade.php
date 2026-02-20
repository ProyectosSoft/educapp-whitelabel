<div class="mt-4 border-t border-gray-100 pt-4">
    @if (!$evaluation && !$showForm)
        <div class="flex justify-center">
            <button wire:click="createEvaluation" class="flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                <i class="fas fa-clipboard-check mr-2"></i>
                {{ $section ? 'Agregar Evaluación a esta Sección' : 'Crear Evaluación Final' }}
            </button>
        </div>
    @elseif($evaluation && !$showForm)
        <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-4 flex justify-between items-center">
            <div>
                <h4 class="font-bold text-indigo-800 flex items-center">
                    <i class="fas fa-clipboard-check mr-2"></i> {{ $evaluation->name }}
                </h4>
                <div class="text-xs text-indigo-600 mt-1 flex space-x-3">
                    <span><i class="fas fa-question-circle"></i> {{ count($questions) }} Preguntas</span>
                    <span><i class="fas fa-percentage"></i> Aprueba: {{ $evaluation->passing_score }}%</span>
                </div>
            </div>
            <div class="flex space-x-2">
                 <button wire:click="editEvaluation" class="bg-white text-indigo-600 hover:text-indigo-800 border border-indigo-200 p-2 rounded-lg shadow-sm transition" title="Editar Evaluación">
                    <i class="fas fa-edit"></i>
                </button>
                 <!-- Add delete functionality later if needed -->
            </div>
        </div>
    @endif

    @if ($showForm)
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 relative">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">
                    {{ $evaluation ? 'Editar Evaluación' : 'Nueva Evaluación' }}
                </h3>
                <button wire:click="cancel" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Configuración General -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Título</label>
                    <input wire:model="name" class="form-input w-full rounded-lg border-gray-300">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div>
                     <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Intentos Permitidos</label>
                     <input type="number" wire:model="max_attempts" class="form-input w-full rounded-lg border-gray-300">
                     @error('max_attempts') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                     <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Puntaje para Aprobar (%)</label>
                     <input type="number" wire:model="passing_score" class="form-input w-full rounded-lg border-gray-300">
                     @error('passing_score') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                     <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tiempo de Espera entre Intentos (Minutos)</label>
                     <input type="number" wire:model="wait_time_minutes" class="form-input w-full rounded-lg border-gray-300" placeholder="0 = Sin espera">
                     @error('wait_time_minutes') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                     <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tiempo Límite de Duración (Minutos)</label>
                     <input type="number" wire:model="time_limit" class="form-input w-full rounded-lg border-gray-300" placeholder="0 = Sin límite de tiempo">
                     @error('time_limit') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                     <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Modo de Inicio</label>
                     <select wire:model="start_mode" class="form-input w-full rounded-lg border-gray-300">
                         <option value="automatic">Automático (Al terminar lecciones)</option>
                         <option value="manual">Manual (Botón iniciar)</option>
                     </select>
                     @error('start_mode') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                @if($start_mode === 'manual')
                    <div class="col-span-2 md:col-span-1 border border-gray-200 rounded-lg p-3 flex items-center justify-between bg-white shadow-sm mt-4 md:mt-0">
                         <div>
                             <label class="block text-xs font-bold text-gray-700 uppercase">Mostrar enlace</label>
                             <p class="text-xs text-gray-500">Habilita el acceso al examen</p>
                         </div>
                         <div class="form-check form-switch ml-4">
                            <input wire:model="is_visible" class="form-checkbox h-5 w-5 text-indigo-600 rounded cursor-pointer" type="checkbox">
                         </div>
                    </div>
                @endif
            </div>

            <hr class="border-gray-200 my-4">

            <!-- Gestor de Preguntas -->
            <div class="space-y-4">
                <h4 class="font-bold text-gray-700">Preguntas</h4>
                
                @foreach ($questions as $qIndex => $question)
                    <div wire:key="question-{{ $qIndex }}" class="bg-white border boundary-gray-200 rounded-lg p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold text-gray-400 uppercase">Pregunta {{ $qIndex + 1 }}</span>
                            <button wire:click="removeQuestion({{ $qIndex }})" class="text-red-400 hover:text-red-600">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        
                        <div class="mb-3">
                            <input wire:model="questions.{{ $qIndex }}.statement" class="form-input w-full rounded-lg border-gray-300" placeholder="Escribe la pregunta aquí...">
                             @error("questions.$qIndex.statement") <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Respuestas -->
                        <div class="ml-4 space-y-2">
                             @foreach ($question['answers'] as $aIndex => $answer)
                                <div wire:key="answer-{{ $qIndex }}-{{ $aIndex }}" class="flex items-center space-x-2">
                                     <input type="radio" name="correct_answer_{{ $qIndex }}" wire:click="$set('questions.{{ $qIndex }}.answers.{{ $aIndex }}.is_correct', true)" {{ $answer['is_correct'] ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                     <input wire:model="questions.{{ $qIndex }}.answers.{{ $aIndex }}.text" class="form-input w-full text-sm rounded-lg border-gray-300 py-1" placeholder="Respuesta {{ $aIndex + 1 }}">
                                     <button wire:click="removeAnswer({{ $qIndex }}, {{ $aIndex }})" class="text-gray-300 hover:text-red-500">
                                        <i class="fas fa-times"></i>
                                     </button>
                                </div>
                             @endforeach
                             <button wire:click="addAnswer({{ $qIndex }})" class="text-xs font-bold text-indigo-500 hover:text-indigo-700 mt-2">
                                + Agregar Respuesta
                             </button>
                        </div>
                    </div>
                @endforeach

                <button wire:click="addQuestion" class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 font-bold hover:border-indigo-500 hover:text-indigo-600 transition">
                    + Agregar Nueva Pregunta
                </button>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button wire:click="cancel" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </button>
                <button wire:click="save" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                    Guardar Evaluación
                </button>
            </div>
        </div>
    @endif
</div>
