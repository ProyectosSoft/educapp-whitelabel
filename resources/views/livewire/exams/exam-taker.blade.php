<div class="w-full relative z-10 font-['Inter',sans-serif] pt-2 md:pt-6 pb-12">
    {{-- Anti-cheat Watermark Background --}}
    <div class="fixed inset-0 pointer-events-none z-[100] overflow-hidden flex flex-wrap content-center justify-center opacity-[0.03] select-none" aria-hidden="true">
        @for ($i = 0; $i < 50; $i++)
            <div class="whitespace-nowrap transform -rotate-12 text-slate-900 text-sm font-black p-16 tracking-widest leading-loose">
                {{ auth()->user()->name }} &bull; 
                {{ auth()->user()->email }} &bull; 
                {{ now()->format('d/m/Y H:i') }} &bull; 
                IP: {{ request()->ip() }}
            </div>
        @endfor
    </div>

    {{-- Header Section Outside Card --}}
    <div class="text-center mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-[#28487d] tracking-tight leading-tight mb-1">{{ $evaluation->exam->name }}</h1>
        <p class="text-sm md:text-base text-[#466fa8] font-semibold">{{ $evaluation->name }}</p>
    </div>

    <div class="max-w-4xl mx-auto w-full px-4 sm:px-0">
        
        {{-- Alerts --}}
        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4 shadow-sm flex items-center font-medium animate-shake text-sm">
                <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-red-500 mr-3 shrink-0"><i class="fas fa-exclamation-triangle text-xs"></i></div>
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('message'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-4 shadow-sm flex items-center font-medium text-sm">
                <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-500 mr-3 shrink-0"><i class="fas fa-check-circle text-xs"></i></div>
                {{ session('message') }}
            </div>
        @endif

        {{-- State 1: Before Starting --}}
        @if (!$currentAttempt)
            <div class="rounded-2xl bg-white shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                <div class="p-6 md:p-8 border-b border-gray-100 bg-white text-center">
                    <h2 class="text-2xl font-black text-[#28487d] tracking-tight">Reglas de la Evaluación</h2>
                    <p class="text-gray-500 font-medium text-sm mt-1">Lee atentamente estas indicaciones antes de comenzar.</p>
                </div>

                <div class="p-6 md:p-8 bg-gray-50/50">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500 shrink-0"><i class="fas fa-stopwatch text-lg"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Duración Máxima</p>
                                <p class="font-black text-[#28487d] text-base leading-none mt-1">{{ $evaluation->time_limit_minutes ?? 'Ilimitado' }} min</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-500 shrink-0"><i class="fas fa-sync-alt text-lg"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Intentos Permitidos</p>
                                <p class="font-black text-[#28487d] text-base leading-none mt-1">{{ $evaluation->max_attempts }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-yellow-100 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center text-yellow-600 shrink-0"><i class="fas fa-award text-lg"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-yellow-600 uppercase tracking-widest">Aprobación Mínima</p>
                                <p class="font-black text-[#28487d] text-base leading-none mt-1">{{ $evaluation->passing_score }}%</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-500 shrink-0"><i class="fas fa-hourglass-half text-lg"></i></div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Espera por Intento</p>
                                <p class="font-black text-[#28487d] text-base leading-none mt-1">{{ $evaluation->wait_time_minutes }} min</p>
                            </div>
                        </div>
                    </div>

                    {{-- Warning Banner --}}
                    <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-6 text-center">
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <i class="fas fa-shield-alt text-lg text-red-500"></i>
                            <h4 class="font-bold text-red-800 text-sm">Sistema Anti-Copia Activado</h4>
                        </div>
                        <p class="text-xs text-red-700/80 font-medium max-w-2xl mx-auto leading-relaxed">
                            Prohibido cambiar pestaña, minimizar, usar clic derecho o atajos (Copiar/Pegar). <strong>Cualquier infracción anulará automáticamente tu intento con calificación 0.</strong>
                        </p>
                    </div>

                    <div class="text-center">
                        <button wire:click="startAttempt" wire:loading.attr="disabled" class="group w-full sm:w-auto inline-flex items-center justify-center px-10 py-3 bg-[#28487d] hover:bg-[#1d355e] rounded-xl text-white font-bold text-base shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove class="flex items-center">
                                Entendido, Iniciar Evaluación
                            </span>
                            
                            <span wire:loading class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Cargando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>

        {{-- State 2: Taking the Exam --}}
        @elseif ($currentAttempt->status === 'in_progress')
            @php
                $questionList = collect($questions)->values();
                $totalQuestions = $questionList->count();
                $currentQuestion = $questionList->get($currentQuestionIndex);
                $currentNumber = $currentQuestion ? ($currentQuestionIndex + 1) : 0;
                $progress = $totalQuestions > 0 ? round(($currentNumber / $totalQuestions) * 100) : 0;
                $unansweredCount = $this->unansweredCount;
                $canSubmit = $this->canSubmit;
            @endphp

            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 overflow-hidden">
                
                {{-- Progress Bar Header --}}
                <div class="px-6 py-5 md:px-8 border-b border-gray-100 bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-xs uppercase font-extrabold text-[#748eb5] tracking-widest block mb-1">Progreso</span>
                            <span class="text-lg md:text-xl font-black text-[#28487d] leading-none">Pregunta {{ $currentNumber }}/{{ $totalQuestions }}</span>
                        </div>

                        @if ($evaluation->time_limit_minutes)
                            <div class="rounded-full border border-gray-200 px-4 py-1.5 flex items-center gap-2 bg-white">
                                <i class="far fa-clock text-[#748eb5]"></i>
                                <span class="font-mono text-sm font-bold text-[#28487d] leading-none" 
                                      x-data="{ time: {{ $timeLeft }} }" 
                                      x-init="setInterval(() => { if (time > 0) time--; }, 1000)" 
                                      x-text="new Date(time * 1000).toISOString().substr(11, 8)"></span>
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-xs font-bold text-[#28487d]">{{ $progress }}%</span>
                            </div>
                        @endif
                    </div>

                    {{-- Thick Blue Progress Bar --}}
                    <div class="h-2.5 bg-[#e3e8f0] rounded-full w-full">
                        <div class="h-full bg-[#28487d] transition-all duration-500 ease-out rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>

                {{-- Question Canvas --}}
                <form id="exam-form" wire:submit.prevent="submit" class="p-6 md:p-8">
                    @if($currentQuestion)
                        <div class="mx-auto w-full">
                            
                            {{-- The Question Text with Round Circle --}}
                            <div class="flex items-start gap-4 mb-6">
                                <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-[#28487d] flex items-center justify-center text-white font-bold text-sm md:text-base shrink-0 border-4 border-white shadow-sm shadow-[#28487d]/30 mt-0.5">
                                    {{ $currentNumber }}
                                </div>
                                <h3 class="text-base md:text-lg font-bold text-gray-800 leading-snug pt-1 md:pt-1.5">
                                    {{ $currentQuestion->question->question_text }}
                                </h3>
                            </div>

                            {{-- The Answers --}}
                            @if ($currentQuestion->question->type === 'closed')
                                <div class="space-y-3 pl-0 md:pl-14">
                                    @foreach ($currentQuestion->shownOptions as $optObj)
                                        <label class="group relative flex items-center px-4 py-3 cursor-pointer rounded-xl border {{ isset($answers[$currentQuestion->id]) && $answers[$currentQuestion->id] == $optObj->option->id ? 'border-[#28487d] bg-[#f4f7f9]' : 'border-gray-200 bg-white hover:border-[#aebcd0]' }} transition-all duration-200">
                                            
                                            <input type="radio"
                                                   name="question_{{ $currentQuestion->id }}"
                                                   wire:model="answers.{{ $currentQuestion->id }}"
                                                   value="{{ $optObj->option->id }}"
                                                   class="peer sr-only">
                                            
                                            {{-- Custom Clean Radio Outline --}}
                                            <div class="w-5 h-5 rounded-full border-[1.5px] mr-3 flex items-center justify-center shrink-0 
                                                {{ isset($answers[$currentQuestion->id]) && $answers[$currentQuestion->id] == $optObj->option->id 
                                                   ? 'border-[#28487d]' 
                                                   : 'border-gray-300' }} transition-colors bg-white">
                                                @if(isset($answers[$currentQuestion->id]) && $answers[$currentQuestion->id] == $optObj->option->id)
                                                    <div class="w-2.5 h-2.5 rounded-full bg-[#28487d]"></div>
                                                @endif
                                            </div>

                                            <span class="text-sm md:text-base text-gray-600 font-medium peer-checked:text-[#28487d] peer-checked:font-bold transition-colors">
                                                {{ $optObj->option->option_text }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="relative group pl-0 md:pl-14">
                                    <textarea wire:model.debounce.300ms="answers.{{ $currentQuestion->id }}"
                                              rows="5"
                                              class="w-full rounded-xl border border-gray-200 bg-white p-4 text-gray-800 focus:border-[#28487d] focus:ring-0 transition-all font-medium resize-none text-sm"
                                              placeholder="Escribe tu respuesta..."></textarea>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Navigation Footer (Tight) --}}
                    <div class="mt-8 pt-5 border-t border-gray-100 flex items-center justify-between gap-4">
                        {{-- Previous --}}
                        <div class="flex-1 md:flex-none">
                            <button type="button"
                                    wire:click="previousQuestion"
                                    class="{{ $currentQuestionIndex <= 0 ? 'invisible' : '' }} px-4 py-2.5 rounded-lg font-bold border border-gray-200 text-[#466fa8] bg-white hover:bg-gray-50 hover:text-[#28487d] transition-all flex items-center justify-center text-xs md:text-sm w-full md:w-auto shadow-sm">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                        </div>

                        {{-- Center Indicator --}}
                        <span class="text-[#466fa8] font-bold text-xs md:text-sm hidden md:block">Pregunta {{ $currentNumber }} de {{ $totalQuestions }}</span>

                        {{-- Next / Submit --}}
                        <div class="flex-1 md:flex-none">
                            @if($currentQuestionIndex < $totalQuestions - 1)
                                <button type="button"
                                        wire:click="nextQuestion"
                                        class="px-5 py-2.5 rounded-lg font-bold text-white bg-[#28487d] hover:bg-[#1d355e] transition-all flex items-center justify-center text-xs md:text-sm shadow-sm w-full md:w-auto">
                                    Siguiente <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            @else
                                <button type="button"
                                        @if(!$canSubmit) disabled @endif
                                        class="px-5 py-2.5 rounded-lg font-bold text-white transition-all flex items-center justify-center text-xs md:text-sm shadow-sm w-full md:w-auto
                                            {{ $canSubmit ? 'bg-[#ECBD2D] hover:bg-[#d6a928] text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed shadow-none' }}"
                                        @if($canSubmit) onclick="confirmSubmission()" @endif>
                                    @if($canSubmit)
                                        Enviar <i class="fas fa-paper-plane ml-2"></i>
                                    @else
                                        Faltan
                                    @endif
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        @else
            {{-- Loading State --}}
            <div class="text-center bg-white rounded-2xl p-8 shadow-xl shadow-gray-200/50 flex flex-col items-center justify-center min-h-[300px]">
                <i class="fas fa-circle-notch fa-spin text-3xl text-[#28487d] mb-4"></i>
                <p class="text-sm font-bold text-gray-500">Sincronizando con el servidor...</p>
            </div>
        @endif
    </div>

    {{-- SweetAlert2 for Interactions --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Prevent selection globally from CSS too --}}
    <style>
        body {
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        input, textarea {
            -webkit-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
    </style>

    <script>
        function confirmSubmission() {
            Swal.fire({
                title: '¿Finalizar Evaluación?',
                text: 'Una vez enviada, no podrás modificar tus respuestas.',
                icon: 'warning',
                background: '#ffffff',
                color: '#1f2937',
                customClass: {
                    popup: 'rounded-2xl border border-gray-100 shadow-xl',
                    confirmButton: 'rounded-lg bg-[#28487d] font-bold px-5 py-2 border-none text-white',
                    cancelButton: 'rounded-lg bg-gray-100 text-gray-600 font-bold px-5 py-2 border-none hover:bg-gray-200'
                },
                showCancelButton: true,
                confirmButtonColor: '#28487d',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Sí, enviar respuestas',
                cancelButtonText: 'Revisar de nuevo'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Procesando...',
                        text: 'Tus respuestas están siendo calificadas.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    @this.call('submit');
                }
            })
        }

        // Sistema Anti-Cheat 
        document.addEventListener('livewire:load', function () {
            let isFailed = false;
            const failExam = (reason) => {
                if (isFailed) return;
                isFailed = true;

                Swal.fire({
                    title: '¡Acción Prohibida!',
                    text: 'Se detectó uso de técnicas prohibidas: ' + reason + '. \n\nTu evaluación ha sido anulada con calificación reprobatoria.',
                    icon: 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                }).then(() => {
                    @this.forceFail(reason);
                });

                setTimeout(() => {
                    @this.forceFail(reason);
                }, 3000);
            };

            document.addEventListener('contextmenu', event => event.preventDefault());

            document.addEventListener('keydown', function(e) {
                const isDevTools = e.keyCode === 123 || (e.ctrlKey && e.shiftKey && [73, 74, 67].includes(e.keyCode)) || (e.ctrlKey && e.keyCode === 85); 
                const isCopyPaste = (e.ctrlKey || e.metaKey) && ['c', 'v', 'x'].includes(e.key.toLowerCase());

                if (isDevTools) { e.preventDefault(); failExam('Uso de herramientas de desarrollador'); return false; }
                if (isCopyPaste && e.target.tagName !== 'TEXTAREA') { e.preventDefault(); failExam('Intento de Copiar/Pegar'); return false; }
            });

            ['cut', 'copy', 'paste'].forEach(evt => document.addEventListener(evt, e => {
                if(e.target.tagName !== 'TEXTAREA') { e.preventDefault(); failExam('Intento de ' + evt); }
            }));

            setInterval(() => {
                if (isFailed) return;
                const start = performance.now(); debugger; const end = performance.now();
                if (end - start > 100) failExam('Console o Debugger abierto');
            }, 1000);

            document.addEventListener('visibilitychange', () => { if (document.hidden) failExam('Salida de ventana'); });
            window.addEventListener('blur', () => failExam('Pérdida de enfoque'));
        });
    </script>
</div>
