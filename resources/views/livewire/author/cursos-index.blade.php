<div class="space-y-8">
    
    {{-- Studio Header --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-4 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#335A92] tracking-tight">Mis Cursos</h1>
            <p class="text-gray-500 mt-2 text-lg">Gestiona tu contenido educativo y monitorea el progreso.</p>
        </div>
        
        <div class="flex items-center gap-3">
             <div class="relative">
                <input wire:keydown.debounce.500ms="limpiar_page" wire:model="search" type="text" 
                       class="w-full md:w-64 bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block pl-10 p-3 shadow-sm transition-all" 
                       placeholder="Buscar curso...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
            
            <a href="{{ route('author.cursos.create') }}" class="px-6 py-3 bg-[#ECBD2D] hover:bg-[#d4aa27] text-[#335A92] font-bold rounded-xl transition-all shadow-md hover:shadow-lg flex items-center transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i> Crear Curso
            </a>
        </div>
    </div>

    {{-- Course Grid --}}
    @if ($courses->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($courses as $course)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full group relative overflow-hidden">
                    
                    {{-- Enrollment Badge --}}
                    {{-- <div class="absolute top-3 right-3 z-10">
                        <span class="bg-white/90 backdrop-blur-sm text-gray-600 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                            <i class="fas fa-users text-[#335A92] mr-1"></i> {{ $course->students_count }}
                        </span>
                    </div> --}}

                    {{-- Image Cover --}}
                    <div class="relative aspect-video overflow-hidden bg-gray-100">
                        @isset($course->image)
                            <img class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700" src="{{ Storage::url($course->image->url) }}" alt="{{ $course->nombre }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-300">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endisset
                        
                        {{-- Overlay Gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity"></div>
                        
                        {{-- Status Badge --}}
                        <div class="absolute bottom-3 left-3">
                            @switch($course->status)
                                @case(1)
                                    <span class="bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm flex items-center">
                                        <i class="fas fa-edit mr-1.5"></i> Borrador
                                    </span>
                                    @break
                                @case(2)
                                    <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm flex items-center">
                                        <i class="fas fa-clock mr-1.5"></i> Revisión
                                    </span>
                                    @break
                                @case(3)
                                    <span class="bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm flex items-center">
                                        <i class="fas fa-check-circle mr-1.5"></i> Publicado
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex items-center text-xs text-blue-500 font-bold mb-2 uppercase tracking-wide">
                            <span class="bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                {{ $course->categoria->nombre }}
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 leading-tight group-hover:text-[#335A92] transition-colors">
                            {{ $course->nombre }}
                        </h3>
                        
                        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between text-sm text-gray-500">
                            {{-- <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1.5"></i>
                                <span class="font-bold text-gray-700">{{ $course->rating }}</span>
                            </div> --}}
                            <div class="flex items-center font-medium">
                                <i class="fas fa-user-graduate mr-1.5 text-gray-400"></i> {{ $course->students_count }} Estudiantes
                            </div>

                             {{-- Action Button --}}
                            {{-- <a href="{{ route('author.cursos.edit', $course) }}" class="text-[#335A92] hover:text-[#284672] font-bold p-2 hover:bg-blue-50 rounded-lg transition-colors" title="Editar Curso">
                                <i class="fas fa-pencil-alt"></i>
                            </a> --}}
                        </div>
                         
                         <a href="{{ route('author.cursos.edit', $course) }}" class="mt-4 w-full py-2.5 bg-gray-50 hover:bg-[#335A92] text-gray-600 hover:text-white font-bold rounded-xl transition-all border border-gray-100 hover:border-[#335A92] flex items-center justify-center group/btn shadow-sm">
                            <span class="group-hover/btn:hidden">Gestionar Curso</span>
                            <span class="hidden group-hover/btn:inline-block"><i class="fas fa-cog mr-2"></i> Administrar</span>
                        </a>

                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 px-4">
            {{ $courses->links() }}
        </div>
    @else
        <div class="bg-white rounded-[2rem] p-16 text-center border-2 border-dashed border-gray-200">
            <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-layer-group text-5xl text-blue-200"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Comienza tu viaje como instructor</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Aún no has creado ningún curso. ¡Comparte tu conocimiento con el mundo hoy mismo!</p>
             <a href="{{ route('author.cursos.create') }}" class="inline-flex items-center px-8 py-4 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-[#d4aa27] transition shadow-lg shadow-yellow-500/20 text-lg">
                <i class="fas fa-plus-circle mr-2"></i> Crear mi Primer Curso
            </a>
        </div>
    @endif
</div>
