<div class="max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8 py-8">
    <section class="bg-white rounded-lg shadow-lg p-6 text-gray-700">
        <h1 class="text-lg font-semibold mb-6">FAVORITOS</h1>
        @isset($cursosEnWishlist)
            @forelse($cursosEnWishlist as $course)
                <ul>
                    <li class="bg-white rounded-3xl shadow-lg mb-6">
                        <article class="flex flex-col sm:flex-row items-center ml-4">
                            <figure class="sm:w-1/2 sm:pr-4 sm:mb-0 mr-4 mb-4 lg:w-1/4 lg:mb-0  lg:mt-0 mt-4">
                                <img class="h-48 w-full  object-cover object-center rounded-3xl"
                                    src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($course->image->url)) }}"
                                    alt="">
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
                                                <i
                                                    class="fas fa-star text-{{ $course->rating >= 1 ? 'orange' : 'gray' }}_50"></i>
                                            </li>
                                            <li class="mr-1">
                                                <i
                                                    class="fas fa-star text-{{ $course->rating >= 2 ? 'orange' : 'gray' }}}_50"></i>
                                            </li>
                                            <li class="mr-1">
                                                <i
                                                    class="fas fa-star text-{{ $course->rating >= 3 ? 'orange' : 'gray' }}}_50"></i>
                                            </li>
                                            <li class="mr-1">
                                                <i
                                                    class="fas fa-star text-{{ $course->rating >= 4 ? 'orange' : 'gray' }}}_50"></i>
                                            </li>
                                            <li class="mr-1">
                                                <i
                                                    class="fas fa-star text-{{ $course->rating >= 5 ? 'orange' : 'gray' }}}_50"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div class="sm:mt-2">
                                        @livewire('moreinformation', ['course' => $course])
                                    </div>
                                    <div class="sm:mt-2">
                                        <!-- Contenido de la segunda sección -->
                                        @livewire('add-cart-courses', ['course' => $course])
                                    </div>
                                    <div class="sm:mt-2">
                                        @livewire('remove-wish-list', ['course' => $course])
                                    </div>
                                </div>

                            </div>
                        </article>
                    </li>
                </ul>
            @empty
                <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        {{-- <span class="font-medium">alerta de información!</span> --}}
                         No tiene ningún curso agregado a favoritos
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="items-center">
                        <x-button-enlace href="/" class="mt-4 px-16">
                            IR AL INICIO
                        </x-button-enlace>
                    </div>
                </div>
            @endforelse
        @else
            <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    {{-- <span class="font-medium">alerta de información!</span> --}}
                    No tiene ningún curso agregado a favoritos
                </div>
            </div>
            <div class="flex justify-center">
                <div class="items-center">
                    <x-button-enlace href="/" class="mt-4 px-16">
                        IR AL INICIO
                    </x-button-enlace>
                </div>
            </div>
        @endisset
    </section>
</div>
