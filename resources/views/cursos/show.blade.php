<x-app-layout>
    @if (auth()->user())
        @if (false) {{-- (!auth()->user()->email_verified_at) --}}
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gre">
                <div class="bg-white shadow-lg rounded-3xl overflow-hidden text-gray-600 imagen2">
                    <h1 class="text-greenLime_500 text-3xl font-bold mb-4 flex  justify-center  mt-6">
                        <div class="text-orange-400 mr-6"><i class="fas fa-exclamation-triangle"></i></div> Validar Correo
                        <div class="text-orange-400 ml-6"><i class="fas fa-exclamation-triangle"></i></div>
                    </h1>
                    <p class="text-lg text-greenLime_400 m-4 text-justify">Para garantizar la seguridad de la identidad,
                        recibiste un correo con el asunto "Verify Email Address" y dentro del mensaje se encuentra un
                        link que tienes que usar para certificar que tu eres el propiertario de la cuenta de correo
                        inscrita. </p>
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <button
                            class="font-bold py-2 px-4 rounded-full bg-greenLime_400 text-greenLime_50 hover:bg-greenLime_500 mt-4 block text-center mx-auto"
                            href=" {{ __('Log Out') }}">
                            Validar correo
                        </button>
                    </form>
                    <br />
                </div>
            @else
                @if (auth()->user()->roles->pluck('name')->implode(' '))
                    <section class="bg-greenLime_400 py-12 mb-12 imagen">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <figure>
                                {{-- <img class="h-66 w-full object-cover rounded-3xl"
                                    style="box-shadow: -12px 12px 32px 2px #000;"
                                    src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($course->image->url)) }}"
                                    alt=""> --}}
                                @isset($course->image)
                                    <img class="h-66 w-full object-cover rounded-3xl"
                                        style="box-shadow: -12px 12px 32px 2px #000;"
                                        src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($course->image->url)) }}"
                                        alt="">
                                @else
                                    <img class="h-66 w-full object-cover rounded-3xl"
                                        style="box-shadow: -12px 12px 32px 2px #000;"
                                        src="https://images.pexels.com/photos/4497761/pexels-photo-4497761.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                                        alt="">
                                @endisset
                            </figure>
                            <div class="text-white">
                                <h1 class="text-4xl text-greenLime_50">{{ $course->nombre }}</h1>
                                <h2 class="text-xl mb-3">{{ $course->subtituilo }}</h2>
                                <p class="mb-2"><i class="fas fa-chart-line"></i> {{ $course->Nivel->nombre }}</p>
                                <p class="mb-2"><i class="fas fa-users"></i> Matriculados:
                                    {{ $course->students_count }}</p>
                                <p class="mb-2"><i class="fas fa-star"></i> Calificación: {{ $course->rating }}</p>
                                <p class="mb-2"><i class="fas fa-edit"></i> Categoría:
                                    {{ $course->Categoria->nombre }}</p>
                            </div>
                        </div>
                    </section>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="order-2 lg:col-span-2 lg:order-1">
                            <section class="bg-white shadow-lg rounded-3xl overflow-hidden">
                                <div class="px-6 py-4">
                                    <h1 class="font-bold text-2xl text-greenLime_400 mb-2">Lo que aprenderás</h1>
                                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                                        @foreach ($course->Objetivo_curso as $objetivo)
                                            <li class="text-gray-700-base"><i
                                                    class="fas fa-check text-gray-600 mr-2"></i>{{ $objetivo->nombre }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </section>
                            <section>
                                <h1 class="font-fold text-3xl mb-2 text-greenLime_400 mt-4">Temario</h1>
                                @foreach ($course->Seccion_curso as $seccion)
                                    <article class="mb-4 shadow rounded-3xl bg-greenLime_400"
                                        @if ($loop->first) x-data="{open: true}"
                                @else
                                    x-data="{open: false}" @endif>


                                        <header
                                            class="border border-greenLime_400 px-4 py-2 cursor-pointer bg-greenLime_400 rounded-3xl"
                                            x-on:click="open = !open">
                                            <h1 class="font-bold text-lg text-greenLime_50">{{ $seccion->nombre }}</h1>
                                        </header>
                                        <div class="bg-white py-2 px-4 rounded-b-3xl " x-show="open">
                                            <ul class="grid grid-cols-1 gap-2">
                                                @foreach ($seccion->Leccioncurso as $leccion)
                                                    <li class="text-gray-700 text-base"><i
                                                            class="fas fa-play-circle mr-2 text-gray-600"></i>{{ $leccion->nombre }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </article>
                                @endforeach
                            </section>
                            <section class="bg-white shadow-lg rounded-3xl overflow-hidden" mb-4>
                                <div class=" py-2 px-4">
                                    <h1 class="font-bold text-3xl  text-greenLime_400">Requisitos</h1>
                                    <ul class="list-disc list-inside">
                                        @foreach ($course->Requerimiento_curso as $Requerimiento_curso)
                                            <li class="text-gray-700 text-base"> {{ $Requerimiento_curso->nombre }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </section>
                            <section class="bg-white shadow-lg rounded-3xl overflow-hidden mt-4">
                                <div class=" py-2 px-4">
                                    <h1 class="font-bold text-3xl  text-greenLime_400">Descripción</h1>
                                    <div class="text-gray-700 text-bae">
                                        {!! $course->descripcion !!}
                                        <div>
                                            <div class=" py-2 px-4">
                            </section>
                            @livewire('reseña-cursos', ['course' => $course])
                        </div>
                        <div class="order-1 lg:order-2">
                            <section class="bg-white shadow-lg rounded-3xl overflow-hidden mb-4">
                                <div class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img class="h-12 w-12 object-cover rounded-full shadow-lg"
                                            src="{{ $course->teacher->profile_photo_url }}"
                                            alt="{{ $course->teacher->name }}">
                                        <div class="ml-4">
                                            <h1 class="font-fold text-gray-500 text-lg">Prof.
                                                {{ $course->teacher->name }} </h1>
                                            <a class="text-blue-400 text-sm font-bold"
                                                href="">{{ '@' . Str::slug($course->teacher->name, '') }}</a>
                                        </div>
                                    </div>
                                    @can('matriculado', $course)
                                        <a class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-white hover:bg-greenLime_400 mt-4 block text-center"
                                            href="{{ route('cursos.status', $course) }}">Continuar con el curso</a>

                                        @if ($garantiaValida)
                                            {{-- <a class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-white hover:bg-greenLime_400 mt-4 block text-center"
                                                href="{{ route('cursos.status', $course) }}">Solicitar Reembolso</a> --}}
                                            <form action="{{ route('cursos.solicitarReembolso', $course) }}"
                                                method="post">
                                                @csrf
                                                <button
                                                    class="font-bold py-2 px-4 w-full rounded-full bg-red-500 text-white hover:bg-red-400 mt-4 block text-center">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Solicitar Reembolso
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        @if ($course->precio->valor == 0)
                                            <form action="{{ route('cursos.matriculado', $course) }}" method="post">
                                                @csrf
                                                @if ($course->precio->valor == 0)
                                                    <p class="text-2xl font-bold text-greenLime_400 mt-3 mb-2"> GRATIS </p>
                                                @else
                                                    <p class="text-2xl font-bold text-greenLime_400 mt-3 mb-2">$
                                                        {{ number_format($course->precio->valor, 0, ',', '.') }} COP </p>
                                                @endif
                                                <button
                                                    class="font-bold py-2 px-4 w-full rounded-full bg-greenLime_500 text-greenLime_50 hover:bg-greenLime_400 mt-4 block text-center">
                                                    <i class="fas fa-star"></i>
                                                    Iniciar curso</button>
                                            </form>

                                            {{-- @livewire('add-cart-courses', ['course' => $course]) --}}
                                            @livewire('add-wish-list', ['course' => $course])
                                        @else
                                            <p class="text-2xl font-bold text-greenLime_400 mt-3 mb-2">$
                                                {{ number_format($course->precio->valor, 0, ',', '.') }} COP </p>
                                            <a href="{{ route('payment.checkout', $course) }}"
                                                class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-greenLime_50  hover:bg-greenLime_400 mt-4 block text-center">
                                                <i class="far fa-credit-card mr-2"></i>
                                                Comprar este curso
                                            </a>

                                            @livewire('add-cart-courses', ['course' => $course])
                                            @livewire('add-wish-list', ['course' => $course])

                                            {{-- <div class="flex space-x-2">
                                                    <button class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-greenLime_50  hover:bg-greenLime_400 mt-2 block text-center w-full" wire:click="add_to_cart" wire:loading.attr="disabled" wire:target="add_to_cart">
                                                        Eliminar del carrito
                                                    </button>
                                                    <button class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-greenLime_50  hover:bg-greenLime_400 mt-2 block text-center" wire:click="add_to_wishlist" wire:loading.attr="disabled" wire:target="add_to_wishlist">
                                                        <i class="fa-heart fas"></i>
                                                    </button>
                                                </div> --}}
                                        @endif
                                    @endcan
                                </div>
                            </section>
                            <aside class="hidden lg:block bg-white rounded-3xl">
                                <br>
                                @foreach ($similares as $similar)
                                    <article class="flex m-6">
                                        {{-- <img class="h-25 w-40 object-cover rounded-2xl"
                                            src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($similar->image->url)) }}"
                                            atl=""> --}}
                                        @isset($similar->image)
                                            <img class="h-25 w-40 object-cover rounded-2xl"
                                                src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($similar->image->url)) }}"
                                                alt="">
                                        @else
                                            <img class="h-25 w-40 object-cover rounded-2xl"
                                                src="https://images.pexels.com/photos/4497761/pexels-photo-4497761.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                                                alt="">
                                        @endisset
                                        <div class="ml-3">
                                            <h1>
                                                <a class="font-bold text-greenLime_400 mb-3"
                                                    href="{{ route('cursos.show', $similar) }}">{{ Str::limit($similar->nombre, 40) }}</a>
                                            </h1>
                                            <div class="flex items-center">
                                                <img class="h6 w-6 object-cover rounded-full shadow-lg"
                                                    src="{{ $similar->teacher->profile_photo_url }}" alt="">
                                                <p class="text-greenLime_400 text-sm ml-2">
                                                    {{ $similar->teacher->name }}</p>
                                            </div>
                                            <div class="flex mt-2">
                                                <ul class="flex text-sm">
                                                    <li class="mr-1">
                                                        <i
                                                            class="fas fa-star text-{{ $similar->rating >= 1 ? 'orange' : 'gray' }}_50"></i>
                                                    </li>
                                                    <li class="mr-1">
                                                        <i
                                                            class="fas fa-star text-{{ $similar->rating >= 2 ? 'orange' : 'gray' }}_50"></i>
                                                    </li>
                                                    <li class="mr-1">
                                                        <i
                                                            class="fas fa-star text-{{ $similar->rating >= 3 ? 'orange' : 'gray' }}_50"></i>
                                                    </li>
                                                    <li class="mr-1">
                                                        <i
                                                            class="fas fa-star text-{{ $similar->rating >= 4 ? 'orange' : 'gray' }}_50"></i>
                                                    </li>
                                                    <li class="mr-1">
                                                        <i
                                                            class="fas fa-star text-{{ $similar->rating == 5 ? 'orange' : 'gray' }}_50"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                                <br>
                            </aside>
                        </div>
                    </div>
                @else
                    @php
                        header('Location: /perfil');
                        exit();
                    @endphp
                @endif
        @endif
    @else
        <section class="bg-greenLime_400 py-12 mb-12 imagen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <figure>
                    {{-- <img class="h-60 w-full object-cover" src="{{Storage::url($course->image->url)}}" alt=""> --}}
                    {{-- <img class="h-66 w-full object-cover rounded-3xl" style="box-shadow: -12px 12px 32px 2px #000;"
                        src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($course->image->url)) }}"
                        alt=""> --}}
                    @isset($course->image)
                        <img class="h-66 w-full object-cover rounded-3xl" style="box-shadow: -12px 12px 32px 2px #000;"
                            src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($course->image->url)) }}"
                            alt="">
                    @else
                        <img class="h-66 w-full object-cover rounded-3xl" style="box-shadow: -12px 12px 32px 2px #000;"
                            src="https://images.pexels.com/photos/4497761/pexels-photo-4497761.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                            alt="">
                    @endisset
                </figure>
                <div class="text-white">
                    <h1 class="text-4xl text-greenLime_50">{{ $course->nombre }}</h1>
                    <h2 class="text-xl mb-3">{{ $course->subtituilo }}</h2>
                    <p class="mb-2"><i class="fas fa-chart-line"></i> {{ $course->Nivel->nombre }}</p>
                    <p class="mb-2"><i class="fas fa-users"></i> Matriculados: {{ $course->students_count }}</p>
                    <p class="mb-2"><i class="fas fa-star"></i> Calificación: {{ $course->rating }}</p>
                    <p class="mb-2"><i class="fas fa-edit"></i> Categoría: {{ $course->Categoria->nombre }}</p>
                </div>
            </div>
        </section>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="order-2 lg:col-span-2 lg:order-1">
                <section class="bg-white shadow-lg rounded-3xl overflow-hidden">
                    <div class="px-6 py-4">
                        <h1 class="font-bold text-2xl text-greenLime_400 mb-2">Lo que aprenderás</h1>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                            @foreach ($course->Objetivo_curso as $objetivo)
                                <li class="text-gray-700-base"><i
                                        class="fas fa-check text-gray-600 mr-2"></i>{{ $objetivo->nombre }}</li>
                            @endforeach
                        </ul>
                    </div>
                </section>
                <section>
                    <h1 class="font-fold text-3xl mb-2 text-greenLime_400 mt-4">Temario</h1>
                    @foreach ($course->Seccion_curso as $seccion)
                        <article class="mb-4 shadow rounded-3xl bg-greenLime_400"
                            @if ($loop->first) x-data="{open: true}"
                        @else
                            x-data="{open: false}" @endif>


                            <header
                                class="border border-greenLime_400 px-4 py-2 cursor-pointer bg-greenLime_400 rounded-3xl"
                                x-on:click="open = !open">
                                <h1 class="font-bold text-lg text-greenLime_50">{{ $seccion->nombre }}</h1>
                            </header>
                            <div class="bg-white py-2 px-4 rounded-b-3xl " x-show="open">
                                <ul class="grid grid-cols-1 gap-2">
                                    @foreach ($seccion->Leccioncurso as $leccion)
                                        <li class="text-gray-700 text-base"><i
                                                class="fas fa-play-circle mr-2 text-gray-600"></i>{{ $leccion->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </article>
                    @endforeach
                </section>
                <section class="bg-white shadow-lg rounded-3xl overflow-hidden" mb-4>
                    <div class=" py-2 px-4">
                        <h1 class="font-bold text-3xl  text-greenLime_400">Requisitos</h1>
                        <ul class="list-disc list-inside">
                            @foreach ($course->Requerimiento_curso as $Requerimiento_curso)
                                <li class="text-gray-700 text-base"> {{ $Requerimiento_curso->nombre }} </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
                <section class="bg-white shadow-lg rounded-3xl overflow-hidden mt-4">
                    <div class=" py-2 px-4">
                        <h1 class="font-bold text-3xl  text-greenLime_400">Descripción</h1>
                        <div class="text-gray-700 text-bae">
                            {!! $course->descripcion !!}
                            <div>
                                <div class=" py-2 px-4">
                </section>
                @livewire('reseña-cursos', ['course' => $course])
            </div>
            <div class="order-1 lg:order-2">
                <section class="bg-white shadow-lg rounded-3xl overflow-hidden mb-4">
                    <div class="px-6 py-4">
                        <div class="flex items-center">
                            <img class="h-12 w-12 object-cover rounded-full shadow-lg"
                                src="{{ $course->teacher->profile_photo_url }}" alt="{{ $course->teacher->name }}">
                            <div class="ml-4">
                                <h1 class="font-fold text-gray-500 text-lg">Prof. {{ $course->teacher->name }} </h1>
                                <a class="text-blue-400 text-sm font-bold"
                                    href="">{{ '@' . Str::slug($course->teacher->name, '') }}</a>
                            </div>
                        </div>
                        @can('matriculado', $course)
                            <a class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-white hover:bg-greenLime_400 mt-4 block text-center"
                                href="{{ route('cursos.status', $course) }}">Continuar con el curso 111</a>
                        @else
                            @if ($course->precio->valor == 0)
                                <form action="{{ route('cursos.matriculado', $course) }}" method="post">
                                    @csrf
                                    @if ($course->precio->valor == 0)
                                        <p class="text-2xl font-bold text-greenLime_400 mt-3 mb-2"> GRATIS </p>
                                    @else
                                        <p class="text-2xl font-bold text-greenLime_400 mt-3 mb-2">$
                                            {{ $course->precio->valor }} COP </p>
                                    @endif
                                    <button
                                        class="font-bold py-2 px-4 w-full rounded-full bg-greenLime_500 text-greenLime_50 hover:bg-greenLime_400 mt-4 block text-center">
                                        <i class="fas fa-star"></i>
                                        Iniciar curso</button>
                                </form>
                                @livewire('add-wish-list', ['course' => $course])
                            @else
                                <p class="text-2xl font-bold text-greenLime_400 mt-3 mb-2">$
                                    {{ number_format($course->precio->valor, 0, ',', '.') }} COP </p>
                                <a href="{{ route('payment.checkout', $course) }}"
                                    class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-greenLime_50  hover:bg-greenLime_400 mt-4 block text-center">
                                    <i class="far fa-credit-card mr-2"></i>
                                    Comprar este curso
                                </a>
                                @livewire('add-cart-courses', ['course' => $course])
                                @livewire('add-wish-list', ['course' => $course])
                            @endif
                        @endcan
                    </div>
                </section>
                <aside class="hidden lg:block bg-white rounded-3xl">
                    <br>
                    @foreach ($similares as $similar)
                        <article class="flex m-6">
                            {{-- <img class="h-25 w-40 object-cover rounded-2xl"
                                src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($similar->image->url)) }}"
                                atl=""> --}}
                            @isset($similar->image)
                                <img class="h-25 w-40 object-cover rounded-2xl"
                                    src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($similar->image->url)) }}"
                                    alt="">
                            @else
                                <img class="h-25 w-40 object-cover rounded-2xl"
                                    src="https://images.pexels.com/photos/4497761/pexels-photo-4497761.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                                    alt="">
                            @endisset
                            <div class="ml-3">
                                <h1>
                                    <a class="font-bold text-greenLime_400 mb-3"
                                        href="{{ route('cursos.show', $similar) }}">{{ Str::limit($similar->nombre, 40) }}</a>
                                </h1>
                                <div class="flex items-center">
                                    <img class="h6 w-6 object-cover rounded-full shadow-lg"
                                        src="{{ $similar->teacher->profile_photo_url }}" alt="">
                                    <p class="text-greenLime_400 text-sm ml-2">{{ $similar->teacher->name }}</p>
                                </div>
                                <div class="flex mt-2">
                                    <ul class="flex text-sm">
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $similar->rating >= 1 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $similar->rating >= 2 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $similar->rating >= 3 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $similar->rating >= 4 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                        <li class="mr-1">
                                            <i
                                                class="fas fa-star text-{{ $similar->rating == 5 ? 'orange' : 'gray' }}_50"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    <br>
                </aside>
            </div>
        </div>
    @endif
</x-app-layout>
