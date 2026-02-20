<div>


    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                <h1 class="text-2xl font-bold text-white">Lecciones del Curso</h1>
                <p class="text-indigo-100 text-sm mt-1">Organiza el contenido de tu curso en secciones y lecciones.</p>
            </div>

            <div class="px-8 py-8">
                <!-- Sections List -->
                <div class="space-y-6">
                    @foreach ($course->Seccion_curso as $item)
                        <article class="bg-white border boundary-gray-200 rounded-xl shadow-sm overflow-hidden transition hover:shadow-md" x-data="{ open: true }">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                                @if ($seccion->id == $item->id)
                                    <div class="animate-fade-in-down">
                                        <label class="block text-sm font-bold text-gray-700 uppercase mb-2">Editar Sección</label>
                                        <textarea wire:model="seccion.nombre" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition" rows="2" placeholder="Ingrese el nombre de la sección"></textarea>
                                        @error('seccion.nombre')
                                            <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                                        @enderror
                                        <div class="flex justify-end mt-3 space-x-2">
                                            <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                                                wire:click="default">Cancelar</button>
                                            <button class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm"
                                                wire:click="update">Actualizar</button>
                                        </div>
                                    </div>
                                @else
                                    <header class="flex justify-between items-center">
                                        <div class="flex items-center cursor-pointer flex-1" x-on:click="open = !open">
                                            <i class="fas fa-layer-group text-indigo-500 mr-3 text-lg"></i>
                                            <h3 class="text-lg font-bold text-gray-800 hover:text-indigo-600 transition">
                                                Sección: {{ $item->nombre }}
                                            </h3>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button wire:click="edit({{ $item->id }})" class="text-gray-400 hover:text-indigo-500 transition" title="Editar">
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
                                    
                                    @livewire('author.evaluation-manager', ['section' => $item], key('eval-'.$item->id))
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Add New Section -->
                <div x-data="{ open: false }" class="mt-8">
                    <button x-show="!open" x-on:click="open = true" class="flex items-center justify-center w-full py-4 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 hover:border-indigo-500 hover:text-indigo-600 transition group cursor-pointer">
                        <i class="fas fa-plus-circle text-2xl mr-2 group-hover:scale-110 transition-transform"></i>
                        <span class="font-bold text-lg">Agregar nueva sección</span>
                    </button>

                    <article class="bg-white border border-indigo-100 rounded-xl shadow-lg overflow-hidden mt-4 animate-fade-in-up" x-show="open" style="display: none;">
                        <div class="px-6 py-6 bg-indigo-50/50">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-plus-circle text-indigo-500 mr-2"></i> Nueva Sección
                            </h2>
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre de la sección</label>
                                <input wire:model="nombre" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5 transition" placeholder="Ej: Introducción al Curso">
                                @error('nombre')
                                    <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                                    x-on:click="open = false">Cancelar</button>
                                <button class="px-5 py-2.5 text-sm font-bold text-white bg-greenLime_600 hover:bg-greenLime_500 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5"
                                    wire:click="store">Agregar Sección</button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
