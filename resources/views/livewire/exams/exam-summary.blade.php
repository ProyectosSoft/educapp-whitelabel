<div class="min-h-screen py-6 md:py-8 px-4 sm:px-6 lg:px-8 bg-gray-50/50 flex items-center justify-center">
    <div class="max-w-5xl w-full mx-auto relative">
        {{-- Decorative Blur Backdrop --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 bg-secondary/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative z-10 flex flex-col">
            
            {{-- Big Header --}}
            <div class="bg-primary p-6 md:p-8 text-center relative overflow-hidden shrink-0">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
                <div class="absolute bottom-0 right-1/4 w-32 h-32 bg-secondary/30 rounded-full blur-2xl transform translate-y-1/2 pointer-events-none"></div>

                <div class="relative z-10">
                    <span class="inline-block py-1 px-3 rounded-full bg-white/10 text-white text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 border border-white/20 backdrop-blur-md">
                        Resumen de Evaluación
                    </span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-1 tracking-tight drop-shadow-sm">{{ $evaluation->name }}</h1>
                    <p class="text-blue-100/90 text-lg font-medium max-w-2xl mx-auto">{{ $evaluation->exam->name }}</p>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="p-6 md:p-8 lg:p-10 grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10 shrink-0">
                
                {{-- Column 1: Detalles --}}
                <div class="space-y-5">
                    <h3 class="text-xl font-bold text-primary-900 flex items-center border-b border-gray-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center text-secondary mr-3">
                            <i class="fas fa-list-ul"></i>
                        </div>
                        Detalles Técnicos
                    </h3>

                    <div class="space-y-3">
                        <div class="bg-gray-50 rounded-xl p-3 md:p-4 flex items-center justify-between border border-gray-100 hover:shadow-sm transition-shadow group">
                            <div class="flex items-center text-gray-500 text-sm md:text-base font-medium group-hover:text-primary-800 transition-colors">
                                <div class="w-7 h-7 rounded-md bg-white shadow-sm flex items-center justify-center text-primary-400 mr-3">
                                    <i class="fas fa-question-circle text-sm"></i>
                                </div>
                                Número de Preguntas
                            </div>
                            <span class="font-extrabold text-primary-900 text-lg">{{ $stats['questions_count'] }}</span>
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-3 md:p-4 flex items-center justify-between border border-gray-100 hover:shadow-sm transition-shadow group">
                            <div class="flex items-center text-gray-500 text-sm md:text-base font-medium group-hover:text-primary-800 transition-colors">
                                <div class="w-7 h-7 rounded-md bg-white shadow-sm flex items-center justify-center text-secondary-500 mr-3">
                                    <i class="fas fa-stopwatch text-sm"></i>
                                </div>
                                Tiempo Límite
                            </div>
                            <span class="font-extrabold text-primary-900 text-lg">{{ $evaluation->time_limit_minutes > 0 ? $evaluation->time_limit_minutes . ' min' : 'Libre' }}</span>
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-3 md:p-4 flex items-center justify-between border border-gray-100 hover:shadow-sm transition-shadow group">
                            <div class="flex items-center text-gray-500 text-sm md:text-base font-medium group-hover:text-primary-800 transition-colors">
                                <div class="w-7 h-7 rounded-md bg-white shadow-sm flex items-center justify-center text-orange-400 mr-3">
                                    <i class="fas fa-redo-alt text-sm"></i>
                                </div>
                                Intentos Posibles
                            </div>
                            <span class="font-extrabold text-primary-900 text-lg">{{ $evaluation->max_attempts > 0 ? $evaluation->max_attempts : 'Ilimitados' }}</span>
                        </div>
                        
                        <div class="bg-yellow-50/50 rounded-xl p-3 md:p-4 flex items-center justify-between border border-yellow-100 hover:shadow-sm transition-shadow group">
                            <div class="flex items-center text-yellow-700 text-sm md:text-base font-medium group-hover:text-yellow-800 transition-colors">
                                <div class="w-7 h-7 rounded-md bg-white shadow-sm flex items-center justify-center text-yellow-500 mr-3">
                                    <i class="fas fa-flag-checkered text-sm"></i>
                                </div>
                                Mínimo para Aprobar
                            </div>
                            <span class="font-black text-yellow-600 text-xl">{{ $evaluation->passing_score }}%</span>
                        </div>
                    </div>
                </div>

                {{-- Column 2: Progreso --}}
                <div class="space-y-5 flex flex-col h-full">
                    <h3 class="text-xl font-bold text-primary-900 flex items-center border-b border-gray-100 pb-3 shrink-0">
                        <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary mr-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        Tu Progreso
                    </h3>

                    <div class="grid grid-cols-2 gap-3 shrink-0">
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 text-center flex flex-col justify-center">
                            <span class="text-gray-500 text-[10px] md:text-xs font-bold uppercase tracking-wider mb-1">Intentos Usados</span>
                            <div class="text-2xl md:text-3xl font-black {{ $stats['attempts_count'] >= $evaluation->max_attempts && $evaluation->max_attempts > 0 ? 'text-red-500' : 'text-primary-900' }}">
                                {{ $stats['attempts_count'] }} <span class="text-sm md:text-base text-gray-400 font-medium">/ {{ $evaluation->max_attempts > 0 ? $evaluation->max_attempts : '∞' }}</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 text-center flex flex-col justify-center">
                            <span class="text-gray-500 text-[10px] md:text-xs font-bold uppercase tracking-wider mb-1">Mejor Puntaje</span>
                            <div class="text-2xl md:text-3xl font-black {{ $stats['best_score'] >= $evaluation->passing_score ? 'text-green-500' : ($stats['attempts_count'] > 0 ? 'text-red-500' : 'text-gray-300') }}">
                                {{ $stats['attempts_count'] > 0 ? number_format($stats['best_score'], 1) . '%' : '--' }}
                            </div>
                        </div>
                    </div>

                    {{-- Actions / Status Card --}}
                    <div class="mt-auto pt-2 flex-1 flex flex-col justify-end">
                        @if($stats['approved_attempt'])
                            {{-- Approved State --}}
                            <div class="rounded-2xl border border-green-200 bg-gradient-to-br from-green-50 to-emerald-100/50 p-5 md:p-6 text-center shadow-md shadow-green-100 relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 text-green-500/10 text-8xl pointer-events-none">
                                    <i class="fas fa-award"></i>
                                </div>
                                <h3 class="text-xl font-black text-green-800 mb-1 tracking-tight">¡Evaluación Superada!</h3>
                                <p class="text-green-700/80 mb-4 font-medium text-sm">Has demostrado tus conocimientos y aprobado satisfactoriamente.</p>

                                <a href="{{ route('exams.certificate', $stats['approved_attempt']->id) }}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-500 text-white font-black text-base rounded-xl transition-all shadow-lg shadow-green-600/20 hover:-translate-y-0.5 relative z-10">
                                    <i class="fas fa-certificate mr-2 text-lg"></i>
                                    Obtener mi Insignia
                                </a>
                            </div>
                        @elseif($stats['status'] === 'pending_review')
                            {{-- Pending Review State --}}
                            <div class="rounded-2xl border border-yellow-200 bg-gradient-to-br from-yellow-50 to-orange-50/50 p-5 md:p-6 text-center shadow-md shadow-yellow-100 relative overflow-hidden">
                                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjM0LCAxNzksIDgsIDAuMikiLz48L3N2Zz4=')] opacity-50 z-0"></div>
                                <h3 class="text-xl font-black text-yellow-800 mb-1 tracking-tight relative z-10">
                                    <i class="fas fa-hourglass-half mr-2 animate-pulse"></i> Evaluación en Revisión
                               </h3>
                                <p class="text-yellow-700/80 mb-4 font-medium text-sm relative z-10">Tus respuestas están siendo calificadas manualmente. Te avisaremos pronto.</p>
                                <button disabled class="w-full inline-flex items-center justify-center px-4 py-3 bg-yellow-100/50 text-yellow-700 font-bold text-base rounded-xl cursor-not-allowed border border-yellow-200 backdrop-blur-sm relative z-10">
                                    Calificando...
                                </button>
                            </div>
                        @else
                            {{-- Action State (Start or Locked) --}}
                            @php
                                $canAttempt = true;
                                $reason = '';
                                $secondsRemaining = 0;

                                if($evaluation->max_attempts > 0 && $stats['attempts_count'] >= $evaluation->max_attempts) {
                                    $canAttempt = false;
                                    $reason = 'No te quedan más intentos disponibles.';
                                }

                                if($canAttempt && $userAttempts->isNotEmpty()) {
                                    $lastAttempt = $userAttempts->first();
                                    if($lastAttempt->completed_at) {
                                        $canRetryAt = $lastAttempt->completed_at->addMinutes($evaluation->wait_time_minutes);
                                        if(\Carbon\Carbon::now()->lt($canRetryAt)) {
                                            $canAttempt = false;
                                            $secondsRemaining = \Carbon\Carbon::now()->diffInSeconds($canRetryAt);
                                        }
                                    }
                                }
                            @endphp

                            <div class="h-full flex flex-col justify-end" x-data="{
                                seconds: {{ $secondsRemaining }},
                                canAttempt: {{ $canAttempt ? 'true' : 'false' }},
                                initTimer() {
                                    if (this.seconds > 0) {
                                        this.timer = setInterval(() => {
                                            this.seconds--;
                                            if (this.seconds <= 0) {
                                                clearInterval(this.timer);
                                                window.location.reload();
                                            }
                                        }, 1000);
                                    }
                                },
                                formatTime(sec) {
                                    let hours = Math.floor(sec / 3600);
                                    let minutes = Math.floor((sec % 3600) / 60);
                                    let seconds = sec % 60;
                                    let str = '';
                                    if (hours > 0) str += hours + 'h ';
                                    if (minutes > 0) str += minutes + 'm ';
                                    str += seconds + 's';
                                    return str;
                                }
                            }" x-init="initTimer()">
                                <template x-if="canAttempt">
                                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-5 md:p-6 text-center shadow-inner pt-6">
                                        <p class="text-gray-600 mb-4 font-medium text-sm">¿Todo listo? Asegúrate de tener una conexión estable antes de iniciar.</p>
                                        <a href="{{ route('exams.taker', ['evaluation' => $evaluation->id, 'auto_start' => 1]) }}" class="group w-full flex items-center justify-center px-4 py-3 bg-primary hover:bg-primary-600 text-white text-base font-black rounded-xl shadow-lg shadow-primary/25 transition-all hover:-translate-y-0.5">
                                            <span class="mr-2">Iniciar Evaluación</span>
                                            <i class="fas fa-rocket group-hover:-translate-y-0.5 group-hover:translate-x-0.5 transition-transform"></i>
                                        </a>
                                    </div>
                                </template>

                                <template x-if="!canAttempt">
                                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-5 md:p-6 text-center h-full flex flex-col justify-center relative overflow-hidden">
                                        <div class="absolute -right-4 -bottom-4 text-gray-200 text-8xl pointer-events-none">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <div class="relative z-10">
                                            <h4 class="font-bold text-gray-700 text-base mb-2"><i class="fas fa-lock text-gray-400 mr-2"></i> Acceso Bloqueado</h4>
                                            
                                            @if($secondsRemaining > 0)
                                                <p class="text-gray-500 text-xs mb-3">Debes esperar un tiempo antes de tu próximo intento.</p>
                                                <div class="bg-white border border-gray-200 rounded-lg py-2 px-4 mx-auto shadow-sm inline-block">
                                                    <span class="block text-[9px] uppercase font-bold text-gray-400 tracking-wider mb-0.5">Habilitado en</span>
                                                    <span x-text="formatTime(seconds)" class="block font-black text-primary-900 font-mono text-lg"></span>
                                                </div>
                                            @else
                                                <p class="text-red-500 text-sm font-bold bg-red-50 py-2 px-3 rounded-lg border border-red-100 mt-1 inline-block">{{ $reason }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </template>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-center flex justify-center shrink-0">
                <a href="{{ route('student.evaluations.index') }}" class="inline-flex items-center justify-center py-2 px-4 rounded-lg bg-white border border-gray-200 shadow-sm text-gray-500 hover:text-primary hover:border-primary-200 hover:shadow-md transition-all font-bold text-xs">
                    <i class="fas fa-arrow-left mr-2"></i> Volver a mi panel
                </a>
            </div>
        </div>
    </div>
</div>
