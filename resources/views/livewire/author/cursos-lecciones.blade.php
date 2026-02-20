<div class="mt-4 space-y-4">
    {{-- {{$slug}} --}}
    @foreach ($seccion->Leccioncurso as $item)
        <article class="bg-white border border-gray-100 rounded-lg shadow-sm overflow-hidden transition hover:shadow-md" x-data="{ open: false }">
            <div class="px-4 py-3">
                @if ($leccion->id == $item->id)
                    <form wire:submit.prevent="update">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre:</label>
                                <input wire:model="leccion.nombre" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2 text-sm">
                                @error('leccion.nombre')
                                    <span class="text-xs text-red-500 mt-1 block"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                     <label class="block text-xs font-bold text-gray-500 uppercase mb-1">URL (Opcional):</label>
                                     <input wire:model="leccion.url" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2 text-sm">
                                     @error('leccion.url')
                                        <span class="text-xs text-red-500 mt-1 block"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="flex items-center">
                                    {{-- Placeholder for platform or other fields if needed --}}
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end space-x-2">
                             <button type="button" wire:click="cancel"
                                class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancelar</button>
                            <button type="submit"
                                class="px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">Actualizar</button>
                        </div>
                    </form>
                @else
                    <header class="flex justify-between items-center group">
                        <h1 x-on:click="open = !open" class="cursor-pointer flex items-center text-gray-700 font-medium hover:text-indigo-600 transition flex-1">
                            <i class="far fa-play-circle text-indigo-500 mr-3 text-lg"></i>
                            {{ $item->nombre }}
                        </h1>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center space-x-2">
                             <button class="text-gray-400 hover:text-indigo-500 p-1" wire:click="edit({{ $item }})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-gray-400 hover:text-red-500 p-1" wire:click="destroy({{ $item }})" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                             <button x-on:click="open = !open" class="text-gray-400 hover:text-gray-600 p-1 ml-1">
                                <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                        </div>
                    </header>

                    <div x-show="open" x-collapse class="mt-4 border-t border-gray-100 pt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 mb-4">
                            <div>
                                <span class="font-bold text-gray-500">Plataforma:</span> {{ $item->platform->nombre ?? 'N/A' }}
                            </div>
                            <div>
                                <span class="font-bold text-gray-500">Video:</span>
                                <a class="text-indigo-600 hover:underline truncate inline-block max-w-xs align-bottom" href="{{ $item->url }}" target="_blank">
                                    {{ $item->url }}
                                </a>
                            </div>
                        </div>

                        <div class="mb-4">
                            @livewire('author.lecciones-descripcion', ['leccion' => $item], key('lecciones-descripcion-' . $item->id))
                        </div>
                        <div>
                            @livewire('author.lecciones-resources', ['leccion' => $item], key('lecciones-resources-' . $item->id))
                        </div>
                    </div>
                @endif
            </div>
        </article>
    @endforeach

    <div class="mt-6" x-data="{ open: false }">
        <button x-show="!open" x-on:click="open = true" class="flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition cursor-pointer ml-2">
            <i class="fas fa-plus mr-2"></i>
            Agregar nueva lección
        </button>
        
        <article class="bg-white border border-indigo-100 rounded-lg shadow-md overflow-hidden mt-2 animate-fade-in-up" x-show="open" style="display: none;">
            <div class="px-6 py-4 bg-indigo-50/30">
                <h2 class="text-sm font-bold text-gray-800 mb-3">Nueva Lección</h2>

                <div class="mb-3">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre:</label>
                    <input id="nombre" wire:model="nombre" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2 text-sm"
                        placeholder="Ingresar el nombre de la lección">
                    @error('nombre')
                        <span class="text-xs text-red-500 mt-1 block"> {{ $message }} </span>
                    @enderror
                </div>

                {{-- <div class="mb-3">
                     <label class="block text-xs font-bold text-gray-500 uppercase mb-1">URL:</label>
                     <input wire:model="url" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2 text-sm">
                      @error('url')
                        <span class="text-xs text-red-500 mt-1 block"> {{ $message }} </span>
                    @enderror
                </div> --}}

                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    
                    <div class="mb-3">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Video:</label>
                         <input wire:model="video" type="file" accept="video/*" class="block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-xs file:font-semibold
                          file:bg-indigo-50 file:text-indigo-700
                          hover:file:bg-indigo-100
                        "/>
                        @error('video')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div wire:loading wire:target="video" class="w-full text-indigo-600 text-sm mb-2 font-medium">
                        Cargando video...
                    </div>

                    <!-- Progress Bar -->
                    <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-1.5 mb-4">
                        <div class="bg-indigo-600 h-1.5 rounded-full" :style="'width: ' + progress + '%'"></div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                            x-on:click="open = false">Cancelar</button>
                        <button class="px-3 py-1.5 text-xs font-bold text-white bg-greenLime_600 hover:bg-greenLime_500 rounded-lg shadow hover:shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                            wire:click="store"
                            wire:loading.attr="disabled"
                            wire:target="store">
                            <span wire:loading.remove wire:target="store">Agregar</span>
                            <span wire:loading wire:target="store" class="flex items-center">
                                <i class="fas fa-spinner fa-spin mr-2"></i> Guardando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>

