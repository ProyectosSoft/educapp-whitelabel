<div class="space-y-6 font-sans text-slate-600">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
        {{-- Decorative Blur --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-50 opacity-50 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-yellow-50 opacity-50 filter blur-3xl"></div>
        
        <div class="relative z-10 w-full md:w-auto">
             <h2 class="text-2xl md:text-3xl font-bold text-[#335A92] mb-2">
                <i class="fas fa-file-signature mr-2 text-[#ECBD2D]"></i> Calificación de Evaluaciones
            </h2>
            <p class="text-slate-500 text-base">Revisa y califica las preguntas abiertas pendientes.</p>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row gap-3 w-full md:w-auto">
             <!-- Action buttons if needed -->
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center shadow-sm">
            <i class="fas fa-check-circle mr-3 text-xl text-green-500"></i>
            <span class="font-medium ml-2">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center shadow-sm">
            <i class="fas fa-exclamation-circle mr-3 text-xl text-red-500"></i>
            <span class="font-medium ml-2">{{ session('error') }}</span>
        </div>
    @endif

    @if(!$selectedAttempt)
        <!-- List View -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-[#335A92] flex items-center">
                    <i class="fas fa-tasks mr-2 text-slate-400"></i> Pendientes de Revisión
                </h3>
                <span class="bg-blue-100 text-[#335A92] text-xs font-bold px-3 py-1 rounded-full border border-blue-200">
                    {{ $pendingAttempts->count() }} pendientes
                </span>
            </div>
            
            @if($groupedAttempts->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-green-100">
                        <i class="fas fa-check-circle text-4xl text-green-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#335A92] mb-2">¡Todo al día!</h3>
                    <p class="text-slate-500">No hay evaluaciones pendientes de revisión en este momento.</p>
                </div>
            @else
                <div class="space-y-4 p-6">
                    @foreach($groupedAttempts as $evalId => $attempts)
                         @php
                            $evalName = $attempts->first()->evaluation->name;
                            $examName = $attempts->first()->evaluation->exam->name;
                            $isExpanded = isset($expandedGroups[$evalId]);
                         @endphp
                        
                        <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm transition-shadow hover:shadow-md">
                            <button wire:click="toggleGroup({{ $evalId }})" class="w-full flex items-center justify-between p-5 bg-white hover:bg-slate-50 transition-colors text-left" aria-expanded="{{ $isExpanded ? 'true' : 'false' }}">
                                <div class="flex items-center gap-4">
                                    <div class="bg-blue-50 text-[#335A92] w-12 h-12 rounded-lg flex items-center justify-center shrink-0 border border-blue-100">
                                        <i class="fas fa-file-alt text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#335A92] text-lg leading-tight">{{ $evalName }}</h4>
                                        <p class="text-xs text-slate-500 mt-1">{{ $examName }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                     <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                        {{ $attempts->count() }} pendientes
                                     </span>
                                     <i class="fas fa-chevron-down transition-transform duration-200 {{ $isExpanded ? 'transform rotate-180' : '' }} text-slate-400"></i>
                                </div>
                            </button>

                            @if($isExpanded)
                                <div class="border-t border-gray-100 bg-slate-50">
                                    <table class="w-full text-sm text-left">
                                        <thead class="text-xs text-slate-500 uppercase bg-gray-100 border-b border-gray-200">
                                            <tr>
                                                <th class="px-6 py-3 font-semibold">Estudiante</th>
                                                <th class="px-6 py-3 font-semibold">Fecha Finalización</th>
                                                <th class="px-6 py-3 font-semibold text-right">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($attempts as $attempt)
                                                <tr class="hover:bg-white transition duration-150">
                                                    <td class="px-6 py-4 font-medium text-slate-700">
                                                        <div class="flex items-center">
                                                            <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 mr-3 font-bold text-xs uppercase border border-slate-300">
                                                                {{ substr($attempt->user->name, 0, 2) }}
                                                            </div>
                                                            {{ $attempt->user->name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-slate-500 font-mono text-xs">
                                                        {{ $attempt->completed_at ? $attempt->completed_at->format('d/m/Y H:i') : '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 text-right">
                                                        <button wire:click="selectAttempt({{ $attempt->id }})" class="inline-flex items-center px-4 py-2 bg-[#335A92] hover:bg-[#2a4a78] text-white text-xs font-bold rounded-lg transition shadow-sm hover:shadow-md">
                                                            Revisar <i class="fas fa-arrow-right ml-2"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <!-- Grading View -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 shadow-md">
            <div class="p-8 border-b border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-[#335A92] mb-1">{{ $selectedAttempt->evaluation->name }}</h2>
                        <div class="flex items-center text-slate-500 text-sm">
                            <i class="fas fa-user-graduate mr-2 text-slate-400"></i>
                            Estudiante: <span class="font-semibold ml-1 text-slate-700">{{ $selectedAttempt->user->name }}</span>
                        </div>
                    </div>
                    <button wire:click="cancel" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 border border-gray-200 hover:border-gray-300 rounded-lg text-sm font-medium transition flex items-center shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </button>
                </div>
            </div>

            <div class="p-8 space-y-8 bg-slate-50/50">
                @foreach($selectedAttempt->attemptQuestions as $index => $aq)
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 relative shadow-sm {{ $aq->question->type === 'open' ? 'ring-1 ring-yellow-200' : '' }}">
                        <div class="flex justify-between mb-4 items-start">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#335A92] text-white font-bold text-sm shadow-md">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-700">Pregunta</h3>
                                    <span class="text-xs text-slate-500 font-medium">Max: {{ number_format($aq->max_score, 2) }} pts</span>
                                </div>
                            </div>
                            <span class="text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wide border {{ $aq->question->type === 'open' ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 'bg-blue-100 text-blue-800 border-blue-200' }}">
                                {{ $aq->question->type === 'open' ? 'Abierta' : 'Cerrada' }}
                            </span>
                        </div>
                        
                        <div class="pl-11">
                            <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-gray-300 mb-6">
                                <p class="text-slate-700 text-lg leading-relaxed font-medium">{{ $aq->question->question_text }}</p>
                            </div>

                            @if($aq->question->type === 'closed')
                                <div class="bg-white p-5 rounded-xl border border-gray-200 mb-2 shadow-sm">
                                    <p class="text-xs text-slate-400 uppercase font-bold mb-2 tracking-wider">Respuesta seleccionada:</p>
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-slate-800">
                                            {{ $aq->answer && $aq->answer->selectedOption ? $aq->answer->selectedOption->option_text : 'Sin respuesta' }}
                                        </span>
                                        @if($aq->answer && $aq->answer->score_obtained > 0)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                                <i class="fas fa-check mr-1"></i> Correcta (+{{ $aq->answer->score_obtained }} pts)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                                <i class="fas fa-times mr-1"></i> Incorrecta (0 pts)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="mb-6">
                                    <p class="text-xs text-slate-400 uppercase font-bold mb-2 pl-1 tracking-wider">Respuesta del estudiante:</p>
                                    <div class="bg-white p-5 rounded-xl border border-gray-200 text-slate-700 shadow-inner whitespace-pre-wrap leading-relaxed">
                                        {{ $aq->answer ? $aq->answer->text_answer : 'Sin respuesta' }}
                                    </div>
                                </div>

                                <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100 shadow-sm relative overflow-hidden">
                                     <div class="absolute top-0 right-0 w-16 h-16 bg-blue-100/50 rounded-bl-full -mr-8 -mt-8"></div>
                                    <h4 class="text-sm font-bold text-[#335A92] mb-4 flex items-center relative z-10"><i class="fas fa-marker mr-2"></i> Evaluación del Profesor</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 mb-2">Puntaje Assigando</label>
                                            <div class="relative">
                                                <input type="number" step="0.01" max="{{ $aq->max_score }}" wire:model.defer="grades.{{ $aq->answer->id }}" 
                                                    class="w-full bg-white border {{ $errors->has('grades.'.$aq->answer->id) ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-slate-800 focus:ring-[#335A92] focus:border-[#335A92] transition-colors shadow-sm">
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-slate-400 sm:text-sm font-medium">pts / {{ number_format($aq->max_score, 2) }}</span>
                                                </div>
                                            </div>
                                            @error('grades.'.$aq->answer->id)
                                                <p class="mt-1 text-xs text-red-500 font-bold flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 mb-2">Retroalimentación (Opcional)</label>
                                            <input type="text" wire:model.defer="feedbacks.{{ $aq->answer->id }}" 
                                                class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-slate-800 focus:ring-[#335A92] focus:border-[#335A92] transition-colors shadow-sm" 
                                                placeholder="Escribe un comentario...">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-8 border-t border-gray-100 bg-white rounded-b-3xl">
                @if (session()->has('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center shadow-sm">
                        <i class="fas fa-exclamation-triangle mr-3 text-xl text-red-500"></i>
                        <div>
                            <span class="font-bold block">No se pudo guardar la revisión:</span>
                            <span class="text-sm">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                
                <div class="flex justify-between items-center">
                    <button wire:click="cancel" class="text-slate-500 hover:text-slate-700 font-medium text-sm underline decoration-slate-300 underline-offset-4 transition-colors">Cancelar y volver</button>
                    
                    <button wire:click="saveGrading" class="px-8 py-3 bg-[#ECBD2D] hover:bg-yellow-400 text-[#335A92] rounded-xl font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center border border-yellow-400">
                        <i class="fas fa-check-double mr-2"></i> Confirmar Revisión
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
