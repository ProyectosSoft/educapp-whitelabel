<div class="min-h-screen bg-gray-900 text-white font-sans py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-4xl w-full">
        {{-- Card Container --}}
        <div class="bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-700 relative">
            
            {{-- Background decorative elements --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-blue-600 opacity-10 filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-purple-600 opacity-10 filter blur-3xl"></div>

            <div class="relative z-10">
                {{-- Header --}}
                <div class="bg-gray-800/50 p-8 border-b border-gray-700 text-center">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 mb-2">
                        {{ $evaluation->name }}
                    </h1>
                    <p class="text-gray-400 text-lg">{{ $evaluation->exam->name }}</p>
                </div>

                <div class="p-8 md:p-12 grid grid-cols-1 md:grid-cols-2 gap-12">
                    
                    {{-- Column 1: Evaluation Details --}}
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-3"></i> Detalles de la Evaluación
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="bg-gray-700/50 p-4 rounded-xl flex items-center justify-between border border-gray-600">
                                <span class="text-gray-300"><i class="fas fa-question-circle mr-2 w-5"></i> Preguntas</span>
                                <span class="font-bold text-white text-lg">{{ $stats['questions_count'] }}</span>
                            </div>

                            <div class="bg-gray-700/50 p-4 rounded-xl flex items-center justify-between border border-gray-600">
                                <span class="text-gray-300"><i class="fas fa-clock mr-2 w-5"></i> Tiempo Límite</span>
                                <span class="font-bold text-white text-lg">{{ $evaluation->time_limit_minutes > 0 ? $evaluation->time_limit_minutes . ' min' : 'Sin límite' }}</span>
                            </div>

                            <div class="bg-gray-700/50 p-4 rounded-xl flex items-center justify-between border border-gray-600">
                                <span class="text-gray-300"><i class="fas fa-redo mr-2 w-5"></i> Intentos Permitidos</span>
                                <span class="font-bold text-white text-lg">{{ $evaluation->max_attempts > 0 ? $evaluation->max_attempts : 'Ilimitados' }}</span>
                            </div>

                            <div class="bg-gray-700/50 p-4 rounded-xl flex items-center justify-between border border-gray-600">
                                <span class="text-gray-300"><i class="fas fa-hourglass-half mr-2 w-5"></i> Espera entre intentos</span>
                                <span class="font-bold text-white text-lg">{{ $evaluation->wait_time_minutes }} min</span>
                            </div>

                            <div class="bg-gray-700/50 p-4 rounded-xl flex items-center justify-between border border-gray-600">
                                <span class="text-gray-300"><i class="fas fa-check-double mr-2 w-5"></i> Aprobar con</span>
                                <span class="font-bold text-green-400 text-lg">{{ $evaluation->passing_score }}%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Column 2: User Status --}}
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-user-clock text-purple-500 mr-3"></i> Tu Progreso
                        </h3>

                        <div class="space-y-4">
                             <div class="bg-gray-700/50 p-4 rounded-xl flex items-center justify-between border border-gray-600">
                                <span class="text-gray-300">Intentos Realizados</span>
                                <span class="font-bold {{ $stats['attempts_count'] >= $evaluation->max_attempts && $evaluation->max_attempts > 0 ? 'text-red-400' : 'text-white' }} text-lg">
                                    {{ $stats['attempts_count'] }} / {{ $evaluation->max_attempts > 0 ? $evaluation->max_attempts : '∞' }}
                                </span>
                            </div>

                            <div class="bg-gray-700/50 p-4 rounded-xl flex items-center justify-between border border-gray-600">
                                <span class="text-gray-300">Tiempo Total Usado</span>
                                <span class="font-bold text-white text-lg">{{ $stats['total_time_used'] }}</span>
                            </div>

                            <div class="p-6 rounded-2xl bg-gradient-to-br from-gray-700 to-gray-800 border border-gray-600 text-center relative overflow-hidden group">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-white opacity-5 rounded-full blur-xl transform translate-x-10 -translate-y-10"></div>
                                
                                <span class="block text-gray-400 text-sm uppercase tracking-wider mb-2">Mejor Resultado</span>
                                <div class="text-5xl font-extrabold {{ $stats['best_score'] >= $evaluation->passing_score ? 'text-green-400' : 'text-yellow-400' }} mb-2">
                                    {{ number_format($stats['best_score'], 1) }}%
                                </div>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $stats['best_score'] >= $evaluation->passing_score ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                    {{ $stats['best_score'] >= $evaluation->passing_score ? 'APROBADO' : 'NO APROBADO' }}
                                </span>
                            </div>
                        </div>

                         <div class="mt-8">
                             @if($stats['approved_attempt'])
                                <div class="bg-gradient-to-br from-green-500/10 to-emerald-500/10 border border-green-500/20 rounded-2xl p-8 text-center backdrop-blur-sm relative overflow-hidden">
                                     <div class="absolute top-0 right-0 -mr-10 -mt-10 w-32 h-32 bg-green-500 opacity-10 rounded-full blur-2xl"></div>
                                     <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 bg-emerald-500 opacity-10 rounded-full blur-2xl"></div>

                                     <div class="relative z-10">
                                        <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg shadow-green-500/40 animate-pulse">
                                            <i class="fas fa-trophy text-3xl text-white"></i>
                                        </div>
                                        
                                        <h3 class="text-2xl font-bold text-white mb-2">¡Felicitaciones!</h3>
                                        <p class="text-gray-300 mb-8 max-w-md mx-auto">Has completado y aprobado esta evaluación satisfactoriamente. Tu esfuerzo ha valido la pena.</p>
                                        
                                        <a href="{{ route('exams.certificate', $stats['approved_attempt']->id) }}" target="_blank" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-white font-bold text-lg rounded-xl transition-all shadow-lg shadow-green-500/30 hover:shadow-green-500/50 hover:-translate-y-1 group">
                                            <i class="fas fa-certificate mr-3 group-hover:rotate-12 transition-transform"></i>
                                            Ver Certificación
                                        </a>
                                     </div>
                                </div>
                             @elseif($stats['status'] === 'pending_review')
                                 <div class="bg-gray-800/50 rounded-2xl p-8 text-center border border-yellow-500/20 relative overflow-hidden">
                                     <div class="absolute top-0 right-0 -mr-10 -mt-10 w-32 h-32 bg-yellow-500 opacity-5 rounded-full blur-2xl"></div>
                                     
                                     <div class="relative z-10">
                                         <div class="w-20 h-20 bg-gradient-to-br from-yellow-500/20 to-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-yellow-500/30">
                                             <i class="fas fa-clipboard-user text-3xl text-yellow-500"></i>
                                         </div>
                                         <h3 class="text-2xl font-bold text-white mb-3">En espera de revisión</h3>
                                         <p class="text-gray-400 mb-8 max-w-lg mx-auto leading-relaxed">
                                             Has completado tu evaluación, pero contiene preguntas abiertas que requieren revisión manual por parte de un instructor.
                                             <br><span class="text-yellow-500/80 text-sm">Tu nota definitiva estará disponible una vez finalizada la revisión.</span>
                                         </p>
                                         
                                         <button disabled class="inline-flex items-center justify-center px-8 py-4 bg-gray-700/50 text-yellow-500 font-bold text-lg rounded-xl cursor-not-allowed border border-gray-600/50 hover:bg-gray-700 transition-colors">
                                             <i class="fas fa-hourglass-half mr-3 animate-pulse"></i>
                                             En proceso de calificación...
                                         </button>
                                     </div>
                                 </div>
                             @else
                                 @php
                                     $canAttempt = true;
                                     $reason = '';
                                     $secondsRemaining = 0;
                                     
                                     if($evaluation->max_attempts > 0 && $stats['attempts_count'] >= $evaluation->max_attempts) {
                                         $canAttempt = false;
                                         $reason = 'Has alcanzado el número máximo de intentos.';
                                     }
                                     
                                     // Add wait time logic
                                     if($canAttempt && $userAttempts->isNotEmpty()) {
                                         $lastAttempt = $userAttempts->first(); // Ordered by desc
                                         if($lastAttempt->completed_at) {
                                             $canRetryAt = $lastAttempt->completed_at->addMinutes($evaluation->wait_time_minutes);
                                             if(\Carbon\Carbon::now()->lt($canRetryAt)) {
                                                 $canAttempt = false;
                                                 $secondsRemaining = \Carbon\Carbon::now()->diffInSeconds($canRetryAt);
                                             }
                                         }
                                     }
                                 @endphp
    
                                <div x-data="{
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
                                        if(hours > 0) str += hours + 'h ';
                                        if(minutes > 0) str += minutes + 'm ';
                                        str += seconds + 's';
                                        return str;
                                    }
                                }" x-init="initTimer()">
                                    
                                    <template x-if="canAttempt">
                                        <a href="{{ route('exams.taker', ['evaluation' => $evaluation->id, 'auto_start' => 1]) }}" class="group w-full flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-lg font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transform hover:scale-[1.02] transition-all duration-200">
                                            <span class="mr-2">Comenzar Evaluación</span>
                                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                        </a>
                                    </template>
    
                                    <template x-if="!canAttempt">
                                        <div class="w-full">
                                            <button disabled class="w-full flex items-center justify-center px-8 py-4 bg-gray-700/50 text-gray-500 text-lg font-bold rounded-xl cursor-not-allowed border border-gray-600">
                                                <i class="fas fa-lock mr-2"></i> No disponible
                                            </button>
                                            
                                            @if($secondsRemaining > 0)
                                                 <p class="text-center text-yellow-400 text-sm mt-3 font-medium bg-yellow-500/10 py-2 px-4 rounded-lg border border-yellow-500/20 inline-block mx-auto">
                                                    <i class="fas fa-hourglass-half mr-2"></i> Próximo intento en: <span x-text="formatTime(seconds)" class="font-bold"></span>
                                                 </p>
                                            @else
                                                 <p class="text-center text-red-400 text-sm mt-3 font-medium">{{ $reason }}</p>
                                            @endif
                                        </div>
                                    </template>
                                </div>
                             @endif
                            
                            <div class="mt-4 text-center">
                                <a href="{{ route('exams.index') }}" class="text-gray-500 hover:text-white transition text-sm underline">Volver al listado</a>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
