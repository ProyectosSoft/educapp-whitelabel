<div>
    <div>
        <x-button wire:click="removeItem" wire:loading.attr="disabled" wire:target="removeItem"
        class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-greenLime_50  hover:bg-greenLime_400 mt-2 block text-center w-full">
        <a href={{ route('cursos.show', $course) }}>
            <i class="fas fa-ellipsis-h mr-2"></i>
            Más Información
        </a>
    </x-button>
    </div>
    {{-- <div>
        <button
            class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-greenLime_50  hover:bg-greenLime_400 mt-2 block text-center w-full">
            <!-- Contenido de la primera sección -->
            <a href={{ route('cursos.show', $course) }}>
                <i class="fas fa-ellipsis-h mr-2"></i>
                Más Información
            </a>
        </button>
    </div> --}}
</div>
