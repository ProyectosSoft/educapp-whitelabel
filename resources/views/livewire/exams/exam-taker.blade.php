<div class="min-h-screen bg-gray-900 text-white font-sans py-12 px-4 sm:px-6 lg:px-8 relative">
    
    <!-- Security Watermark -->
    <div class="fixed inset-0 pointer-events-none z-[100] overflow-hidden flex flex-wrap content-center justify-center opacity-10 select-none" aria-hidden="true">
        @for ($i = 0; $i < 50; $i++)
            <div class="whitespace-nowrap transform -rotate-12 text-gray-400 text-sm font-bold p-16">
                {{ auth()->user()->name }} <br> 
                {{ auth()->user()->email }} <br> 
                {{ now()->format('d/m/Y H:i') }} <br>
                {{ request()->ip() }}
            </div>
        @endfor
    </div>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-2">
                {{ $evaluation->exam->name }}
            </h1>
            <p class="text-xl text-gray-400">{{ $evaluation->name }}</p>
        </div>

        @if (session()->has('error'))
            <div class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm shadow-lg flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('message'))
            <div class="bg-green-500/20 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm shadow-lg flex items-center">
                 <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('message') }}
            </div>
        @endif

        @if (!$currentAttempt)
            <!-- Start Screen -->
            <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-6 text-white border-b border-gray-700 pb-2">Información de la Evaluación</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-300">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-blue-600/20 rounded-lg text-blue-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Duración Máxima</p>
                                <p class="font-semibold text-lg">{{ $evaluation->time_limit_minutes ?? 'Ilimitado' }} min</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-purple-600/20 rounded-lg text-purple-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Intentos Permitidos</p>
                                <p class="font-semibold text-lg">{{ $evaluation->max_attempts }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-green-600/20 rounded-lg text-green-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Puntaje para Aprobar</p>
                                <p class="font-semibold text-lg">{{ $evaluation->passing_score }}%</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-yellow-600/20 rounded-lg text-yellow-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Espera entre intentos</p>
                                <p class="font-semibold text-lg">{{ $evaluation->wait_time_minutes }} min</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-10 text-center">
                        <button wire:click="startAttempt" wire:loading.attr="disabled" class="group relative px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-full text-white font-bold text-lg shadow-lg transform transition hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-500/30 disabled:opacity-50">
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
            </div>
        @elseif ($currentAttempt->status === 'in_progress')
            <!-- Taking Screen -->
            <div class="bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 p-6 md:p-8 relative">
                <!-- Timer -->
                @if($evaluation->time_limit_minutes)
                    <div class="fixed bottom-4 right-4 md:absolute md:top-4 md:right-4 z-50">
                        <div class="bg-gray-900/90 backdrop-blur border border-blue-500/30 rounded-full px-5 py-2 text-blue-400 font-mono text-lg shadow-xl flex items-center space-x-2">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             <span x-data="{ time: {{ $timeLeft }} }" x-init="
                                setInterval(() => {
                                    if(time > 0) time--;
                                }, 1000)
                             " x-text="
                                new Date(time * 1000).toISOString().substr(11, 8)
                             "></span>
                        </div>
                    </div>
                @endif

                <form id="exam-form" wire:submit.prevent="submit">
                    <div class="space-y-8 mt-6">
                        @foreach ($questions as $index => $aq)
                            <div class="bg-gray-700/30 p-6 rounded-xl border border-gray-600 hover:border-blue-500/50 transition-colors duration-300">
                                <div class="flex items-start">
                                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold mr-4 text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="w-full">
                                        <h3 class="text-lg font-medium text-white mb-4 leading-relaxed">
                                            {{ $aq->question->question_text }}
                                        </h3>
                                        
                                        @if ($aq->question->type === 'closed')
                                            <div class="space-y-3">
                                                @foreach ($aq->shownOptions as $optObj)
                                                    <label class="flex items-center space-x-3 cursor-pointer group p-4 rounded-lg bg-gray-800/50 border border-gray-700 hover:bg-gray-700 hover:border-blue-500 transition-all">
                                                        <input type="radio" name="question_{{ $aq->id }}" wire:model.defer="answers.{{ $aq->id }}" value="{{ $optObj->option->id }}" class="form-radio h-5 w-5 text-blue-500 border-gray-500 focus:ring-blue-500 bg-gray-800 checked:bg-blue-600">
                                                        <span class="text-gray-300 group-hover:text-white font-light">{{ $optObj->option->option_text }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <textarea wire:model.defer="answers.{{ $aq->id }}" rows="5" class="w-full bg-gray-800 text-white rounded-lg border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 mt-2 p-4" placeholder="Escribe tu respuesta detallada aquí..."></textarea>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
                
                <div class="mt-12 text-center pb-8">
                    <button type="button" 
                        class="px-10 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-full text-white font-bold text-lg shadow-lg transform transition hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-500/30" 
                        onclick="confirmSubmission()">
                        Enviar Respuestas
                    </button>
                </div>
            </div>
        @else
            <!-- Fallback/Loading state -->
            <div class="text-center text-gray-400">
                <p>Cargando estado...</p>
            </div>
        @endif
    </div>

</div>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                title: '¿Estás seguro?',
                text: "Estás a punto de finalizar tu evaluación. Asegúrate de haber revisado tus respuestas.",
                icon: 'question',
                background: '#1f2937', // matching bg-gray-800
                color: '#ffffff',
                customClass: {
                    popup: 'rounded-3xl border border-gray-700 shadow-2xl'
                },
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, enviar respuestas',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('submit');
                }
            })
        }

        document.addEventListener('livewire:load', function () {
            
            // --- Helper to trigger Fail ---
            let isFailed = false;
            const failExam = (reason) => {
                if(isFailed) return;
                isFailed = true;

                // Block UI immediately
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

                // Fail immediately in background
                setTimeout(() => {
                     @this.forceFail(reason);
                }, 2000);
            };

            // --- 1. Prevent Right Click ---
            document.addEventListener('contextmenu', event => {
                event.preventDefault();
                // We typically don't fail just for right click, just block it.
            });

            // --- 2. Prevent Shortcuts & Key Combos ---
            document.addEventListener('keydown', function(e) {
                // List of banned keys
                // F12 (123)
                // Ctrl+Shift+I (73), J (74), C (67)
                // Ctrl+U (85)
                // Mac Cmd+Option+I/J/C
                
                const isDevTools = 
                    e.keyCode === 123 || 
                    (e.ctrlKey && e.shiftKey && [73, 74, 67].includes(e.keyCode)) ||
                    (e.metaKey && e.altKey && [73, 74, 67].includes(e.keyCode)) ||
                    (e.ctrlKey && e.keyCode === 85);
                
                const isCopyPaste = 
                    (e.ctrlKey && ['c','v','x'].includes(e.key.toLowerCase())) ||
                    (e.metaKey && ['c','v','x'].includes(e.key.toLowerCase()));

                if (isDevTools) {
                    e.preventDefault();
                    failExam('Uso de atajos de desarrollador');
                    return false;
                }

                if (isCopyPaste) {
                    e.preventDefault();
                    // Optional: Fail on copy paste attempt or just block? 
                    // User request says: "Al hacer esto debe bloquearse... y generar mensaje... indicando la accion"
                    failExam('Intento de Copiar/Pegar');
                    return false;
                }
            });

            // --- 3. Prevent Cut/Copy/Paste events ---
            ['cut', 'copy', 'paste'].forEach(evt => {
                document.addEventListener(evt, e => {
                    e.preventDefault();
                    failExam('Intento de ' + evt);
                });
            });

            // --- 4. Advanced DevTools Detection (Debugger Trick) ---
            // This detects if DevTools is OPEN, regardless of how it was opened.
            // When DevTools is open, the debugger statement pauses execution. We measure that pause.
            setInterval(function() {
                if(isFailed) return;

                const start = performance.now();
                debugger; // This will pause if DevTools is open
                const end = performance.now();

                if (end - start > 100) { 
                    // If it took longer than 100ms, user likely had DevTools open
                    failExam('Herramientas de Desarrollador detectadas (Debugger)');
                }
            }, 1000);

            // --- 5. Inspect Element Detection via Console ID (Extra Layer) ---
            // Some browsers evaluate IDs in console.log
            let devtools = function() {};
            devtools.toString = function() {
                failExam('Herramientas de Desarrollador detectadas (Console)');
                return 'Status';
            }
            // console.log('%c', devtools); // Only uncomment if debugger trick isn't enough, can be noisy.

            
            // --- 6. Tab/Window Switching Detection ---
            // Detect if tab is hidden (switch tab)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    failExam('Cambio de pestaña / ventana detectado');
                }
            });

            // Detect if window loses focus (Alt+Tab or clicking outside)
            window.addEventListener('blur', function() {
                failExam('Pérdida de foco de la ventana (Salida del examen)');
            });

        });
    </script>
</div>
