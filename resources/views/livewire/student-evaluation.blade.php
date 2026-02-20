<div>
    <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="card-body p-6">
            @if(!$started && !$finished)
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-4">{{ $evaluation->name }}</h2>
                    <p class="text-gray-600 mb-6">{{ $evaluation->description }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 text-sm">
                        <div class="bg-gray-50 p-3 rounded">
                            <span class="font-bold block text-gray-700">Intentos permitidos</span>
                            <span class="text-gray-600">{{ $evaluation->max_attempts }}</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <span class="font-bold block text-gray-700">Puntaje para aprobar</span>
                            <span class="text-gray-600">{{ $evaluation->passing_score }}%</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <span class="font-bold block text-gray-700">Tiempo límite</span>
                            <span class="text-gray-600">{{ $evaluation->time_limit ? $evaluation->time_limit . ' minutos' : 'Sin límite' }}</span>
                        </div>
                    </div>

                    <button wire:click="start" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition duration-150">
                        Comenzar Evaluación
                    </button>
                </div>
            @elseif($started && !$finished)
                <div x-data="{
                        securityActive: false,
                        violationDetected: false,
                        timeLimit: {{ $evaluation->time_limit ? $evaluation->time_limit * 60 : 0 }},
                        timeLeft: 0,
                        timerInterval: null,
                        
                        init() {
                            this.timeLeft = this.timeLimit;
                            
                            // Activar seguridad después de 2 segundos
                            setTimeout(() => { this.securityActive = true; }, 2000);
                            
                            // Iniciar Timer si existe límite
                            if (this.timeLimit > 0) {
                                this.timerInterval = setInterval(() => {
                                    if (this.timeLeft > 0) {
                                        this.timeLeft--;
                                    } else {
                                        this.handleViolation('time_out');
                                    }
                                }, 1000);
                            }
                            
                            // Detectar cambio de pestaña/minimizado
                            document.addEventListener('visibilitychange', () => {
                                if (document.hidden) this.handleViolation('change_tab');
                            });

                            // Bloquear eventos de copiado/pegado/arrastre
                            ['copy', 'cut', 'paste', 'dragstart', 'drop'].forEach(evt => {
                                window.addEventListener(evt, e => e.preventDefault());
                            });

                            // Medida agresiva: Debugger loop para congelar DevTools si se abre
                            setInterval(() => {
                                const start = performance.now();
                                debugger; // Esto detiene la ejecución si DevTools está abierto
                                const end = performance.now();
                                if (end - start > 100) {
                                    // Si la ejecución se detuvo significativamente, DevTools probablemente estaba abierto
                                    this.handleViolation('devtools_debugger');
                                }
                            }, 1000);
                        },
                        checkKeys(e) {
                            // Bloquear F12 (DevTools)
                            if(e.key === 'F12' || e.keyCode === 123) { 
                                e.preventDefault(); 
                                e.stopPropagation();
                                return false; 
                            }
                            
                            // Bloquear Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C (DevTools)
                            if ((e.ctrlKey || e.metaKey) && e.shiftKey && ['i','j','c','k'].includes(e.key.toLowerCase())) {
                                e.preventDefault();
                                e.stopPropagation();
                                return false;
                            }
                            
                            // Bloquear Ctrl+U (Ver Código Fuente)
                            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'u') {
                                e.preventDefault();
                                e.stopPropagation();
                                return false;
                            }

                            // Bloquear Ctrl/Cmd + C, V, X, A, P (Copiar, Pegar, Cortar, Select All, Print)
                            if ((e.ctrlKey || e.metaKey) && ['c','v','x','a','p'].includes(e.key.toLowerCase())) {
                                e.preventDefault();
                                e.stopPropagation();
                                return false;
                            }
                        },
                        formatTime(seconds) {
                            const m = Math.floor(seconds / 60);
                            const s = seconds % 60;
                            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                        },
                        handleViolation(reason = 'general') {
                            if (!this.securityActive || this.violationDetected) return;
                            this.violationDetected = true;
                            if (this.timerInterval) clearInterval(this.timerInterval);
                            
                            console.log('Closing evaluation:', reason);

                            let title = '⚠️ Alerta de Seguridad';
                            let text = 'Se ha detectado un cambio de ventana o una acción no permitida.';
                            
                            if (reason === 'time_out') {
                                title = '⏰ Tiempo Agotado';
                                text = 'El tiempo límite para la evaluación ha finalizado.';
                            }

                            Swal.fire({
                                title: title,
                                text: text + ' La evaluación se cerrará automáticamente.',
                                icon: 'warning',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Entendido'
                            }).then((result) => {
                                @this.call('submit', reason);
                            });
                        }
                    }"
                    @keydown.window="checkKeys($event)"
                    @contextmenu.prevent.window="true"
                    @blur.window="handleViolation('window_blur')"
                >
                    <div class="flex justify-between items-center mb-6 pb-2 border-b">
                        <h3 class="text-xl font-bold">{{ $evaluation->name }}</h3>
                        <div x-show="timeLimit > 0" class="flex items-center space-x-2 text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-200" :class="{'text-red-700 bg-red-50 border-red-200': timeLeft < 60}">
                            <i class="fas fa-clock"></i>
                            <span x-text="formatTime(timeLeft)" class="font-mono font-bold text-lg"></span>
                        </div>
                    </div>
                    
                    <div class="space-y-8">
                        @foreach($questions as $index => $question)
                            @php
                                $questionObj = (object) $question;
                                $answers = (isset($questionObj->answers) && is_array($questionObj->answers)) ? collect($questionObj->answers) : $questionObj->answers;
                            @endphp
                            <div class="bg-gray-50 p-4 rounded-lg" wire:key="question-{{ $questionObj->id }}">
                                <p class="font-bold text-lg mb-4">{{ $index + 1 }}. {{ $questionObj->statement }}</p>
                                <div class="space-y-2 ml-4">
                                    @foreach($answers as $answer)
                                        @php $answer = (object) $answer; @endphp
                                        <label class="flex items-center space-x-3 cursor-pointer p-2 rounded hover:bg-gray-100 transition">
                                            <input type="radio" wire:model="userAnswers.{{ $questionObj->id }}" value="{{ $answer->id }}" class="form-radio h-5 w-5 text-indigo-600">
                                            <span class="text-gray-700">{{ $answer->text }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 text-right">
                        <button type="button" 
                                onclick="Swal.fire({
                                    title: '¿Estás seguro?',
                                    text: 'Una vez enviado no podrás modificar tus respuestas.',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, enviar respuestas',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        @this.call('submit');
                                    }
                                })"
                                class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition duration-150">
                            Enviar Respuestas
                        </button>

                    </div>
                </div>
            @elseif($finished)
                <div class="text-center py-8">
                    <div class="mb-6">
                        @if($passed)
                            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-4">
                                <i class="fas fa-check text-5xl text-green-600"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-green-600 mb-2">¡Felicidades!</h2>
                            <p class="text-gray-600 text-lg">Has aprobado la evaluación.</p>
                        @else
                            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100 mb-4">
                                <i class="fas fa-times text-5xl text-red-600"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-red-600 mb-2">Has reprobado</h2>
                            <p class="text-gray-600 text-lg">No has alcanzado el puntaje mínimo.</p>
                        @endif
                    </div>

                    <div class="text-4xl font-bold text-gray-800 mb-8">
                        {{ number_format($score, 0) }}%
                    </div>

                    <div class="flex justify-center space-x-4">
                        @if($passed)
                            @if($evaluation->course_id) {{-- Only for final exams linked to a course --}}
                                <a href="{{ route('certificates.download', ['attempt' => $attempt->id]) }}" target="_blank" class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-bold hover:bg-yellow-600 transition duration-150 flex items-center">
                                    <i class="fas fa-certificate mr-2"></i> Ver Certificado
                                </a>
                            @endif
                        @else
                            @if($attemptsCount < ($evaluation->max_attempts + $extraAttempts))
                                @if($secondsUntilNextAttempt > 0)
                                    <div x-data="{ 
                                            remaining: @entangle('secondsUntilNextAttempt'),
                                            formatTime(seconds) {
                                                if(seconds < 0) seconds = 0;
                                                const hours = Math.floor(seconds / 3600);
                                                const minutes = Math.floor((seconds % 3600) / 60);
                                                const secs = seconds % 60;
                                                return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                                            },
                                            init() {
                                                let timer = setInterval(() => {
                                                    if (this.remaining > 0) {
                                                        this.remaining--;
                                                    } else {
                                                        clearInterval(timer);
                                                    }
                                                }, 1000);
                                            }
                                         }" 
                                         class="mb-4">
                                        
                                        <div x-show="remaining > 0" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                                            <strong class="font-bold">¡Espera!</strong>
                                            <span class="block sm:inline">Debes esperar <span x-text="formatTime(remaining)" class="font-bold"></span> para tu próximo intento.</span>
                                        </div>

                                        <button x-show="remaining <= 0" wire:click="start" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition duration-150">
                                            Intentar de nuevo
                                        </button>
                                        
                                        <button x-show="remaining > 0" disabled class="bg-gray-400 text-white px-6 py-3 rounded-lg font-bold cursor-not-allowed">
                                            Intentar de nuevo
                                        </button>
                                    </div>
                                @else
                                    <button wire:click="start" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition duration-150">
                                        Intentar de nuevo
                                    </button>
                                @endif
                            @else
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                    <strong class="font-bold">¡Lo sentimos!</strong>
                                    <span class="block sm:inline">Has agotado el número máximo de intentos permitidos ({{ $evaluation->max_attempts + $extraAttempts }}).</span>
                                </div>
                                <button disabled class="bg-gray-400 text-white px-6 py-3 rounded-lg font-bold cursor-not-allowed">
                                    Intentar de nuevo
                                </button>
                            @endif
                        @endif
                        {{-- Button to continue to next lesson or go back --}}
                        <a href="#" onclick="window.location.reload()" class="bg-gray-500 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-600 transition duration-150">
                            {{ $passed ? 'Continuar' : 'Volver' }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


