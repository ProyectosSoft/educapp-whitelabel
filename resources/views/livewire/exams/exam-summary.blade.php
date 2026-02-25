<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#eef4fb]">
    <div class="max-w-5xl mx-auto">
        <div class="relative overflow-hidden rounded-3xl border border-[#c9d8ea] bg-white shadow-xl shadow-[#335A92]/10">
            <div class="absolute -top-20 -right-20 h-64 w-64 rounded-full bg-[#477EB1]/20 blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 h-56 w-56 rounded-full bg-[#ECBD2D]/20 blur-3xl"></div>

            <div class="relative">
                <div class="bg-gradient-to-r from-[#335A92] to-[#477EB1] px-8 py-8 text-center border-b border-[#335A92]/20">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 tracking-tight">{{ $evaluation->name }}</h1>
                    <p class="text-blue-100 text-lg font-medium">{{ $evaluation->exam->name }}</p>
                </div>

                <div class="p-6 md:p-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-5">
                        <h3 class="text-xl font-extrabold text-[#335A92] flex items-center">
                            <i class="fas fa-info-circle text-[#477EB1] mr-3"></i> Detalles de la Evaluación
                        </h3>

                        <div class="space-y-3">
                            <div class="bg-[#f4f8fd] border border-[#dce8f5] rounded-xl p-4 flex items-center justify-between">
                                <span class="text-[#335A92]"><i class="fas fa-question-circle mr-2 w-5 text-[#477EB1]"></i> Preguntas</span>
                                <span class="font-extrabold text-[#335A92] text-lg">{{ $stats['questions_count'] }}</span>
                            </div>
                            <div class="bg-[#f4f8fd] border border-[#dce8f5] rounded-xl p-4 flex items-center justify-between">
                                <span class="text-[#335A92]"><i class="fas fa-clock mr-2 w-5 text-[#477EB1]"></i> Tiempo Límite</span>
                                <span class="font-extrabold text-[#335A92] text-lg">{{ $evaluation->time_limit_minutes > 0 ? $evaluation->time_limit_minutes . ' min' : 'Sin límite' }}</span>
                            </div>
                            <div class="bg-[#f4f8fd] border border-[#dce8f5] rounded-xl p-4 flex items-center justify-between">
                                <span class="text-[#335A92]"><i class="fas fa-redo mr-2 w-5 text-[#477EB1]"></i> Intentos Permitidos</span>
                                <span class="font-extrabold text-[#335A92] text-lg">{{ $evaluation->max_attempts > 0 ? $evaluation->max_attempts : 'Ilimitados' }}</span>
                            </div>
                            <div class="bg-[#f4f8fd] border border-[#dce8f5] rounded-xl p-4 flex items-center justify-between">
                                <span class="text-[#335A92]"><i class="fas fa-hourglass-half mr-2 w-5 text-[#477EB1]"></i> Espera entre intentos</span>
                                <span class="font-extrabold text-[#335A92] text-lg">{{ $evaluation->wait_time_minutes }} min</span>
                            </div>
                            <div class="bg-[#fff7de] border border-[#ECBD2D]/40 rounded-xl p-4 flex items-center justify-between">
                                <span class="text-[#8a6d09]"><i class="fas fa-check-double mr-2 w-5 text-[#ECBD2D]"></i> Aprobar con</span>
                                <span class="font-extrabold text-[#8a6d09] text-lg">{{ $evaluation->passing_score }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <h3 class="text-xl font-extrabold text-[#335A92] flex items-center">
                            <i class="fas fa-user-clock text-[#477EB1] mr-3"></i> Tu Progreso
                        </h3>

                        <div class="space-y-3">
                            <div class="bg-[#f4f8fd] border border-[#dce8f5] rounded-xl p-4 flex items-center justify-between">
                                <span class="text-[#335A92]">Intentos Realizados</span>
                                <span class="font-extrabold {{ $stats['attempts_count'] >= $evaluation->max_attempts && $evaluation->max_attempts > 0 ? 'text-[#FC0B29]' : 'text-[#335A92]' }} text-lg">
                                    {{ $stats['attempts_count'] }} / {{ $evaluation->max_attempts > 0 ? $evaluation->max_attempts : '∞' }}
                                </span>
                            </div>
                            <div class="bg-[#f4f8fd] border border-[#dce8f5] rounded-xl p-4 flex items-center justify-between">
                                <span class="text-[#335A92]">Tiempo Total Usado</span>
                                <span class="font-extrabold text-[#335A92] text-lg">{{ $stats['total_time_used'] }}</span>
                            </div>

                            <div class="rounded-2xl border border-[#cfe0f2] bg-gradient-to-br from-[#eaf2fb] to-[#f7fbff] p-6 text-center">
                                <span class="block text-[#477EB1] text-xs uppercase tracking-wider font-bold mb-2">Mejor Resultado</span>
                                <div class="text-5xl font-extrabold {{ $stats['best_score'] >= $evaluation->passing_score ? 'text-emerald-600' : 'text-[#FC0B29]' }} mb-2">
                                    {{ number_format($stats['best_score'], 1) }}%
                                </div>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold {{ $stats['best_score'] >= $evaluation->passing_score ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-[#FC0B29]' }}">
                                    {{ $stats['best_score'] >= $evaluation->passing_score ? 'APROBADO' : 'NO APROBADO' }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-6">
                            @if($stats['approved_attempt'])
                                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-7 text-center">
                                    <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/25">
                                        <i class="fas fa-trophy text-2xl text-white"></i>
                                    </div>
                                    <h3 class="text-2xl font-extrabold text-emerald-700 mb-2">¡Felicitaciones!</h3>
                                    <p class="text-emerald-800/80 mb-6">Has aprobado esta evaluación satisfactoriamente.</p>

                                    <a href="{{ route('exams.certificate', $stats['approved_attempt']->id) }}" target="_blank" class="inline-flex items-center justify-center px-8 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-lg rounded-xl transition-all shadow-md shadow-emerald-500/25">
                                        <i class="fas fa-certificate mr-3"></i>
                                        Ver Certificación
                                    </a>
                                </div>
                            @elseif($stats['status'] === 'pending_review')
                                <div class="rounded-2xl border border-[#ECBD2D]/50 bg-[#fff8e3] p-7 text-center">
                                    <div class="w-16 h-16 bg-[#ECBD2D]/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-[#ECBD2D]/50">
                                        <i class="fas fa-clipboard-user text-2xl text-[#8a6d09]"></i>
                                    </div>
                                    <h3 class="text-2xl font-extrabold text-[#8a6d09] mb-2">En espera de revisión</h3>
                                    <p class="text-[#8a6d09]/80 mb-6">
                                        Esta evaluación requiere revisión manual para publicar tu nota final.
                                    </p>
                                    <button disabled class="inline-flex items-center justify-center px-8 py-3 bg-[#ECBD2D]/30 text-[#8a6d09] font-extrabold text-lg rounded-xl cursor-not-allowed border border-[#ECBD2D]/40">
                                        <i class="fas fa-hourglass-half mr-3"></i>
                                        En proceso de calificación...
                                    </button>
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
                                        if (hours > 0) str += hours + 'h ';
                                        if (minutes > 0) str += minutes + 'm ';
                                        str += seconds + 's';
                                        return str;
                                    }
                                }" x-init="initTimer()">
                                    <template x-if="canAttempt">
                                        <a href="{{ route('exams.taker', ['evaluation' => $evaluation->id, 'auto_start' => 1]) }}" class="group w-full flex items-center justify-center px-8 py-4 bg-gradient-to-r from-[#335A92] to-[#477EB1] hover:from-[#2c4d7f] hover:to-[#3d6fa0] text-white text-lg font-extrabold rounded-xl shadow-lg shadow-[#335A92]/25 transition-all">
                                            <span class="mr-2">Comenzar Evaluación</span>
                                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                        </a>
                                    </template>

                                    <template x-if="!canAttempt">
                                        <div class="w-full text-center">
                                            <button disabled class="w-full flex items-center justify-center px-8 py-4 bg-slate-200 text-slate-500 text-lg font-bold rounded-xl cursor-not-allowed border border-slate-300">
                                                <i class="fas fa-lock mr-2"></i> No disponible
                                            </button>

                                            @if($secondsRemaining > 0)
                                                <p class="text-[#8a6d09] text-sm mt-3 font-semibold bg-[#fff2c9] py-2 px-4 rounded-lg border border-[#ECBD2D]/40 inline-block mx-auto">
                                                    <i class="fas fa-hourglass-half mr-2"></i> Próximo intento en: <span x-text="formatTime(seconds)" class="font-extrabold"></span>
                                                </p>
                                            @else
                                                <p class="text-[#FC0B29] text-sm mt-3 font-semibold">{{ $reason }}</p>
                                            @endif
                                        </div>
                                    </template>
                                </div>
                            @endif

                            <div class="mt-4 text-center">
                                <a href="{{ route('exams.index') }}" class="text-[#335A92] hover:text-[#477EB1] transition text-sm font-semibold underline">Volver al listado</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
