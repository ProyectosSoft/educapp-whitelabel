<div id="app" class="mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 ">
            <div class="position:relative; overflow: hidden; padding-top:56.25%;">
                {{-- {!!$current->iframe!!} --}}
                <video id="my-video" class="video-js vjs-default-skin vjs-16-9 rounded-video"
                    poster={{ Storage::url($course->image->url) }}
                    data-setup='{ "fluid" : true,"controls": true, "autoplay": true, "preload": "auto" }'>
                    <source src="{{ Storage::url($current->url) }}" type="video/mp4" />
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>
                <p id="viewed-percentage">Porcentaje de tiempo visto: 0%</p>
            </div>
            <h1 class="text-3xl text-greenLime_400 font-bold mt-4">
                {{ $current->nombre }}
            </h1>
            <div class="flex justify-between  mt-4">
                {{-- Marcar como culminado --}}
                <div id="mark-as-completed-container" class="flex items-center cursor-pointer mark-as-completed"
                    wire:click="completed">
                    @if ($current->completed)
                        <i class="fas fa-toggle-on text-2xl text-blue-600"></i>
                    @else
                        <i class="fas fa-toggle-off text-2xl text-gray-600"></i>
                    @endif
                    <p class="text-sm ml-2">Marcar esta unidad como culminada</p>
                </div>
                @if ($current->resource)
                    <div class="flex items-center text-gray-600 cursor-pointer" wire:click="download">
                        <i class="fas fa-download text-lg"></i>
                        <p class="text-sm ml-2">Descargar recurso 2</p>
                    </div>
                @endif
            </div>
            <div class="bg-greenLime_400 shadow-lg rounded-3xl overflow-hidden mt-2">
                <div class=" px-6 py-4 flex text-white font-bold">

                    @if ($this->previous)

                        <a wire:click="changelesson({{ $this->previous }})" class="cursor-pointer" >Tema anterior</a>
                    @endif

                    {{-- @if ($this->next)
                        <a wire:click="changelesson({{$this->next}})" class="ml-auto cursor-pointer">Siguiente Tema</a>
                    @endif --}}
                    {{-- Enlace para pasar al siguiente tema --}}
                    @if ($this->next)
                    {{-- {{$this->next->id}} --}}
                        {{-- <a id="next-lesson-link" wire:click="changelesson({{ $this->next }})"
                            class="ml-auto cursor-pointer disabled">Siguiente Tema</a> --}}
                            <a id="next-lesson-link"  href="{{ route('cursos.statusl', ['course' => $course, 'leccionid' => $this->next])}}"
                                class="ml-auto cursor-pointer disabled">Siguiente Tema</a>
                    @else
                        <span class="ml-auto text-white">No hay siguiente tema</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-greenLime_400 shadow-lg rounded-3xl overflow-hidden">
            <div class="px-6 py-4">
                <h1 class="text-2xl leading-8 font-black text-center mb-4 text-greenLime_50">{{ $course->nombre }}</h1>
                <div class="flex items-center">
                    <figure>
                        <img class="w-12 h-12 object-cover rounded-full" src="{{ $course->teacher->profile_photo_url }}"
                            alt="">
                    </figure>
                    <div class="text-white">
                        <p> {{ $course->teacher->name }} </p>
                        <a class="text-blue-500 text-sm" href="">
                            {{ '@' . Str::slug($course->teacher->name, '') }} </a>
                    </div>
                </div>

                <p class="text-white text-sm mt-2">{{ $this->advance . '%' }} completado</p>
                <div class="relative pt-1">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                        <div style="width:{{ $this->advance . '%' }}"
                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-400 transition-all duration-500">

                        </div>
                    </div>
                </div>
                <ul>
                    @foreach ($course->Seccion_curso as $seccion)
                        <li class="text-gray-600 mb-4">
                            <a
                                class="font-bold text-base inline-block mb-2 text-white opacity-90">{{ $seccion->nombre }}</a>
                            <ul>
                                @foreach ($seccion->Leccioncurso as $leccion)
                                    <li class="flex mb-1 text-white opacity-50">
                                        <div>
                                            @if ($leccion->completed)
                                                @if ($current->id == $leccion->id)
                                                    <span
                                                        class="inline-block w-4 h-4  border-2 border-greenLime_50 rounded-full mr-2"></span>
                                                @else
                                                    <span
                                                        class="inline-block w-4 h-4 bg-greenLime_50 rounded-full mr-2"></span>
                                                @endif
                                            @else
                                                @if ($current->id == $leccion->id)
                                                    <span
                                                        class="inline-block w-4 h-4 border-2 border-gray-500 rounded-full mr-2"></span>
                                                @else
                                                    <span
                                                        class="inline-block w-4 h-4 bg-gray-500 rounded-full mr-2"></span>
                                                @endif
                                            @endif

                                        </div>
                                        <a class="cursor-pointer" wire:click="changelesson({{ $leccion }})">
                                            {{ $leccion->nombre }}
                                            @if ($leccion->completed)
                                                (completado)
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script src="https://vjs.zencdn.net/8.6.1/video.min.js"></script>

    <script>
        const app = document.getElementById('app');

        window.onload = function() {
            document.addEventListener("contextmenu", function(e) {
                e.preventDefault();
            }, false);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var player = videojs('my-video');
            var viewedPercentageElement = document.getElementById('viewed-percentage');
            var totalDuration;
            var previousTime;
            var hasViewed70Percent = false;
            var hasViewed100Percent = false;
            var markCompletedLink = document.querySelector('.mark-as-completed');
            var nextLessonLink = document.querySelector('.ml-auto.cursor-pointer');
            var markCompletedContainer = document.querySelector('.mark-as-completed');
            // var nextLessonContainer = document.querySelector('.cursor-pointer');

            // Desactivar el enlace al inicio
            document.getElementById('next-lesson-link').classList.add('disabled');
            markCompletedContainer.classList.add('disabled');

            player.on('loadedmetadata', function() {
                totalDuration = player.duration();
            });

            var manuallySeeked = false;

            player.on('seeking', function() {
                if (!manuallySeeked) {
                    previousTime = player.currentTime();
                    manuallySeeked = true;
                }
            });

            player.on('seeked', function() {
                manuallySeeked = false;
            });

            player.on('timeupdate', function() {
                var currentTime = player.currentTime();
                var percentagePlayed = (currentTime / totalDuration) * 100;
                viewedPercentageElement.innerText = 'Porcentaje de tiempo de reproducción: ' +
                    percentagePlayed
                    .toFixed(2) + '%';

                // Permitir retroceder solo si ya se ha visto más del 70%
                if (hasViewed70Percent) {
                    player.controlBar.progressControl.enable();
                } else {
                    player.controlBar.progressControl.disable();
                }

                // Habilitar el enlace si se ha visto el 70% en algún momento
                if (percentagePlayed >= 10 || hasViewed70Percent) {
                    document.getElementById('next-lesson-link').classList.remove('disabled');
                    markCompletedContainer.classList.remove('disabled');
                    // nextLessonContainer.classList.remove('disabled');
                } else {
                    document.getElementById('next-lesson-link').classList.add('disabled');
                    markCompletedContainer.classList.add('disabled');
                    // nextLessonContainer.classList.add('disabled');
                }


                // Marcar que ya se ha visto más del 70% después de la primera reproducción por encima de ese porcentaje
                if (!hasViewed70Percent && percentagePlayed > 10) {
                    hasViewed70Percent = true;
                }

                // Ejecutar las acciones después de completar el video
                if (percentagePlayed >= 100 && !hasViewed100Percent) {
                    hasViewed100Percent = true;

                    // Ejecutar la acción para marcar la lección como completada
                    var markCompletedLink = document.querySelector('.mark-as-completed');
                    if (markCompletedLink) {
                        markCompletedLink.click();
                    }

                    // Descomentar para ejecutar la acción para pasar al siguiente tema
                    var nextLessonLink = document.querySelector('.ml-auto.cursor-pointer');
                    if (nextLessonLink) {
                        nextLessonLink.click();
                    }
                }

                // Habilitar el enlace solo si la lección actual puede ser vista
                if (percentagePlayed >= 10 || hasViewed70Percent) {
                    document.getElementById('next-lesson-link').classList.remove('disabled');
                } else {
                    document.getElementById('next-lesson-link').classList.add('disabled');
                }
            });

            player.on('mousedown', function(event) {
                var currentTime = player.currentTime();
                var percentagePlayed = (currentTime / totalDuration) * 100;

                // Permitir retroceder si ya se ha visto más del 70%
                if (hasViewed70Percent && percentagePlayed < 10) {
                    player.controlBar.progressControl.enable();
                    document.getElementById('next-lesson-link').classList.remove('disabled');
                } else {
                    // Verificar el porcentaje de tiempo reproducido antes de permitir el avance manual por clic
                    if (percentagePlayed < 10) {
                        // Cancelar el avance manual por clic y restaurar la posición anterior
                        event.preventDefault();
                        player.currentTime(previousTime);
                    }
                }
            });

            // Deshabilitar la barra de progreso al inicio
            player.controlBar.progressControl.disable();

            // Agregar manejo de tecla "Space" para pausar y continuar el video
            document.addEventListener('keydown', function(event) {
                if (event.code === 'Space') {
                    event.preventDefault(); // Evitar el comportamiento predeterminado de la tecla "Space"
                    player.paused() ? player.play() : player.pause(); // Alternar entre pausar y continuar
                }
            });
        });
    </script>
@endpush
