@props(['course'])

<article class="bg-greenLime_50 shadow-lg rounded-lg overflow-hidden flex flex-col">
    {{-- <img class="rounded-t-lg h-48 w-full object-cover"
        src= "{{ 'data:image/image;base64,' . base64_encode(Storage::get($course->image->url)) }}" alt=""> --}}
    @isset($course->image)
        <img class="rounded-t-lg h-48 w-full object-cover"
            src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($course->image->url)) }}" alt="">
    @else
        <img class="rounded-t-lg h-48 w-full object-cover"
            src="https://images.pexels.com/photos/4497761/pexels-photo-4497761.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
            alt="">
    @endisset
    <div class="px-8 py-4 flex-1 flex flex-col">
        <h1 class="text-xl text-greenLime_500  mb-2 leading-6">{{ Str::limit($course->nombre, 30) }}</h1>
        <p class="text-greenLime_500 text-sm mb-2 mt-auto">Prof: {{ $course->teacher->name }}</p>
        <div class="flex">
            <ul class="flex text-sm">
                <li class="mr-1">
                    <i class="fas fa-star text-{{ $course->rating >= 1 ? 'orange' : 'gray' }}_50"></i>
                </li>
                <li class="mr-1">
                    <i class="fas fa-star text-{{ $course->rating >= 2 ? 'orange' : 'gray' }}_50"></i>
                </li>
                <li class="mr-1">
                    <i class="fas fa-star text-{{ $course->rating >= 3 ? 'orange' : 'gray' }}_50"></i>
                </li>
                <li class="mr-1">
                    <i class="fas fa-star text-{{ $course->rating >= 4 ? 'orange' : 'gray' }}_50"></i>
                </li>
                <li class="mr-1">
                    <i class="fas fa-star text-{{ $course->rating >= 5 ? 'orange' : 'gray' }}_50"></i>
                </li>
            </ul>
            <p class="text-sm text-greenLime_500 ml-auto">
                <i class="fas fa-users"></i>
                ({{ $course->students_count }})
            </p>
        </div>
        @if ($course->precio->valor == 0)
            <a href={{ route('cursos.show', $course) }}
                class="block text-center w-full mt-4 bg-greenLime_500 hover: hover:bg-greenLime_400 text-white font-bold py-2 px-4 rounded-full mb-2">
                <p class="text-greenLime_50 font-bold"><i class="fas fa-shopping-cart  mr-4"></i>GRATIS</p>
            </a>
        @else
            <a href={{ route('payment.checkout', $course) }}
                class="block text-center w-full mt-4 bg-greenLime_500 hover:bg-greenLime_400 text-white font-bold py-2 px-4 rounded-full mb-2 ">
                <p class="text-greenLime_50 font-bold"> <i class="fas fa-shopping-cart mr-4"></i>$
                    {{ number_format($course->precio->valor, 0, ',', '.') }} COP</p>
            </a>
        @endif
        <a href={{ route('cursos.show', $course) }}
            class="block text-center w-full mt-2 bg-greenLime_500 hover:bg-greenLime_400 text-white font-bold py-2 px-4 rounded-full mb-2 ">
            <p class="text-greenLime_50 font-bold"><i class="fas fa-search-plus  mr-4"></i>Ver Detalles</p>
        </a>
    </div>
</article>
