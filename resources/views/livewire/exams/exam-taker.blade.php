<div class="min-h-screen bg-[#eef4fb] text-[#1f2937] font-sans py-8 px-4 sm:px-6 lg:px-8 relative">
    <div class="fixed inset-0 pointer-events-none z-[100] overflow-hidden flex flex-wrap content-center justify-center opacity-10 select-none" aria-hidden="true">
        @for ($i = 0; $i < 50; $i++)
            <div class="whitespace-nowrap transform -rotate-12 text-slate-500 text-sm font-bold p-16">
                {{ auth()->user()->name }} <br>
                {{ auth()->user()->email }} <br>
                {{ now()->format('d/m/Y H:i') }} <br>
                {{ request()->ip() }}
            </div>
        @endfor
    </div>

    <div class="max-w-5xl mx-auto relative z-10">
        <div class="mb-6 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#335A92] mb-1 tracking-tight">{{ $evaluation->exam->name }}</h1>
            <p class="text-lg text-[#477EB1] font-medium">{{ $evaluation->name }}</p>
        </div>

        @if (session()->has('error'))
            <div class="bg-red-50 border border-[#FC0B29]/40 text-[#a80720] px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('message'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-700 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('message') }}
            </div>
        @endif

        @if (!$currentAttempt)
            <div class="rounded-3xl border border-[#c9d8ea] bg-white shadow-xl shadow-[#335A92]/10 overflow-hidden">
                <div class="bg-gradient-to-r from-[#335A92] to-[#477EB1] p-7 text-white">
                    <h2 class="text-2xl font-extrabold">Información de la Evaluación</h2>
                    <p class="text-blue-100 mt-1">Revisa las condiciones antes de iniciar.</p>
                </div>

                <div class="p-7 grid grid-cols-1 md:grid-cols-2 gap-4 text-[#335A92]">
                    <div class="rounded-xl border border-[#d7e4f2] bg-[#f6faff] p-4">
                        <p class="text-xs uppercase font-bold text-[#477EB1]">Duración Máxima</p>
                        <p class="font-extrabold text-xl mt-1">{{ $evaluation->time_limit_minutes ?? 'Ilimitado' }} min</p>
                    </div>
                    <div class="rounded-xl border border-[#d7e4f2] bg-[#f6faff] p-4">
                        <p class="text-xs uppercase font-bold text-[#477EB1]">Intentos Permitidos</p>
                        <p class="font-extrabold text-xl mt-1">{{ $evaluation->max_attempts }}</p>
                    </div>
                    <div class="rounded-xl border border-[#d7e4f2] bg-[#f6faff] p-4">
                        <p class="text-xs uppercase font-bold text-[#477EB1]">Puntaje para Aprobar</p>
                        <p class="font-extrabold text-xl mt-1">{{ $evaluation->passing_score }}%</p>
                    </div>
                    <div class="rounded-xl border border-[#ECBD2D]/40 bg-[#fff8e3] p-4">
                        <p class="text-xs uppercase font-bold text-[#8a6d09]">Espera entre intentos</p>
                        <p class="font-extrabold text-xl mt-1 text-[#8a6d09]">{{ $evaluation->wait_time_minutes }} min</p>
                    </div>
                </div>

                <div class="px-7 pb-8 text-center">
                    <button wire:click="startAttempt" wire:loading.attr="disabled" class="px-8 py-3 bg-gradient-to-r from-[#335A92] to-[#477EB1] hover:from-[#2c4d7f] hover:to-[#3d6fa0] rounded-xl text-white font-extrabold text-lg shadow-lg shadow-[#335A92]/20 transition disabled:opacity-50">
                        <span wire:loading.remove>Iniciar Evaluación</span>
                        <span wire:loading class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Iniciando...
                        </span>
                    </button>
                </div>
            </div>
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

            <div class="rounded-3xl border border-[#c9d8ea] bg-white shadow-xl shadow-[#335A92]/10 overflow-hidden">
                <div class="p-6 md:p-7 border-b border-[#dbe7f4] bg-[#f8fbff]">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-[#477EB1] text-sm font-bold uppercase tracking-wider">Progreso</p>
                            <p class="text-[#335A92] text-xl font-extrabold">Pregunta {{ $currentNumber }}/{{ $totalQuestions }}</p>
                        </div>

                        @if($evaluation->time_limit_minutes)
                            <div class="inline-flex items-center rounded-full border border-[#477EB1]/30 bg-white px-4 py-2 text-[#335A92] font-mono font-bold">
                                <svg class="w-5 h-5 mr-2 text-[#477EB1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span x-data="{ time: {{ $timeLeft }} }" x-init="
                                    setInterval(() => {
                                        if (time > 0) time--;
                                    }, 1000)
                                " x-text="new Date(time * 1000).toISOString().substr(11, 8)"></span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <div class="h-2 bg-[#dbe7f4] rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-[#335A92] to-[#477EB1] transition-all duration-300" style="width: {{ $progress }}%"></div>
                        </div>
                        <p class="mt-3 text-sm font-semibold {{ $unansweredCount > 0 ? 'text-[#FC0B29]' : 'text-emerald-700' }}">
                            @if($unansweredCount > 0)
                                Tienes {{ $unansweredCount }} pregunta(s) sin responder.
                            @else
                                Todas las preguntas están respondidas.
                            @endif
                        </p>
                    </div>
                </div>

                <form id="exam-form" wire:submit.prevent="submit" class="p-6 md:p-8">
                    @if($currentQuestion)
                        <div class="rounded-2xl border border-[#dbe7f4] bg-white p-5 md:p-6">
                            <div class="flex items-start gap-3 mb-5">
                                <span class="flex-shrink-0 w-9 h-9 rounded-full bg-[#335A92] text-white font-extrabold flex items-center justify-center">{{ $currentNumber }}</span>
                                <h3 class="text-lg md:text-xl leading-snug font-bold text-[#1f2f45]">{{ $currentQuestion->question->question_text }}</h3>
                            </div>

                            @if ($currentQuestion->question->type === 'closed')
                                <div class="space-y-3">
                                    @foreach ($currentQuestion->shownOptions as $optObj)
                                        <label class="flex items-start gap-3 cursor-pointer rounded-xl border border-[#dbe7f4] bg-[#f8fbff] p-4 hover:bg-[#eef4fb] transition">
                                            <input type="radio"
                                                   name="question_{{ $currentQuestion->id }}"
                                                   wire:model="answers.{{ $currentQuestion->id }}"
                                                   value="{{ $optObj->option->id }}"
                                                   class="mt-1 h-5 w-5 text-[#335A92] border-[#9db7d5] focus:ring-[#477EB1]">
                                            <span class="text-[#2b4263] font-medium">{{ $optObj->option->option_text }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <textarea wire:model.debounce.300ms="answers.{{ $currentQuestion->id }}"
                                          rows="7"
                                          class="w-full rounded-xl border-[#c9d8ea] bg-[#f8fbff] text-[#1f2f45] focus:border-[#477EB1] focus:ring-[#477EB1]"
                                          placeholder="Escribe tu respuesta aquí..."></textarea>
                            @endif
                        </div>
                    @endif

                    <div class="mt-6 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                        <button type="button"
                                wire:click="previousQuestion"
                                {{ $currentQuestionIndex <= 0 ? 'disabled' : '' }}
                                class="px-5 py-3 rounded-xl font-bold border border-[#c9d8ea] text-[#335A92] bg-white hover:bg-[#f4f8fd] disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-arrow-left mr-2"></i>Anterior
                        </button>

                        <div class="text-sm font-semibold text-[#477EB1] text-center">Pregunta {{ $currentNumber }} de {{ $totalQuestions }}</div>

                        @if($currentQuestionIndex < $totalQuestions - 1)
                            <button type="button"
                                    wire:click="nextQuestion"
                                    class="px-5 py-3 rounded-xl font-bold text-white bg-gradient-to-r from-[#335A92] to-[#477EB1] hover:from-[#2c4d7f] hover:to-[#3d6fa0]">
                                Siguiente<i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        @else
                            <button type="button"
                                    @if(!$canSubmit) disabled @endif
                                    class="px-6 py-3 rounded-xl font-extrabold text-white {{ $canSubmit ? 'bg-[#ECBD2D] hover:bg-[#d9ab1f]' : 'bg-slate-300 cursor-not-allowed' }}"
                                    @if($canSubmit) onclick="confirmSubmission()" @endif>
                                Enviar Respuestas
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        @else
            <div class="text-center text-[#335A92]">
                <p>Cargando estado...</p>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        input,
        textarea {
            -webkit-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
    </style>

    <script>
        function confirmSubmission() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Estás a punto de finalizar tu evaluación. Asegúrate de haber revisado tus respuestas.',
                icon: 'question',
                background: '#ffffff',
                color: '#1f2f45',
                customClass: {
                    popup: 'rounded-3xl border border-[#c9d8ea] shadow-2xl'
                },
                showCancelButton: true,
                confirmButtonColor: '#335A92',
                cancelButtonColor: '#FC0B29',
                confirmButtonText: 'Sí, enviar respuestas',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('submit');
                }
            })
        }

        document.addEventListener('livewire:load', function () {
            let isFailed = false;
            const failExam = (reason) => {
                if (isFailed) return;
                isFailed = true;

                Swal.fire({
                    title: '¡Acción Prohibida Detectada!',
                    text: 'Se ha detectado un intento de uso de herramientas prohibidas (' + reason + '). La evaluación se anulará inmediatamente.',
                    icon: 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                }).then(() => {
                    @this.forceFail(reason);
                });

                setTimeout(() => {
                    @this.forceFail(reason);
                }, 2000);
            };

            document.addEventListener('contextmenu', event => {
                event.preventDefault();
            });

            document.addEventListener('keydown', function(e) {
                const isDevTools =
                    e.keyCode === 123 ||
                    (e.ctrlKey && e.shiftKey && [73, 74, 67].includes(e.keyCode)) ||
                    (e.metaKey && e.altKey && [73, 74, 67].includes(e.keyCode)) ||
                    (e.ctrlKey && e.keyCode === 85);

                const isCopyPaste =
                    (e.ctrlKey && ['c', 'v', 'x'].includes(e.key.toLowerCase())) ||
                    (e.metaKey && ['c', 'v', 'x'].includes(e.key.toLowerCase()));

                if (isDevTools) {
                    e.preventDefault();
                    failExam('Uso de atajos de desarrollador');
                    return false;
                }

                if (isCopyPaste) {
                    e.preventDefault();
                    failExam('Intento de Copiar/Pegar');
                    return false;
                }
            });

            ['cut', 'copy', 'paste'].forEach(evt => {
                document.addEventListener(evt, e => {
                    e.preventDefault();
                    failExam('Intento de ' + evt);
                });
            });

            setInterval(function() {
                if (isFailed) return;

                const start = performance.now();
                debugger;
                const end = performance.now();

                if (end - start > 100) {
                    failExam('Herramientas de Desarrollador detectadas (Debugger)');
                }
            }, 1000);

            let devtools = function() {};
            devtools.toString = function() {
                failExam('Herramientas de Desarrollador detectadas (Console)');
                return 'Status';
            }

            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    failExam('Cambio de pestaña / ventana detectado');
                }
            });

            window.addEventListener('blur', function() {
                failExam('Pérdida de foco de la ventana (Salida del examen)');
            });
        });
    </script>
</div>
