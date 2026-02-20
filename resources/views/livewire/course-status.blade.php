<div id="app" class="mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 ">
            
            @if($currentEvaluation)
                @livewire('student-evaluation', ['evaluation' => $currentEvaluation], key($currentEvaluation->id))
            @else
                <div wire:key="video-context-{{ $current->id }}" class="position:relative; overflow: hidden; padding-top:56.25%;">
                    <div wire:ignore>
                        @if($current)
                            <video id="video-{{ $current->id }}" class="video-js vjs-default-skin vjs-16-9 rounded-video"
                                poster={{ Storage::url($course->image->url) }}
                                data-setup='{ "fluid" : true,"controls": true, "autoplay": true, "preload": "auto" }'>
                                <source src="{{ Storage::url($current->url) }}" type="video/mp4" />
                                <p class="vjs-no-js">
                                    To view this video please enable JavaScript, and consider upgrading to a
                                    web browser that
                                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                </p>
                            </video>
                        @endif
                    </div>
                    @if($current)
                        <p id="viewed-percentage">Porcentaje de tiempo visto: 0%</p>
                    @endif
                </div>
                
                @if($current)
                    <h1 class="text-3xl text-greenLime_400 font-bold mt-4">
                        {{ $current->nombre }}
                    </h1>
                    <div class="flex justify-between  mt-4">
                        {{-- Marcar como culminado --}}
                        <div id="mark-as-completed-container" class="flex items-center pointer-events-none text-gray-400 mark-as-completed"
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
                                {{-- <a wire:click="changelesson({{ $this->previous }})" class="cursor-pointer" >Tema anterior</a> --}}
                                <a href="{{ route('cursos.statusl', ['course' => $course, 'leccionid' => $this->previous])}}" class="cursor-pointer" >Tema anterior</a>
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
                @endif
            @endif
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
                            @php
                                $totalSection = $seccion->Leccioncurso->count();
                                $completedSection = $seccion->Leccioncurso->filter(function($l) { return $l->completed; })->count();
                                $sectionPercent = $totalSection > 0 ? round(($completedSection / $totalSection) * 100) : 0;
                            @endphp

                            <div class="mb-2">
                                <a class="font-bold text-base block text-white opacity-90">{{ $seccion->nombre }}</a>
                                <div class="flex items-center mt-1 pr-4">
                                    <div class="w-full bg-gray-600 rounded-full h-1.5 mr-2">
                                        <div class="{{ $sectionPercent == 100 ? 'bg-green-400' : 'bg-orange-400' }} h-1.5 rounded-full transition-all duration-500" style="width: {{ $sectionPercent }}%"></div>
                                    </div>
                                    <span class="text-xs text-white opacity-80 min-w-[2rem] text-right">{{ $sectionPercent }}%</span>
                                </div>
                            </div>

                            <ul>
                                @foreach ($seccion->Leccioncurso as $leccion)
                                    <li class="flex mb-1 text-white opacity-50">
                                        <div>
                                            @if ($leccion->completed)
                                                @if ($current && $current->id == $leccion->id)
                                                    <span
                                                        class="inline-block w-4 h-4  border-2 border-greenLime_50 rounded-full mr-2"></span>
                                                @else
                                                    <span
                                                        class="inline-block w-4 h-4 bg-greenLime_50 rounded-full mr-2"></span>
                                                @endif
                                            @else
                                                @if ($current && $current->id == $leccion->id)
                                                    <span
                                                        class="inline-block w-4 h-4 border-2 border-gray-500 rounded-full mr-2"></span>
                                                @else
                                                    <span
                                                        class="inline-block w-4 h-4 bg-gray-500 rounded-full mr-2"></span>
                                                @endif
                                            @endif

                                        </div>
                                        <a class="cursor-pointer" wire:click="changelesson({{ $leccion }})">
                                            {{-- <a class="cursor-pointer"  href="{{ route('cursos.statusl', ['course' => $course, 'leccionid' => $this->$leccion->id])}}"> --}}
                                                {{ $leccion->nombre }}
                                            @if ($leccion->completed)
                                                (completado)
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        
                        {{-- Evaluaciones de la sección --}}
                        @if($seccion->evaluations->count() > 0)
                            @foreach($seccion->evaluations as $evaluation)
                                @if($evaluation->start_mode == 'manual' && !$evaluation->is_visible)
                                    @continue {{-- Hide completely if manual and not visible --}}
                                @endif

                                <li class="flex mb-1 text-white opacity-50">
                                    <div>
                                        <span class="inline-block w-4 h-4 bg-purple-500 rounded-full mr-2"></span>
                                    </div>
                                    @if(($evaluation->start_mode == 'manual' || $evaluation->start_mode == 'automatic') && $this->advance < 100)
                                        <span class="cursor-not-allowed text-gray-400" title="Debes completar el 100% del curso">
                                            <i class="fas fa-lock mr-2"></i> {{ $evaluation->name }}
                                        </span>
                                    @else
                                        <a class="cursor-pointer {{ $currentEvaluation && $currentEvaluation->id == $evaluation->id ? 'text-purple-300 font-bold' : '' }}" 
                                           wire:click="showEvaluation({{ $evaluation->id }})">
                                            <i class="fas fa-tasks mr-2"></i> {{ $evaluation->name }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    @endforeach
                    
                    {{-- Final Exam --}}
                    @if($course->evaluations->count() > 0)
                        <li class="text-gray-600 mb-4 mt-6">
                            <span class="font-bold text-base inline-block mb-2 text-white opacity-90">Evaluación Final</span>
                            <ul>
                                @foreach($course->evaluations as $evaluation)
                                    @if($evaluation->start_mode == 'manual' && !$evaluation->is_visible)
                                        @continue
                                    @endif

                                    <li class="flex mb-1 text-white opacity-50">
                                        <div>
                                            <span class="inline-block w-4 h-4 bg-yellow-500 rounded-full mr-2"></span>
                                        </div>
                                        @if(($evaluation->start_mode == 'manual' || $evaluation->start_mode == 'automatic') && $this->advance < 100)
                                            <span class="cursor-not-allowed text-gray-400" title="Debes completar el 100% del curso">
                                                <i class="fas fa-lock mr-2"></i> {{ $evaluation->name }}
                                            </span>
                                        @else
                                            <a class="cursor-pointer {{ $currentEvaluation && $currentEvaluation->id == $evaluation->id ? 'text-yellow-300 font-bold' : '' }}" 
                                               wire:click="showEvaluation({{ $evaluation->id }})">
                                                <i class="fas fa-certificate mr-2"></i> {{ $evaluation->name }}
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
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
            @if(isset($current) && $current)
                initializePlayer("video-{{ $current->id }}");
            @endif
        });

        window.addEventListener('lesson-changed', event => {
            setTimeout(() => {
                 // Livewire update re-renders the script block with new ID? 
                 // No, event listener is static. We need to find the new video ID dynamically.
                 var vid = document.querySelector('.video-js');
                 if(vid && vid.id) {
                     initializePlayer(vid.id);
                 }
            }, 100);
        });

        function initializePlayer(playerId) {
            var videoElement = document.getElementById(playerId);
            if (!videoElement) return;

            // Safe cleanup of OLD players only if they act on different IDs or orphaned elements
            // But with unique IDs, we dont need to worry about collision.
            
            var player = videojs(playerId);
            var viewedPercentageElement = document.getElementById('viewed-percentage');
            // ... rest of logic
            var totalDuration;
            var previousTime;
            var hasReachedSeekThreshold = false;
            var maxViewedPercentage = 0;
            var hasViewed100Percent = false;
            
            // Initial disable (Wrap in try-catch in case UI not ready)
            try {
                var progressControl = player.controlBar.progressControl;
                progressControl.disable();
                progressControl.el().style.pointerEvents = 'none'; 
                progressControl.el().style.opacity = '0.5'; 
            } catch(e) {}

            function updateDuration() {
                var dur = player.duration();
                if (Number.isFinite(dur) && dur > 0) {
                    totalDuration = dur;
                }
            }

            player.on('loadedmetadata', updateDuration);
            player.on('durationchange', updateDuration);

            player.on('timeupdate', function() {
                updateDuration(); 
                
                if (!totalDuration) return; 

                var currentTime = player.currentTime();
                var percentagePlayed = (currentTime / totalDuration) * 100;
                
                if (!Number.isFinite(percentagePlayed)) percentagePlayed = 0;

                var currentViewedElement = document.getElementById('viewed-percentage');
                if (currentViewedElement) {
                    currentViewedElement.innerText = 'Porcentaje de tiempo de reproducción: ' +
                        Math.max(percentagePlayed, maxViewedPercentage).toFixed(2) + '%';
                }
                
                // SEEK PREVENTION
                if (!hasReachedSeekThreshold && percentagePlayed > maxViewedPercentage + 2) {
                     player.currentTime((maxViewedPercentage / 100) * totalDuration);
                     return; 
                }

                if (percentagePlayed > maxViewedPercentage) {
                    maxViewedPercentage = percentagePlayed;
                }

                if (!hasReachedSeekThreshold && maxViewedPercentage >= 30) {
                    hasReachedSeekThreshold = true;
                    try {
                        player.controlBar.progressControl.enable();
                        player.controlBar.progressControl.el().style.pointerEvents = 'auto';
                        player.controlBar.progressControl.el().style.opacity = '1';
                    } catch(e) {}
                }

                var nextLink = document.getElementById('next-lesson-link');
                if (maxViewedPercentage >= 30) {
                    if (nextLink) nextLink.classList.remove('disabled');
                } else {
                    if (nextLink) nextLink.classList.add('disabled');
                }

                if (percentagePlayed >= 98 && !hasViewed100Percent) {
                    hasViewed100Percent = true;
                     var markCompletedLink = document.querySelector('.mark-as-completed');
                    var toggleIcon = markCompletedLink ? markCompletedLink.querySelector('i') : null;
                    if (markCompletedLink && toggleIcon && toggleIcon.classList.contains('fa-toggle-off')) {
                        markCompletedLink.click();
                    }
                    var nextLessonCursor = document.querySelector('.ml-auto.cursor-pointer');
                    if (nextLessonCursor) nextLessonCursor.click();
                }
            });

            player.on('seeking', function() {
                if (!totalDuration) return;
                var currentTime = player.currentTime();
                var percentagePlayed = (currentTime / totalDuration) * 100;
                
                if (!Number.isFinite(percentagePlayed)) return;

                if (!hasReachedSeekThreshold && percentagePlayed > maxViewedPercentage + 1) {
                     player.currentTime((maxViewedPercentage / 100) * totalDuration);
                }
            });

             // Space handler
            document.addEventListener('keydown', function(event) {
                if (event.code === 'Space' && document.activeElement !== videoElement) {
                     // Check if player is focused or we want global handler
                     // Caution: global handler might interfere with other inputs.
                     // But user asked for it.
                     // Better check if player exists and is visible.
                     if(player && !player.isDisposed()) {
                         event.preventDefault(); 
                         player.paused() ? player.play() : player.pause();
                     }
                }
            });
        }
    </script>

    <script>
        window.addEventListener('swal:confirm-exam', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: event.detail.confirmButtonText,
                cancelButtonText: 'Más tarde'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.showEvaluation(event.detail.evaluation_id);
                }
            })
        });
    </script>
    <script>
        // Session Heartbeat - Updates every 30 seconds
        setInterval(function() {
            @this.call('updateSession');
        }, 30000); 
    </script>
@endpush
