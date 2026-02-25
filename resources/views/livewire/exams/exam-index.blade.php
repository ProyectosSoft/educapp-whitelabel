<div class="min-h-screen bg-[#eef4fb] py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 rounded-3xl border border-[#c9d8ea] bg-white px-6 py-7 shadow-lg shadow-[#335A92]/10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#335A92] tracking-tight">Exámenes Disponibles</h1>
            <p class="mt-2 text-[#477EB1] font-medium">Selecciona una evaluación para continuar o consulta tu certificado si ya aprobaste.</p>
        </div>

        @php
            $totalEvaluations = $exams->sum(fn($exam) => $exam->evaluations->count());
        @endphp

        @if($totalEvaluations === 0)
            <div class="rounded-3xl border border-[#c9d8ea] bg-white p-12 text-center shadow-lg shadow-[#335A92]/10">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#f0f6ff] text-[#477EB1]">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>
                <h2 class="text-xl font-extrabold text-[#335A92]">No hay exámenes disponibles</h2>
                <p class="mt-2 text-[#477EB1]">Cuando se habiliten nuevas evaluaciones aparecerán aquí.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($exams as $exam)
                    @foreach($exam->evaluations as $eval)
                        @php
                            $approvedAttempt = $eval->userAttempts->first(function($attempt) {
                                return $attempt->is_approved == true;
                            });
                        @endphp

                        <article class="group rounded-2xl border border-[#c9d8ea] bg-white p-6 shadow-md shadow-[#335A92]/5 transition hover:-translate-y-1 hover:shadow-lg hover:shadow-[#335A92]/15 h-full flex flex-col">
                            <div class="mb-4 flex items-start justify-between gap-3 min-h-[4rem]">
                                <h2 class="text-xl font-extrabold text-[#335A92] leading-tight">{{ $eval->name }}</h2>
                                <span class="inline-flex shrink-0 items-center rounded-full bg-[#f0f6ff] px-3 py-1 text-xs font-bold text-[#477EB1] border border-[#dbe7f4]">
                                    {{ $exam->name }}
                                </span>
                            </div>

                            <p class="mb-5 min-h-[2.5rem] text-sm text-slate-600 line-clamp-2">{{ $exam->description }}</p>

                            <div class="mb-6 grid grid-cols-2 gap-3 text-sm">
                                <div class="rounded-lg border border-[#dbe7f4] bg-[#f8fbff] p-3">
                                    <p class="text-xs font-bold uppercase text-[#477EB1]">Duración</p>
                                    <p class="mt-1 font-extrabold text-[#335A92]">{{ $eval->time_limit_minutes ?? 'Infinito' }} min</p>
                                </div>
                                <div class="rounded-lg border border-[#ECBD2D]/40 bg-[#fff8e3] p-3">
                                    <p class="text-xs font-bold uppercase text-[#8a6d09]">Aprobación</p>
                                    <p class="mt-1 font-extrabold text-[#8a6d09]">{{ $eval->passing_score }}%</p>
                                </div>
                            </div>

                            @if($approvedAttempt)
                                <a href="{{ route('exams.certificate', $approvedAttempt->id) }}"
                                   target="_blank"
                                   class="inline-flex w-full items-center justify-center rounded-xl bg-[#ECBD2D] px-4 py-3 font-extrabold text-[#335A92] transition hover:bg-[#d9ab1f] mt-auto">
                                    <i class="fas fa-certificate mr-2"></i> Ver Certificado
                                </a>
                            @else
                                <a href="{{ route('exams.summary', $eval->id) }}"
                                   class="inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-[#335A92] to-[#477EB1] px-4 py-3 font-extrabold text-white transition hover:from-[#2c4d7f] hover:to-[#3d6fa0] mt-auto">
                                    Realizar <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            @endif
                        </article>
                    @endforeach
                @endforeach
            </div>
        @endif
    </div>
</div>
