<div>
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
                        <h1 class="text-3xl font-bold text-white">Lecciones del Curso</h1>
                        <p class="text-blue-100 mt-2 text-lg truncate max-w-2xl">Organiza secciones, lecciones y evaluaciones.</p>
                    </div>
                </div>

                <div class="p-10">
                <!-- Sections List -->
                <div class="space-y-6">
                    @foreach ($course->Seccion_curso as $item)
                        <article class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden transition hover:shadow-md" x-data="{ open: true }">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                                @if ($seccion->id == $item->id)
                                    <div class="animate-fade-in-down">
                                        <label class="block text-sm font-bold text-gray-700 uppercase mb-2">Editar Sección</label>
                                        <textarea wire:model="seccion.nombre" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-[#335A92] focus:border-[#335A92] transition" rows="2" placeholder="Ingrese el nombre de la sección"></textarea>
                                        @error('seccion.nombre')
                                            <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                                        @enderror
                                        <div class="flex justify-end mt-3 space-x-2">
                                            <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                                                wire:click="default">Cancelar</button>
                                            <button class="px-4 py-2 text-sm font-bold text-white bg-[#335A92] rounded-lg hover:bg-[#284672] transition shadow-sm"
                                                wire:click="update">Actualizar</button>
                                        </div>
                                    </div>
                                @else
                                    <header class="flex justify-between items-center">
                                        <div class="flex items-center cursor-pointer flex-1" x-on:click="open = !open">
                                            <i class="fas fa-layer-group text-[#335A92] mr-3 text-lg"></i>
                                            <h3 class="text-lg font-bold text-gray-800 hover:text-[#335A92] transition">
                                                Sección: {{ $item->nombre }}
                                            </h3>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button wire:click="edit({{ $item->id }})" class="text-gray-400 hover:text-[#335A92] transition" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-gray-400 hover:text-red-500 transition" title="Eliminar" wire:click="destroy({{ $item }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <button x-on:click="open = !open" class="text-gray-400 hover:text-gray-600 transition ml-2">
                                                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                            </button>
                                        </div>
                                    </header>
                                @endif
                            </div>

                            <div x-show="open" x-collapse class="bg-white">
                                <div class="p-6">
                                    @livewire('author.cursos-lecciones', ['seccion' => $item], key('lessons-'.$item->id))

                                    @php
                                        $supportsCourseContext = \Illuminate\Support\Facades\Schema::hasColumn('exam_evaluations', 'context_type')
                                            && \Illuminate\Support\Facades\Schema::hasColumn('exam_evaluations', 'section_id');
                                        $sectionEvaluations = collect();
                                        if ($supportsCourseContext) {
                                            $sectionEvaluations = \App\Models\ExamEvaluation::where('user_id', auth()->id())
                                                ->where('section_id', $item->id)
                                                ->where('context_type', 'course_section')
                                                ->latest()
                                                ->get();
                                        }
                                    @endphp

                                    <div class="mt-4 border-t border-gray-100 pt-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="font-bold text-gray-700">
                                                <i class="fas fa-clipboard-check text-[#335A92] mr-2"></i> Evaluación de Sección
                                            </h4>
                                            <a href="{{ route('author.exams.manager', ['create' => 1, 'target' => 'course', 'course_id' => $course->id, 'scope' => 'section', 'section_id' => $item->id]) }}"
                                               class="text-sm font-bold text-[#335A92] hover:text-[#284672]">
                                                <i class="fas fa-plus-circle mr-1"></i> Crear en Gestión Evaluaciones
                                            </a>
                                        </div>

                                        @if(!$supportsCourseContext)
                                            <div class="text-xs text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                                Ejecuta `php artisan migrate` para habilitar vínculo curso/sección en Gestión Evaluaciones.
                                            </div>
                                        @else
                                            <div class="space-y-2">
                                                @forelse($sectionEvaluations as $evaluation)
                                                    <div class="border border-gray-200 rounded-lg p-3 flex justify-between items-center">
                                                        <div>
                                                            <p class="font-semibold text-sm text-gray-800">{{ $evaluation->name }}</p>
                                                            <p class="text-xs text-gray-500">Intentos: {{ $evaluation->max_attempts }} · Aprueba: {{ $evaluation->passing_score }}%</p>
                                                        </div>
                                                        <a href="{{ route('author.exams.builder', $evaluation->id) }}"
                                                           class="text-xs font-bold text-[#335A92] bg-blue-50 border border-blue-100 px-3 py-2 rounded-lg hover:bg-blue-100 transition">
                                                            Preguntas
                                                        </a>
                                                    </div>
                                                @empty
                                                    <div class="text-xs text-gray-500 bg-gray-50 border border-gray-200 rounded-lg p-3">
                                                        No hay evaluación creada para esta sección.
                                                    </div>
                                                @endforelse
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Add New Section -->
                <div x-data="{ open: false }" class="mt-8">
                    <button x-show="!open" x-on:click="open = true" class="flex items-center justify-center w-full py-4 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 hover:border-[#335A92] hover:text-[#335A92] transition group cursor-pointer bg-gradient-to-r from-white to-gray-50">
                        <i class="fas fa-plus-circle text-2xl mr-2 group-hover:scale-110 transition-transform"></i>
                        <span class="font-bold text-lg">Crear nueva sección</span>
                    </button>

                    <article class="bg-white border border-[#335A92]/20 rounded-2xl shadow-lg overflow-hidden mt-4 animate-fade-in-up" x-show="open" style="display: none;">
                        <div class="px-6 py-6 bg-gradient-to-br from-[#335A92]/5 to-white">
                            <h2 class="text-lg font-bold text-gray-800 mb-1 flex items-center">
                                <i class="fas fa-plus-circle text-[#335A92] mr-2"></i> Nueva Sección
                            </h2>
                            <p class="text-sm text-gray-500 mb-4">Usa un nombre claro para organizar mejor el contenido del curso.</p>
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre de la sección</label>
                                <input wire:model="nombre" class="form-input w-full bg-white border-gray-300 rounded-xl focus:ring-[#335A92] focus:border-[#335A92] p-3 transition shadow-sm" placeholder="Ej: Introducción al Curso">
                                @error('nombre')
                                    <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                                    x-on:click="open = false">Cancelar</button>
                                <button class="px-5 py-2.5 text-sm font-bold text-white bg-[#335A92] hover:bg-[#284672] rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5"
                                    wire:click="store">Agregar Sección</button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
