<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gray-50/50 relative overflow-hidden">
    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] bg-secondary/5 rounded-full blur-[80px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[80px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        
        {{-- Header Section --}}
        <div class="mb-10 rounded-[2.5rem] border border-gray-100 bg-white p-8 md:p-12 shadow-2xl shadow-gray-200/40 relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
            <div class="absolute right-0 top-0 w-64 h-64 bg-primary-50 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            
            <div class="relative z-10 mb-6 md:mb-0 text-center md:text-left">
                <span class="inline-block py-1 px-3 rounded-full bg-secondary/10 text-secondary-600 text-xs font-bold uppercase tracking-widest mb-3 border border-secondary/20">
                    Panel de Pruebas
                </span>
                <h1 class="text-3xl md:text-5xl font-black text-primary-900 tracking-tight mb-3">Exámenes Disponibles</h1>
                <p class="text-gray-500 font-medium text-lg max-w-xl">Selecciona una evaluación para certificar tus habilidades o consulta e imprime tu certificado si ya la aprobaste.</p>
            </div>

            <div class="hidden md:flex relative z-10 p-6 bg-gradient-to-br from-primary-50 to-white rounded-3xl border border-primary-100 shadow-inner">
                <i class="fas fa-laptop-code text-6xl text-primary-300 drop-shadow-md"></i>
            </div>
        </div>

        @php
            $totalEvaluations = end($exams) ? 0 : 0;
            if(isset($exams) && count($exams) > 0) {
                 foreach($exams as $exam) {
                     $totalEvaluations += $exam->evaluations->count();
                 }
            }
        @endphp

        @if($totalEvaluations === 0)
            {{-- Empty State --}}
            <div class="rounded-[2.5rem] border border-gray-100 bg-white p-16 text-center shadow-xl shadow-gray-200/40 relative overflow-hidden">
                {{-- Background Pattern --}}
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>
                
                <div class="relative z-10">
                    <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-3xl bg-gray-50 shadow-inner border border-gray-100 text-gray-400">
                        <i class="fas fa-clipboard-list text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-primary-900 mb-3 tracking-tight">Aún no hay exámenes disponibles</h2>
                    <p class="text-gray-500 font-medium max-w-md mx-auto">Cuando los instructores o administradores asignen nuevas evaluaciones a tu departamento, aparecerán automáticamente en este panel.</p>
                </div>
            </div>
        @else
            {{-- Grid of Exams --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($exams as $exam)
                    @foreach($exam->evaluations as $eval)
                        @php
                            $approvedAttempt = $eval->userAttempts->first(function($attempt) {
                                return $attempt->is_approved == true;
                            });
                        @endphp

                        <article class="group relative rounded-[2rem] border border-gray-100 bg-white p-7 shadow-lg shadow-gray-200/40 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary-900/10 flex flex-col h-full overflow-hidden">
                            
                            {{-- Decorative corner shape --}}
                            <div class="absolute top-0 right-0 w-24 h-24 bg-primary-50 rounded-bl-full transition-transform duration-500 group-hover:scale-110 -z-0 pointer-events-none"></div>

                            <div class="relative z-10 mb-5 flex items-start justify-between gap-4">
                                <h2 class="text-2xl font-black text-primary-900 leading-tight group-hover:text-secondary transition-colors line-clamp-2">
                                    {{ $eval->name }}
                                </h2>
                                <div class="shrink-0 w-12 h-12 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-primary-400 group-hover:text-secondary transition-colors">
                                    <i class="fas fa-file-alt text-xl"></i>
                                </div>
                            </div>

                            <p class="mb-6 text-sm text-gray-500 line-clamp-2 font-medium relative z-10 leading-relaxed min-h-[2.5rem]">{{ $exam->description ?? 'Demuestra tus conocimientos y obtén tu calificación para este módulo.' }}</p>

                            <div class="mb-8 grid grid-cols-2 gap-4 relative z-10">
                                <div class="rounded-2xl border border-gray-100 bg-gray-50/50 p-4 transition-colors group-hover:bg-white group-hover:shadow-sm">
                                    <div class="flex items-center text-gray-400 mb-1">
                                        <i class="fas fa-stopwatch text-xs mr-2"></i>
                                        <p class="text-[10px] font-bold uppercase tracking-wider">Duración</p>
                                    </div>
                                    <p class="font-black text-primary-900 text-lg">{{ $eval->time_limit_minutes > 0 ? $eval->time_limit_minutes . ' min' : 'Libre' }}</p>
                                </div>
                                <div class="rounded-2xl border border-yellow-100 bg-yellow-50/50 p-4 transition-colors group-hover:bg-yellow-50/80 group-hover:shadow-sm">
                                    <div class="flex items-center text-yellow-600 mb-1">
                                        <i class="fas fa-flag-checkered text-xs mr-2"></i>
                                        <p class="text-[10px] font-bold uppercase tracking-wider">Aprobación</p>
                                    </div>
                                    <p class="font-black text-yellow-700 text-lg">{{ $eval->passing_score }}%</p>
                                </div>
                            </div>

                            <div class="mt-auto relative z-10">
                                @if($approvedAttempt)
                                    <a href="{{ route('exams.certificate', $approvedAttempt->id) }}"
                                       target="_blank"
                                       class="group/btn w-full inline-flex items-center justify-center rounded-xl bg-green-50 px-5 py-4 font-black text-green-700 transition hover:bg-green-600 hover:text-white border border-green-200 hover:border-green-600 shadow-sm">
                                        <i class="fas fa-medal mr-2 text-xl group-hover/btn:scale-110 transition-transform"></i>
                                        Ver Certificado
                                    </a>
                                @else
                                    <a href="{{ route('exams.summary', $eval->id) }}"
                                       class="w-full inline-flex items-center justify-center rounded-xl bg-primary px-5 py-4 font-black text-white transition-all shadow-lg shadow-primary/20 hover:bg-primary-600 hover:shadow-xl hover:shadow-primary/30 group-hover:translate-x-1">
                                        Presentar Evaluación <i class="fas fa-arrow-right ml-3 transition-transform group-hover:translate-x-1"></i>
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                @endforeach
            </div>
        @endif
    </div>
</div>
