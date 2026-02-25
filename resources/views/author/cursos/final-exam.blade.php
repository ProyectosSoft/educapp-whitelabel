<x-instructor-layout :course="$course">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="{{ route('author.cursos.index') }}" class="hover:text-[#335A92] transition-colors"><i class="fas fa-arrow-left mr-2"></i> Volver a mis cursos</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            @include('author.cursos.partials.edition-sidebar', ['course' => $course])

            <div class="lg:col-span-9 bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
                <div class="bg-[#335A92] px-10 py-8 relative overflow-hidden flex justify-between items-center">
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-yellow-400/20 blur-3xl"></div>

                    <div class="relative z-10">
                        <h1 class="text-3xl font-bold text-white">Evaluación Final del Curso</h1>
                        <p class="text-blue-100 mt-2 text-lg truncate max-w-2xl">Configura el examen final requerido para certificación.</p>
                    </div>
                </div>

                <div class="p-10">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-amber-800 text-sm">
                        <i class="fas fa-info-circle mr-2"></i>
                        Esta evaluación estará disponible para el estudiante solo después de completar todas las lecciones.
                    </div>
                    @php
                        $supportsCourseContext = \Illuminate\Support\Facades\Schema::hasColumn('exam_evaluations', 'context_type')
                            && \Illuminate\Support\Facades\Schema::hasColumn('exam_evaluations', 'course_id');
                        $finalEvaluations = collect();
                        if ($supportsCourseContext) {
                            $finalEvaluations = \App\Models\ExamEvaluation::where('user_id', auth()->id())
                                ->where('course_id', $course->id)
                                ->where('context_type', 'course_final')
                                ->latest()
                                ->get();
                        }
                    @endphp

                    <div class="flex justify-end mb-6">
                        <a href="{{ route('author.exams.manager', ['create' => 1, 'target' => 'course', 'course_id' => $course->id, 'scope' => 'final']) }}"
                           class="px-5 py-2.5 text-sm font-bold text-white bg-[#335A92] hover:bg-[#284672] rounded-lg shadow-md hover:shadow-lg transition">
                            <i class="fas fa-plus-circle mr-2"></i> Crear en Gestión Evaluaciones
                        </a>
                    </div>

                    @if(!$supportsCourseContext)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-yellow-800 text-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Para vincular evaluaciones al curso desde Gestión Evaluaciones, ejecuta migraciones pendientes (`php artisan migrate`).
                        </div>
                    @else
                        <div class="space-y-3">
                            @forelse($finalEvaluations as $evaluation)
                                <div class="border border-gray-200 rounded-xl p-4 flex items-center justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-800">{{ $evaluation->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Intentos: {{ $evaluation->max_attempts }} · Aprueba: {{ $evaluation->passing_score }}%
                                        </p>
                                    </div>
                                    <a href="{{ route('author.exams.builder', $evaluation->id) }}"
                                       class="px-3 py-2 text-xs font-bold text-[#335A92] bg-blue-50 border border-blue-100 rounded-lg hover:bg-blue-100 transition">
                                        Gestionar Preguntas
                                    </a>
                                </div>
                            @empty
                                <div class="text-sm text-gray-500 bg-gray-50 border border-gray-200 rounded-xl p-4">
                                    Aún no hay evaluación final creada desde Gestión Evaluaciones para este curso.
                                </div>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-instructor-layout>
