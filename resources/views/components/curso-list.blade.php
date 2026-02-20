@props(['course'])
<li class="bg-white rounded-3xl shadow-lg mb-6">
    <article class="flex flex-col sm:flex-row items-center ml-4">
        <figure class="sm:w-1/2 sm:pr-4 sm:mb-0 mr-4 mb-4 lg:w-1/4 lg:mb-0  lg:mt-0 mt-4 ">
            {{-- <img class="h-48 w-full  object-cover object-center rounded-3xl"
                src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($course->image->url)) }}"
                alt=""> --}}
            @isset($course->image)
                <img class="h-48 w-full  object-cover object-center rounded-3xl"
                    src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($course->image->url)) }}" alt="">
            @else
                <img class="h-48 w-full  object-cover object-center rounded-3xl"
                    src="https://images.pexels.com/photos/4497761/pexels-photo-4497761.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                    alt="">
            @endisset
        </figure>
        <div class="flex-1 py-4 px-6 flex flex-col">
            <div class="flex justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-greenLime_400"> {{ $course->nombre }} </h1>
                    @if ($course->precio->valor == 0)
                        <p class="my-2 text-green-700 font-bold">GRATIS</p>
                    @else
                        <p class="my-2 text-gray-500 font-bold">US$ {{ $course->precio->valor }}</p>
                    @endif
                    <p class="text-gray-500 text-sm mb-2 mt-auto">Prof: {{ $course->teacher->name }}</p>
                    <p class="text-gray-500 text-sm mb-2 mt-auto">Categoría:
                        {{ $course->categoria->nombre }}</p>
                    <p class="text-gray-500 text-sm mb-2 mt-auto">Nivel: {{ $course->nivel->nombre }}
                    </p>
                </div>
                <div class="flex items-center">
                    <ul class="flex text-sm">
                        <li class="mr-1">
                            <i class="fas fa-star text-{{ $course->rating >= 1 ? 'orange' : 'gray' }}_50"></i>
                        </li>
                        <li class="mr-1">
                            <i class="fas fa-star text-{{ $course->rating >= 2 ? 'orange' : 'gray' }}}_50"></i>
                        </li>
                        <li class="mr-1">
                            <i class="fas fa-star text-{{ $course->rating >= 3 ? 'orange' : 'gray' }}}_50"></i>
                        </li>
                        <li class="mr-1">
                            <i class="fas fa-star text-{{ $course->rating >= 4 ? 'orange' : 'gray' }}}_50"></i>
                        </li>
                        <li class="mr-1">
                            <i class="fas fa-star text-{{ $course->rating >= 5 ? 'orange' : 'gray' }}}_50"></i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="sm:mt-2">
                    @livewire('moreinformation', ['course' => $course])
                </div>
                {{-- <div class="sm:mt-2">
                    <!-- Contenido de la segunda sección -->
                    @livewire('add-cart-courses', ['course' => $course])
                </div>
                <div class="sm:mt-2">
                    @livewire('remove-wish-list', ['course' => $course])
                </div> --}}
            </div>

        </div>
    </article>
</li>
