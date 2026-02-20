<div class="space-y-6 font-sans text-slate-600">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-50 opacity-50 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-yellow-50 opacity-50 filter blur-3xl"></div>
        
        <div class="relative z-10 w-full md:w-auto">
             <h2 class="text-2xl md:text-3xl font-bold text-[#335A92] mb-2">
                <i class="fas fa-desktop mr-2 text-[#ECBD2D]"></i> Monitoreo: {{ $evaluation->name }}
            </h2>
            <p class="text-slate-500 text-base">Registro de estudiantes e intentos realizados.</p>
        </div>
        
        <div class="relative z-10 flex flex-wrap gap-3 justify-center md:justify-end items-center">
            <a href="{{ route('author.exams.manager') }}" class="px-5 py-2.5 bg-white text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm flex items-center justify-center border border-gray-200 shadow-sm">
                 <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
             <div class="relative">
                <input wire:model="search" type="text" placeholder="Buscar estudiante..." class="pl-10 pr-4 py-2.5 bg-slate-50 border border-gray-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#335A92] focus:border-transparent w-64 shadow-sm transition-all focus:bg-white">
                <i class="fas fa-search absolute left-3 top-3.5 text-slate-400"></i>
            </div>
        </div>
    </div>

    {{-- Students List --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        @if($students->isEmpty())
             <div class="text-center py-16">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <i class="fas fa-user-slash text-3xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Sin registros</h3>
                <p class="text-slate-500">Ningún estudiante ha realizado intentos en esta evaluación aún.</p>
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach($students as $student)
                    <div x-data="{ open: false }" class="group transition-colors hover:bg-slate-50">
                        {{-- Student Row Header --}}
                        <div class="p-6 cursor-pointer flex flex-col md:flex-row items-center justify-between gap-4" @click="open = !open">
                            <div class="flex items-center gap-4 w-full md:w-auto">
                                <img src="{{ $student->profile_photo_url }}" alt="{{ $student->name }}" class="w-12 h-12 rounded-full object-cover shadow-sm border-2 border-white">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-lg group-hover:text-[#335A92] transition-colors">{{ $student->name }}</h3>
                                    <p class="text-sm text-slate-500">{{ $student->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                                <div class="text-right">
                                    <span class="block text-[10px] uppercase text-slate-400 font-bold mb-1 tracking-wider">Intentos</span>
                                    <span class="font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded-full text-sm">{{ $student->examAttempts->count() }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[10px] uppercase text-slate-400 font-bold mb-1 tracking-wider">Mejor Nota</span>
                                     @php $maxScore = $student->examAttempts->max('final_score'); @endphp
                                    <span class="font-bold text-lg {{ $maxScore >= $evaluation->passing_score ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ $maxScore ?? '-' }}%
                                    </span>
                                </div>
                                <div class="text-right text-slate-300 group-hover:text-[#335A92] transition-colors p-2">
                                    <i class="fas fa-chevron-down transform transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Attempts Detail (Collapsed) --}}
                        <div x-show="open" x-collapse class="bg-slate-50/50 border-t border-gray-100 px-6 py-6 shadow-inner">
                            <h4 class="text-xs font-bold uppercase text-[#335A92] mb-4 tracking-wider flex items-center gap-2">
                                <i class="fas fa-history"></i> Historial de Intentos
                            </h4>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-gray-50 text-slate-500 border-b border-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 font-bold">#</th>
                                            <th class="py-3 px-4 font-bold">Inicio</th>
                                            <th class="py-3 px-4 font-bold">Fin</th>
                                            <th class="py-3 px-4 font-bold">IP</th>
                                            <th class="py-3 px-4 font-bold">Duración</th>
                                            <th class="py-3 px-4 font-bold">Nota</th>
                                            <th class="py-3 px-4 text-right font-bold">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($student->examAttempts as $attempt)
                                            <tr class="hover:bg-blue-50/30 transition-colors">
                                                <td class="py-3 px-4 font-bold text-[#335A92]">Intento {{ $attempt->attempt_number }}</td>
                                                <td class="py-3 px-4 text-slate-600">{{ $attempt->started_at ? $attempt->started_at->format('d/m/Y H:i') : '-' }}</td>
                                                <td class="py-3 px-4 text-slate-600">{{ $attempt->completed_at ? $attempt->completed_at->format('d/m/Y H:i') : 'En curso...' }}</td>
                                                <td class="py-3 px-4 font-mono text-xs text-slate-400">{{ $attempt->ip_address ?? 'N/A' }}</td>
                                                <td class="py-3 px-4 text-slate-600">
                                                    @if($attempt->started_at && $attempt->completed_at)
                                                        {{ $attempt->started_at->diff($attempt->completed_at)->format('%Hh %Im %Ss') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $attempt->final_score >= $evaluation->passing_score ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $attempt->final_score }}%
                                                    </span>
                                                    @if($attempt->invalidation_reason)
                                                        <div class="mt-1 text-xs text-red-500 font-medium flex items-center gap-1">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                            <span>Invalidado</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button wire:click="viewAttempt({{ $attempt->id }})" class="text-[#335A92] hover:text-blue-800 font-bold text-xs bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors border border-blue-100">
                                                            Ver Detalles
                                                        </button>
                                                        <button wire:click="deleteAttempt({{ $attempt->id }})" 
                                                                onclick="confirm('¿Estás seguro de eliminar este intento? El estudiante podrá volver a presentar la evaluación.') || event.stopImmediatePropagation()"
                                                                class="text-red-500 hover:text-red-700 font-medium text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors border border-red-100"
                                                                title="Eliminar Intento">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-4 border-t border-gray-100 bg-slate-50">
                {{ $students->links() }}
            </div>
        @endif
    </div>

    {{-- Attempt Detail Modal --}}
    @if($viewingAttempt)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl relative my-8 border border-gray-100 flex flex-col max-h-[90vh]" @click.away="$wire.closeAttemptView()">
                 <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-slate-50 rounded-t-2xl">
                    <div class="flex items-center gap-4">
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                            <i class="fas fa-file-signature text-2xl text-[#335A92]"></i>
                        </div>
                        <div>
                             <h3 class="text-xl font-bold text-[#335A92]">Detalle de Respuestas</h3>
                             <p class="text-sm text-slate-500 font-medium">Intento #{{ $viewingAttempt->attempt_number }} <span class="mx-2">•</span> <span class="text-slate-700 font-bold">{{ $viewingAttempt->user->name }}</span></p>
                        </div>
                    </div>
                    
                    <button wire:click="closeAttemptView" class="text-slate-400 hover:text-slate-600 bg-white p-2 rounded-lg hover:bg-slate-100 transition shadow-sm border border-gray-100">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                 </div>
                 
                 <div class="p-8 overflow-y-auto flex-1 bg-slate-50/30 space-y-8">
                     @php
                        $groupedQuestions = $viewingAttempt->attemptQuestions->groupBy('question.category_id');
                        $categoryWeights = $viewingAttempt->evaluation->categories->pluck('pivot.weight_percent', 'id');
                     @endphp

                     @foreach($groupedQuestions as $categoryId => $questions)
                        @php
                            $categoryName = $questions->first()->question->category->name ?? 'General';
                            $categoryMaxScore = $questions->sum('max_score');
                            $categoryObtainedScore = $questions->sum(function($q) {
                                return $q->answers->first()->score_obtained ?? 0;
                            });
                            $categoryPercentage = $categoryMaxScore > 0 ? ($categoryObtainedScore / $categoryMaxScore) * 100 : 0;
                            $weight = $categoryWeights[$categoryId] ?? 0;
                            $contributionToTotal = ($categoryPercentage * $weight) / 100;
                        @endphp

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            {{-- Category Header --}}
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 bg-gradient-to-r from-slate-50 to-white border-b border-gray-100">
                                <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-[#335A92]">
                                        <i class="fas fa-layer-group text-sm"></i>
                                    </span>
                                    {{ $categoryName }}
                                    <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded ml-2">Peso: {{ $weight }}%</span>
                                </h4>
                                <div class="flex items-center gap-2 text-sm">
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 rounded-lg text-[#335A92] border border-blue-100">
                                        <span class="font-medium">Desempeño:</span>
                                        <strong class="text-lg">{{ round($categoryPercentage, 0) }}%</strong>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-green-50 rounded-lg text-green-700 border border-green-100" title="Aporte al puntaje total">
                                        <span class="font-medium">Aporte:</span>
                                        <strong class="text-lg">+{{ round($contributionToTotal, 2) }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 space-y-6">
                                @foreach($questions as $aq)
                                    @php
                                        $globalIndex = $viewingAttempt?->attemptQuestions?->search(function($item) use ($aq) {
                                            return $item->id === $aq->id;
                                        }) ?: 0;
                                    @endphp
                                    <div class="relative pl-0 md:pl-4">
                                        {{-- Connector Line --}}
                                        @if(!$loop->last)
                                            <div class="absolute left-[27px] top-10 bottom-0 w-0.5 bg-gray-100 hidden md:block"></div>
                                        @endif

                                        <div class="flex gap-4">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-white border-2 border-slate-100 flex items-center justify-center text-sm font-bold text-slate-400 z-10 shadow-sm hidden md:flex">
                                                {{ $globalIndex + 1 }}
                                            </div>
                                            <div class="flex-1 bg-slate-50/50 rounded-xl p-5 border border-gray-100 hover:border-gray-200 transition-colors">
                                                <div class="text-slate-800 font-bold text-base mb-4 leading-relaxed">
                                                    {{ $aq->question->question_text }}
                                                </div>
                                                
                                                {{-- User Answer Section --}}
                                                <div class="space-y-3">
                                                    @php
                                                        $userAnswer = $aq->answers->first();
                                                        $isCorrect = $userAnswer && $userAnswer->score_obtained > 0;
                                                    @endphp

                                                    @if($aq->question->type === 'closed')
                                                        @if($userAnswer && $userAnswer->option)
                                                            <div class="p-4 rounded-xl flex items-center justify-between border {{ $isCorrect ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800' }} relative overflow-hidden">
                                                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $isCorrect ? 'bg-green-400' : 'bg-red-400' }}"></div>
                                                                <div class="flex items-start gap-3 pl-2">
                                                                    <div class="mt-0.5 text-lg">
                                                                        @if($isCorrect)
                                                                            <i class="fas fa-check-circle text-green-500"></i>
                                                                        @else
                                                                            <i class="fas fa-times-circle text-red-500"></i>
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-[10px] font-bold uppercase opacity-60 mb-0.5 tracking-wider">Tu Respuesta</span>
                                                                        <span class="text-base font-bold">{{ $userAnswer->option->option_text }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="hidden sm:block">
                                                                     <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm {{ $isCorrect ? 'bg-white text-green-700' : 'bg-white text-red-700' }}">
                                                                        {{ $isCorrect ? 'Correcta' : 'Incorrecta' }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="p-4 bg-gray-100 text-slate-500 rounded-xl border-2 border-dashed border-gray-200 flex items-center gap-3">
                                                                <i class="fas fa-minus-circle"></i>
                                                                <span class="font-medium">Sin respuesta seleccionada</span>
                                                            </div>
                                                        @endif
                                                        
                                                        @if(!$isCorrect)
                                                            @php
                                                                $correctOpt = $aq->question->options()->where('is_correct', true)->first();
                                                            @endphp
                                                            @if($correctOpt)
                                                                <div class="mt-2 p-3 pl-4 rounded-lg bg-emerald-50/50 border border-emerald-100 text-emerald-800 flex items-start gap-3">
                                                                    <div class="mt-1 text-emerald-500">
                                                                        <i class="fas fa-key"></i>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-[10px] font-bold uppercase text-emerald-600 mb-0.5 tracking-wider">Solución Correcta</span>
                                                                        <span class="text-sm font-bold">{{ $correctOpt->option_text }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                                
                                                 <div class="mt-4 flex justify-end">
                                                    <span class="text-xs font-bold px-3 py-1.5 rounded-lg border {{ $isCorrect ? 'bg-green-50 border-green-100 text-green-700' : 'bg-gray-50 border-gray-100 text-gray-500' }}">
                                                        Puntaje: {{ $userAnswer->score_obtained ?? 0 }} pts
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                     @endforeach
                 </div>
                 
                 <div class="p-6 border-t border-gray-100 bg-white rounded-b-2xl">
                     <button wire:click="closeAttemptView" class="w-full py-3.5 bg-[#335A92] hover:bg-[#2a4a78] text-white font-bold rounded-xl transition shadow-md hover:shadow-lg transform active:scale-[0.99]">Cerrar Detalle</button>
                 </div>
            </div>
        </div>
    @endif
</div>
@push('js')
<script>
    // Optional: Add listeners if needed
</script>
@endpush
