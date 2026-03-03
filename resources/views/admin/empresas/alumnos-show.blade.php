<x-admin-layout>
    <div class="px-4 py-8 md:px-8 space-y-8">
        
        {{-- Header con Back Button --}}
        <div>
            <a href="{{ route('admin.empresas.alumnos.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-primary transition-colors mb-4 group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Volver a Alumnos
            </a>

            <div class="bg-primary rounded-[2rem] shadow-xl shadow-primary/20 flex flex-col md:flex-row justify-between items-center p-8 relative overflow-hidden">
                {{-- Abstract bg decoration --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
                <div class="absolute bottom-0 right-1/4 w-40 h-40 bg-secondary/30 rounded-full blur-2xl transform translate-y-1/2 pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-6 w-full text-center md:text-left">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white/20 shadow-lg shrink-0">
                        <img class="w-full h-full object-cover" src="{{ $alumno->profile_photo_url }}" alt="{{ $alumno->name }}">
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
                            <h2 class="text-3xl font-extrabold text-white tracking-tight">{{ $alumno->name }}</h2>
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold bg-[#ECBD2D] text-white shadow-sm self-center md:self-auto">
                                <i class="fas fa-check-circle mr-1.5"></i> Estudiante Activo
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-blue-100 font-medium text-sm">
                            <a href="mailto:{{ $alumno->email }}" class="flex items-center hover:text-white transition-colors">
                                <i class="fas fa-envelope mr-2 opacity-70"></i> {{ $alumno->email }}
                            </a>
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2 opacity-70"></i> Miembro desde: {{ $alumno->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contenido de Progreso --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Columna Izquierda: Tarjeta de Resumen --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 p-6 relative overflow-hidden">
                    <h3 class="text-lg font-black text-primary-900 mb-6 flex items-center">
                        <i class="fas fa-chart-pie text-secondary mr-2"></i> Resumen Académico
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <i class="fas fa-book text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Cursos Totales</p>
                                    <p class="text-xl font-black text-gray-900 leading-none mt-1">{{ $cursos->count() }}</p>
                                </div>
                            </div>
                        </div>

                        @php
                            $certificaciones = $alumno->examAttempts()->where('is_approved', 1)->count();

                            // As a fallback for "Cursos Completados", 
                            // we count the courses where the student has an approved final exam 
                            // or any approved exam related to the course.
                            $cursosCompletados = $alumno->examAttempts()
                                ->where('is_approved', 1)
                                ->whereHas('evaluation', function($query) {
                                    $query->whereNotNull('course_id');
                                })
                                ->distinct('evaluation_id')
                                ->count();
                        @endphp

                        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Completados</p>
                                    <p class="text-xl font-black text-gray-900 leading-none mt-1">{{ $cursosCompletados }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center shrink-0">
                                    <i class="fas fa-certificate text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Certificaciones</p>
                                    <p class="text-xl font-black text-gray-900 leading-none mt-1">{{ $certificaciones }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Columna Derecha: Listado de Cursos y Progreso --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Sección de Cursos --}}
                <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                    <div class="p-6 md:p-8 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                        <div>
                            <h3 class="text-xl font-black text-primary-900 tracking-tight">Cursos Asignados</h3>
                            <p class="text-sm text-gray-500 font-medium">Progreso detallado del estudiante</p>
                        </div>
                    </div>

                    @if($cursos->count() > 0)
                        <div class="divide-y divide-gray-100">
                            @foreach($cursos as $curso)
                                <div class="p-6 md:p-8 hover:bg-gray-50/50 transition-colors">
                                    <div class="flex flex-col sm:flex-row gap-6">
                                        {{-- Imagen del Curso --}}
                                        <div class="w-full sm:w-40 h-28 shrink-0 rounded-2xl overflow-hidden shadow-sm relative group">
                                            @if($curso->image)
                                                <img src="{{ Storage::url($curso->image->url) }}" alt="{{ $curso->title }}" class="w-full h-full object-cover">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($curso->title) }}&color=7F9CF5&background=EBF4FF" alt="{{ $curso->title }}" class="w-full h-full object-cover">
                                            @endif
                                            <div class="absolute inset-0 bg-primary/20 group-hover:bg-transparent transition-colors"></div>
                                        </div>

                                        {{-- Detalles y Progreso --}}
                                        <div class="flex-1 flex flex-col justify-center">
                                            <div class="flex items-start justify-between gap-4 mb-2">
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-900 leading-tight mb-1">{{ $curso->title }}</h4>
                                                    <p class="text-xs font-bold text-secondary uppercase tracking-wider">{{ $curso->Categoria->nombre ?? 'General' }}</p>
                                                </div>
                                                
                                                @php
                                                    $hasPassedExam = $alumno->examAttempts()
                                                        ->where('is_approved', 1)
                                                        ->whereHas('evaluation', function($q) use ($curso) {
                                                            $q->where('course_id', $curso->id);
                                                        })->exists();
                                                
                                                    $progreso = $hasPassedExam ? 100 : 0;
                                                @endphp
                                                
                                                <div class="text-right shrink-0">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $progreso == 100 ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                                        {{ $progreso == 100 ? 'Aprobado' : 'En curso' }}
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Barra de Progreso --}}
                                            <div class="mt-4">
                                                <div class="flex items-center justify-between text-xs font-bold mb-1.5">
                                                    <span class="text-gray-500 uppercase tracking-wider">Avance</span>
                                                    <span class="text-primary-600">{{ $progreso }}%</span>
                                                </div>
                                                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden shadow-inner">
                                                    <div class="h-full {{ $progreso == 100 ? 'bg-emerald-500' : 'bg-primary' }} rounded-full" style="width: {{ $progreso }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 px-6">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <i class="fas fa-folder-open text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Sin cursos asignados</h3>
                            <p class="text-gray-500 font-medium max-w-sm mx-auto">Este estudiante aún no está matriculado en ningún curso de la academia.</p>
                        </div>
                    @endif
                </div>
                
                {{-- Sección de Certificaciones / Exámenes (Opcional, se puede expandir luego) --}}
                <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                    <div class="p-6 md:p-8 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                        <div>
                            <h3 class="text-xl font-black text-primary-900 tracking-tight">Historial de Exámenes</h3>
                            <p class="text-sm text-gray-500 font-medium">Evaluaciones realizadas por el estudiante</p>
                        </div>
                        <a href="{{ route('admin.empresas.certificaciones.index') }}" class="text-secondary font-bold text-sm hover:underline">Ver todas <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    
                    <div class="p-6 md:p-8">
                        @php
                            $intentos = $alumno->examAttempts()->with('evaluation.exam')->latest()->take(5)->get();
                        @endphp
                        
                        @if($intentos->count() > 0)
                            <div class="space-y-4">
                                @foreach($intentos as $intento)
                                    @php
                                        $isGraded = in_array($intento->status, ['graded', 'finished']) && $intento->final_score !== null;
                                        $isPassed = $intento->is_approved;
                                        
                                        $iconBgClass = 'bg-blue-50 text-blue-500 border-blue-100';
                                        $iconClass = 'fa-spinner fa-spin';
                                        $textClass = 'text-primary';
                                        
                                        if ($isGraded) {
                                            if ($isPassed) {
                                                $iconBgClass = 'bg-emerald-50 text-emerald-500 border-emerald-100';
                                                $iconClass = 'fa-medal';
                                                $textClass = 'text-emerald-600';
                                            } else {
                                                $iconBgClass = 'bg-red-50 text-red-500 border-red-100';
                                                $iconClass = 'fa-times-circle';
                                                $textClass = 'text-red-600';
                                            }
                                        } elseif ($intento->status === 'void') {
                                            $iconBgClass = 'bg-gray-50 text-gray-500 border-gray-100';
                                            $iconClass = 'fa-ban';
                                            $textClass = 'text-gray-500';
                                        }
                                    @endphp
                                    <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-lg {{ $iconBgClass }} border flex items-center justify-center shrink-0">
                                                <i class="fas {{ $iconClass }} text-xl"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-sm md:text-base">{{ $intento->evaluation->exam->name ?? 'Examen Eliminado' }}</p>
                                                <p class="text-xs text-gray-500 font-medium"><i class="far fa-clock mr-1"></i> {{ $intento->created_at->format('d M, Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-5">
                                            <div class="text-right">
                                                <span class="block font-black {{ $textClass }} text-base md:text-lg leading-none mb-1">
                                                    {{ $intento->final_score !== null ? $intento->final_score . '%' : 'En curso' }}
                                                </span>
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                                    {{ $intento->final_score !== null ? 'Puntaje' : 'Estado' }}
                                                </span>
                                            </div>
                                            
                                            @if($isPassed)
                                                <a href="{{ route('exams.certificate', $intento->id) }}" target="_blank" title="Descargar Certificado" class="flex-shrink-0 flex items-center justify-center w-10 h-10 bg-white border border-yellow-200 text-yellow-600 rounded-xl hover:bg-yellow-50 hover:border-yellow-300 transition-all shadow-sm">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @else
                                                <div class="w-10"></div> {{-- Placeholder lateral para mantener la alineación --}}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 font-medium">El estudiante no ha presentado ningún examen todavía.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-admin-layout>
