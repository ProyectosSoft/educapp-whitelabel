<div class="space-y-4">
    @foreach ($course->Objetivo_curso as $item)
        <article class="bg-white border border-gray-200 rounded-lg shadow-sm transition hover:shadow-md">
            <div class="px-5 py-4">
                @if ($objetivo->id == $item->id)
                    <div class="animate-fade-in-down">
                        <textarea wire:model="objetivo.nombre" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5 transition text-sm" rows="2"></textarea>
                        @error('objetivo.nombre')
                            <span class="text-xs text-red-500 mt-1 block font-medium"> {{ $message }} </span>
                        @enderror
                        <div class="flex justify-end mt-3 space-x-2">
                            <button class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                                wire:click="default">Cancelar</button>
                            <button class="px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition"
                                wire:click="update">Actualizar</button>
                        </div>
                    </div>
                @else
                    <header class="flex justify-between items-start group">
                        <h3 class="text-gray-700 leading-relaxed text-sm flex-1 mr-4">
                            <i class="fas fa-check text-green-500 mr-2 mt-1 float-left"></i>
                            {{ $item->nombre }}
                        </h3>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center space-x-1 shrink-0">
                            <button wire:click="edit({{ $item }})" class="p-1.5 text-gray-400 hover:text-indigo-500 transition rounded-md hover:bg-indigo-50" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="destroy({{ $item }})" class="p-1.5 text-gray-400 hover:text-red-500 transition rounded-md hover:bg-red-50" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </header>
                @endif
            </div>
        </article>
    @endforeach

    <article class="mt-6">
        <div x-data="{ open: false }">
             <button x-show="!open" x-on:click="open = true" class="flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition cursor-pointer">
                <i class="fas fa-plus-circle mr-2"></i>
                Agregar nueva meta
            </button>
            
            <div x-show="open" style="display: none;" class="mt-3 bg-gray-50 border border-gray-200 rounded-lg p-4 animate-fade-in-up">
                <form wire:submit.prevent="store">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nueva Meta</label>
                    <textarea wire:model="nombre" class="form-input w-full bg-white border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5 transition text-sm" rows="2" placeholder="Ej: Dominar los fundamentos de Laravel..."></textarea>
                    
                    @error('nombre')
                        <span class="text-xs text-red-500 mt-1 block font-medium"> {{ $message }} </span>
                    @enderror
                    
                    <div class="flex justify-end mt-3 space-x-2">
                        <button type="button" class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                            x-on:click="open = false">Cancelar</button>
                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-white bg-greenLime_600 hover:bg-greenLime_500 rounded-lg shadow-sm hover:shadow transition">
                            Agregar Meta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </article>
</div>
