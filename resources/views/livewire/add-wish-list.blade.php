<div>
    <div>
        <button
            class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-greenLime_50  hover:bg-greenLime_400 mt-2 block text-center w-full"
            wire:click="addWishList" wire:loading.attr="disabled" wire:target="addWishList">
            <i class="fa-heart fas mr-2"></i>
            Añadir a favoritos
        </button>
    </div>
    <div>
        <div>
            <br>
            @if ($successMessage)
                <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info </span>
                    <div>
                        {{-- <span class="font-medium">Alerta de éxito!</span>  --}}
                        {{ $successMessage }}
                    </div>
                </div>
            @endif

            @if ($errorMessage)
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                {{-- <span class="font-medium">alerta de información!</span>  --}}
                {!! str_replace('<a ', '<a class="underline font-bold" ', $errorMessage) !!}
            </div>
        </div>
            @endif
        </div>
    </div>
</div>

