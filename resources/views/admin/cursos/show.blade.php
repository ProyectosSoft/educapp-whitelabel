<x-admin-layout>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column: Main Content --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Course Header Card --}}
            <section class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
                
                {{-- Corporate Header --}}
                <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                            <i class="fas fa-graduation-cap text-2xl"></i>
                        </div>
                        <div>
                           <h2 class="text-xl font-bold tracking-tight">Revisión de Curso</h2>
                           <p class="text-blue-100 text-sm font-medium">Validación de contenido académico</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-8">
                        {{-- Course Image --}}
                        <div class="w-full md:w-1/3">
                            <figure class="relative aspect-video rounded-2xl overflow-hidden shadow-lg group border border-gray-100">
                                @if ($course->image)
                                    <img class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500" 
                                         src="{{ Storage::url($course->image->url) }}" 
                                         alt="{{ $course->title }}">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-300 text-4xl"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-[#335A92]/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute bottom-3 left-3 z-10">
                                    <span class="bg-[#ECBD2D] text-[#335A92] text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                        {{ $course->categoria->nombre }}
                                    </span>
                                </div>
                            </figure>
                        </div>

                        {{-- Course Details --}}
                        <div class="w-full md:w-2/3 flex flex-col justify-center">
                            <h1 class="text-3xl font-bold text-[#335A92] mb-3 leading-tight">
                                {{ $course->nombre }}
                            </h1>
                            <h2 class="text-gray-500 text-base mb-6 font-medium">{{ $course->subtitulo }}</h2>
                            
                            <div class="flex flex-wrap gap-4 text-sm">
                                <div class="flex items-center px-4 py-2 bg-gray-50 rounded-xl border border-gray-100 text-gray-600 font-bold">
                                    <i class="fas fa-layer-group text-[#477EB1] mr-2"></i>
                                    {{ $course->Nivel->nombre ?? 'Nivel General' }}
                                </div>
                                <div class="flex items-center px-4 py-2 bg-gray-50 rounded-xl border border-gray-100 text-gray-600 font-bold">
                                    <i class="fas fa-users text-[#477EB1] mr-2"></i>
                                    {{ $course->students_count }} Estudiantes
                                </div>
                                <div class="flex items-center px-4 py-2 bg-gray-50 rounded-xl border border-gray-100 text-gray-600 font-bold">
                                    <i class="fas fa-star text-[#ECBD2D] mr-2"></i>
                                    {{ $course->rating }} Valoración
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- What you will learn --}}
            <section class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-8">
                <h3 class="text-xl font-bold text-[#335A92] mb-6 flex items-center">
                    <div class="bg-blue-50 p-2 rounded-lg mr-3 text-[#335A92]">
                         <i class="fas fa-bullseye"></i>
                    </div>
                    Lo que aprenderás
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse ($course->Objetivo_curso as $goal)
                        <div class="flex items-start p-3 rounded-xl hover:bg-gray-50 transition-colors">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-gray-600 font-medium text-sm leading-relaxed">{{ $goal->nombre }}</span>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-8 bg-gray-50 rounded-xl text-gray-400 italic">
                            No hay metas definidas para este curso.
                        </div>
                    @endforelse
                </div>
            </section>

             {{-- Syllabus --}}
             <section class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-8">
                <h3 class="text-xl font-bold text-[#335A92] mb-6 flex items-center">
                    <div class="bg-blue-50 p-2 rounded-lg mr-3 text-[#335A92]">
                        <i class="fas fa-book-open"></i>
                    </div>
                    Temario del curso
                </h3>
                
                <div class="space-y-4">
                    @forelse ($course->Seccion_curso as $section)
                        <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <button @click="open = !open" class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-white transition-colors">
                                <span class="font-bold text-[#335A92]">{{ $section->nombre }}</span>
                                <div class="flex items-center text-gray-400">
                                    <span class="text-xs mr-3 font-medium">{{ $section->Leccion_curso->count() }} lecciones</span>
                                    <i class="fas fa-chevron-down transition-transform duration-300 transform" :class="{ 'rotate-180': open }"></i>
                                </div>
                            </button>
                            <div x-show="open" x-collapse class="bg-white border-t border-gray-100">
                                <ul class="divide-y divide-gray-50">
                                    @foreach ($section->Leccion_curso as $lesson)
                                        <li class="p-3 pl-6 flex items-center text-sm text-gray-600 hover:bg-blue-50/30 transition cursor-default">
                                            <i class="fas fa-play-circle text-[#477EB1] mr-3"></i>
                                            {{ $lesson->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 bg-gray-50 rounded-xl text-gray-400 italic">No hay secciones definidas</div>
                    @endforelse
                </div>
            </section>

            {{-- Description --}}
            <section class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-8">
                <h3 class="text-xl font-bold text-[#335A92] mb-4 flex items-center">
                     <div class="bg-blue-50 p-2 rounded-lg mr-3 text-[#335A92]">
                        <i class="fas fa-align-left"></i>
                    </div>
                    Descripción
                </h3>
                <div class="prose prose-blue prose-sm text-gray-600 max-w-none">
                    {!! $course->descripcion !!}
                </div>
            </section>
        </div>

        {{-- Right Column: Sidebar Actions --}}
        <div class="space-y-6">
            
            {{-- Instructor Card --}}
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                
                <div class="flex items-center mb-6 relative z-10">
                    <img class="h-16 w-16 rounded-full object-cover border-4 border-white shadow-md ring-2 ring-gray-50" 
                         src="{{ $course->teacher->profile_photo_url }}" 
                         alt="{{ $course->teacher->name }}">
                    <div class="ml-4">
                        <p class="text-[10px] text-[#ECBD2D] font-bold uppercase tracking-wider">Creado por</p>
                        <h3 class="text-lg font-bold text-[#335A92] leading-tight">{{ $course->teacher->name }}</h3>
                        <p class="text-xs text-gray-400 font-medium">{{ $course->teacher->email }}</p>
                    </div>
                </div>

                 {{-- Action Buttons --}}
                 <div class="space-y-3 pt-6 border-t border-gray-100 relative z-10">
                    <form action="{{ route('admin.cursos.aprobado', $course) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3.5 px-4 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-[#d4aa27] transition-all shadow-lg shadow-yellow-500/10 flex items-center justify-center transform hover:-translate-y-0.5 group">
                            <i class="fas fa-check-circle mr-2 text-xl group-hover:scale-110 transition-transform"></i> Aprobar Curso
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.cursos.observacion', $course) }}" class="w-full py-3.5 px-4 bg-white border-2 border-red-100 text-red-500 font-bold rounded-xl hover:bg-red-50 hover:border-red-200 transition-all flex items-center justify-center shadow-sm hover:shadow-md">
                        <i class="fas fa-ban mr-2"></i> Rechazar / Observar
                    </a>

                    <a href="{{ route('admin.cursos.index') }}" class="w-full py-3 px-4 text-gray-400 font-bold rounded-xl hover:text-[#335A92] hover:bg-gray-50 transition-all flex items-center justify-center text-sm">
                        <i class="fas fa-arrow-left mr-2"></i> Volver a la lista
                    </a>
                </div>
            </div>

            {{-- Requirements --}}
            <div class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-[#335A92] mb-4 flex items-center">
                    <i class="fas fa-list-ul mr-2"></i> Requisitos
                </h3>
                <ul class="space-y-3">
                    @forelse ($course->Requerimiento_curso as $requirement)
                        <li class="flex items-start text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <i class="fas fa-chevron-right text-[#ECBD2D] mt-1 mr-2 flex-shrink-0"></i>
                            <span class="font-medium">{{ $requirement->nombre }}</span>
                        </li>
                    @empty
                        <li class="text-gray-400 italic text-sm text-center py-4">Sin requisitos específicos</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</x-admin-layout>
