<div class="card shadow-md sm:rounded-lg overflow-hidden border border-gray-100" x-data="{open: false}">
    <div class="card-body bg-gray-50 px-6 py-4">
        <header>
             <h1 x-on:click="open = !open" class="cursor-pointer font-bold text-gray-800 flex items-center justify-between">
                Recursos de la lección
                <i class="fas fa-chevron-down text-sm text-gray-500 transition-transform duration-300 transform" :class="{'rotate-180': open}"></i>
            </h1>
        </header>

        <div x-show="open" x-transition class="mt-4">
            <hr class="border-gray-200 mb-4">
            @if ($leccion->resource)
                <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                    <div class="flex items-center text-sm text-gray-700 truncate">
                        <i class="fas fa-download text-indigo-500 mr-3 cursor-pointer hover:text-indigo-700" wire:click="download" title="Descargar"></i>
                        <span class="truncate">{{$leccion->resource->url}}</span>
                    </div>
                    <i wire:click="destroy" class="fas fa-trash text-red-400 cursor-pointer hover:text-red-600 ml-4 transition-colors" title="Eliminar"></i>
                </div>
            @else
                <form wire:submit.prevent="save">
                    <div class="flex items-center gap-2">
                        <input wire:model="file" type="file" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                        ">
                        <button type="submit" 
                            class="font-bold py-2 px-6 rounded-lg bg-indigo-600 text-white text-sm hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center shadow-md"
                            wire:loading.attr="disabled"
                            wire:target="file, save">
                            
                            <span wire:loading.remove wire:target="save">Guardar</span>
                            <span wire:loading wire:target="save" class="flex items-center">
                                <i class="fas fa-spinner fa-spin mr-2"></i> Subiendo...
                            </span>
                        </button>
                    </div>

                    <div class="text-indigo-500 font-bold mt-2 text-sm flex items-center animate-pulse" wire:loading wire:target="file">
                        <i class="fas fa-circle-notch fa-spin mr-2"></i> Cargando archivo...
                    </div>

                    @error('file')
                        <span class="text-xs text-red-500 mt-1 block"> {{$message}} </span>
                    @enderror
                </form>
            @endif
        </div>
    </div>
</div>
