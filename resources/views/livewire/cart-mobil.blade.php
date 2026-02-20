<div>
    <div>
        <a href="{{route('shopping-cart')}}"
            class="py-2 px-4 text-sm flex items-center text-greenLime_400 hover:bg-greenLime_400 hover:text-white">
            <span class="flex justify-center w-9">
                <i class="fas fa-shopping-cart"></i>
            </span>
            <span class="relative inline-block pr-4">
                Carrito de compras
                @livewire('span-cart')
            </span>
        </a>
    </div>

    <div>
        <a href="{{ route('wishlist') }}"
            class="py-2 px-4 text-sm flex items-center text-greenLime_400 hover:bg-greenLime_400 hover:text-white">
            <span class="flex justify-center w-9">
                <i class="fas fa-heart"></i>
            </span>
            <span class="relative inline-block pr-4">
                Mis favoritos
                @livewire('span-wishlist')
            </span>
        </a>
    </div>
</div>
