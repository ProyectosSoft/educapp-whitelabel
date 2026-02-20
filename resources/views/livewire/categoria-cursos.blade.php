<div wire:init="loadPosts">
    @if (count($courses))
        <div class="glider-contain bg-greenLime_500">
            <ul class="glider">
                @foreach ($courses as $item)
                    <li class="bg-greenLime_50 rounded-lg shadow {{ $loop->last ?: 'sm:mr-4' }}">
                        <article>
                            {{-- <figure>
                            <img class="rounded-t-lg h-48 w-full object-cover"  src= "{{"data:image/image;base64," . base64_encode(Storage::get($item->image->url));}}" alt="">
                        </figure> --}}
                            <figure>
                                @isset($item->image)
                                    <img  class="rounded-t-lg h-48 w-full object-cover"
                                        src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($item->image->url)) }}"
                                        alt="">
                                @else
                                    <img class="rounded-t-lg h-48 w-full object-cover"
                                        src="https://images.pexels.com/photos/4497761/pexels-photo-4497761.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                                        alt="">
                                @endisset
                            </figure>
                            <div class="py-4 px-8">
                                <h1 class="text-lg text-greenLime_500 font-semibold">
                                    <a href="">
                                        {{ Str::limit($item->nombre, 25) }}
                                    </a>
                                </h1>
                                <p class="text-greenLime_500 text-sm mb-2 mt-auto">Prof: {{ $item->teacher->name }}</p>
                                <div class="flex">
                                    <ul class="flex text-sm">
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $item->rating >= 1 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $item->rating >= 2 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $item->rating >= 3 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $item->rating >= 4 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $item->rating == 5 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                    </ul>
                                    <p class="text-sm text-greenLime_500 ml-auto">
                                        <i class="fas fa-users"></i>
                                        ({{ $item->students_count }})
                                    </p>
                                </div>
                                @if ($item->precio->valor == 0)
                                    <a href={{ route('cursos.show', $item) }}
                                        class="block text-center w-full mt-4 bg-greenLime_500 hover: hover:bg-greenLime_400 text-white font-bold py-2 px-4 rounded-full mb-2">
                                        <p class="text-greenLime_50 font-bold"><i
                                                class="fas fa-shopping-cart  mr-4"></i>GRATIS</p>
                                    </a>
                                @else
                                    <a href={{ route('payment.checkout', $item) }}
                                        class="block text-center w-full mt-4 bg-greenLime_500 hover:bg-greenLime_400 text-white font-bold py-2 px-4 rounded-full mb-2 ">
                                        <p class="text-greenLime_50 font-bold"> <i
                                                class="fas fa-shopping-cart mr-4"></i>$
                                            {{ number_format($item->precio->valor, 0, ',', '.') }} COP</p>
                                    </a>
                                @endif
                                <a href={{ route('cursos.show', $item) }}
                                    class="block text-center w-full mt-4 bg-greenLime_500 hover:bg-greenLime_400 text-white font-bold py-2 px-4 rounded-full mb-2 ">
                                    <p class="text-greenLime_50 font-bold"><i class="fas fa-search-plus  mr-4"></i>Ver
                                        Detalles</p>
                                </a>
                            </div>
                        </article>
                    </li>
                @endforeach
            </ul>
            <button aria-label="Previous" class="glider-prev">«</button>
            <button aria-label="Next" class="glider-next">»</button>
            <div role="tablist" class="dots"></div>
        </div>
    @else
        <div class="mb-4 h-48 flex justify-center items-center bg-white shadow-xl border border-gray-100 rounded-lg">
            <div class="rounded animate-spin ease duration-300 w-10 h-10 border-2 border-indigo-500"></div>
        </div>
    @endif
</div>
