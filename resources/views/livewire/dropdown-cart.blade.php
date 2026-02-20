<div>
    <x-dropdown width='96'>
        <x-slot name="trigger">
            <span class="relative inline-block cursor-pointer group">
                <x-cart color="white" size="30" class="group-hover:opacity-80 transition-opacity" />
                @if ($carlist !== null && $carlist->count())
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center text-[10px] font-bold leading-none text-white w-4 h-4 bg-red-500 rounded-full shadow-sm">{{ $carlist->count() }}</span>
                @endif
            </span>
        </x-slot>
        <x-slot name="content">
            <ul class="overflow-y-auto max-h-80">
                @isset($carlist)
                    @forelse ($carlist as $item)
                        <li class="flex p-3 border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <article class="flex-1">
                                <h1 class="font-bold text-gray-800 text-sm mb-1"> {{ $item->nombre }} </h1>
                                <p class="text-xs text-gray-500">Cant: 1 </p>
                                <p class="text-xs text-primary-600 font-bold">$ {{ number_format($item->price, 0, ',', '.') }} COP </p>
                            </article>
                        </li>
                    @empty
                        <li>
                            <p class="text-center text-gray-500 py-6 px-4 text-sm">
                                Tu carrito está vacío.
                            </p>
                        </li>
                    @endforelse
                @else
                    <li>
                        <p class="text-center text-gray-500 py-6 px-4 text-sm">
                            Tu carrito está vacío.
                        </p>
                    </li>
                @endisset
            </ul>
            @isset($carlist)
                @if ($carlist->count())
                    <div class="py-3 px-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-bold text-gray-600">Total:</span>
                            <span class="text-lg font-black text-primary-700">$ {{ number_format($carlist->sum('total'), 0, ',', '.') }}</span>
                        </div>
                        <x-button-enlace href="{{ route('shopping-cart') }}" class="w-full justify-center text-sm font-bold bg-primary-600 hover:bg-primary-700 text-white shadow-md rounded-lg py-2">
                            Ir al Carrito
                        </x-button-enlace>
                    </div>
                @endif
            @endisset
        </x-slot>
    </x-dropdown>
</div>
