<div>
    <article class="card shadow-md sm:rounded-lg overflow-hidden border border-gray-100" x-data="{open: false}">
        <div class="card-body bg-gray-50 px-6 py-4">
            <header>
                <h1 x-on:click="open = !open" class="cursor-pointer font-bold text-gray-800 flex items-center justify-between">
                    Descripción de la lección
                    <i class="fas fa-chevron-down text-sm text-gray-500 transition-transform duration-300 transform" :class="{'rotate-180': open}"></i>
                </h1>
            </header>
            <div x-show="open" x-transition class="mt-4">
                <hr class="border-gray-200 mb-4">
                @if ($leccion->descripcion)
                    <form wire:submit.prevent="update">
                        <textarea wire:model="descripcion.nombre" class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3"></textarea>
                        @error('descripcion.nombre')
                            <span class="text-xs text-red-500 mt-1 block"> {{$message}} </span>
                        @enderror

                        <div class="mt-4 flex justify-end gap-2">
                            <button type="button" class="font-bold py-2 px-4 rounded-lg bg-red-500 text-white text-sm hover:bg-red-600 transition-colors shadow-sm" wire:click="destroy">Eliminar</button>
                            <button type="submit" class="font-bold py-2 px-4 rounded-lg bg-indigo-600 text-white text-sm hover:bg-indigo-700 transition-colors shadow-sm" wire:loading.attr="disabled" wire:target="update">
                                <span wire:loading.remove wire:target="update">Actualizar</span>
                                <span wire:loading wire:target="update"><i class="fas fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </form>
                @else
                    <div>
                        <textarea wire:model="nombre" class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3" placeholder="Ingrese una descripción para la lección..."></textarea>
                        @error('nombre')
                            <span class="text-xs text-red-500 mt-1 block"> {{$message}} </span>
                        @enderror

                        <div class="mt-4 flex justify-end">
                            <button wire:click="store" class="font-bold py-2 px-6 rounded-lg bg-indigo-600 text-white text-sm hover:bg-indigo-700 transition-colors shadow-sm flex items-center" wire:loading.attr="disabled" wire:target="store">
                                <span wire:loading.remove wire:target="store">Agregar</span>
                                <span wire:loading wire:target="store"><i class="fas fa-spinner fa-spin mr-2"></i> Guardando...</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </article>
</div>
