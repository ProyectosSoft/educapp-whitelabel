<div>
    <x-dropdown width='96'>
        <x-slot name="trigger">
            <span class="relative inline-block cursor-pointer group">
                <x-wishlist color="white" size="30" class="group-hover:opacity-80 transition-opacity" />
                @if ($wishlist !== null && $wishlist->count())
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center text-[10px] font-bold leading-none text-white w-4 h-4 bg-red-500 rounded-full shadow-sm">{{ $wishlist->count() }}</span>
                @endif
            </span>
        </x-slot>
        <x-slot name="content">
            <ul class="overflow-y-auto max-h-80">
                @isset($wishlist)
                    @forelse ($wishlist as $item)
                        <li class="flex p-3 border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <article class="flex-1">
                                <h1 class="font-bold text-gray-800 text-sm mb-1"> {{ $item->nombre }} </h1>
                                <p class="text-xs text-primary-600 font-medium">Valor: $ {{ number_format($item->price, 0, ',', '.') }} COP </p>
                            </article>
                        </li>
                    @empty
                        <li>
                            <p class="text-center text-gray-500 py-6 px-4 text-sm">
                                No tienes cursos en favoritos.
                            </p>
                        </li>
                    @endforelse
                @else
                    <li>
                        <p class="text-center text-gray-500 py-6 px-4 text-sm">
                            No tienes cursos en favoritos.
                        </p>
                    </li>
                @endisset
            </ul>
            @isset($wishlist)
                @if ($wishlist->count())
                    <div class="py-3 px-4 bg-gray-50">
                        <x-button-enlace href="{{ route('wishlist') }}" class="w-full justify-center text-sm font-bold bg-primary-600 hover:bg-primary-700 text-white shadow-md">
                            Ir a favoritos
                        </x-button-enlace>
                    </div>
                @endif
            @endisset
        </x-slot>
    </x-dropdown>
</div>
