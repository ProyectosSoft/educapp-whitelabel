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
                                <a wire:click="changelesson({{ $this->previous->id }})" class="cursor-pointer">Tema anterior</a>
                            @endif
        
                            {{-- @if ($this->next)
                                <a wire:click="changelesson({{$this->next}})" class="ml-auto cursor-pointer">Siguiente Tema</a>
                            @endif --}}
                            {{-- Enlace para pasar al siguiente tema --}}
                            @if ($this->next)
                            {{-- {{$this->next->id}} --}}
                                {{-- <a id="next-lesson-link" wire:click="changelesson({{ $this->next }})"
                                    class="ml-auto cursor-pointer disabled">Siguiente Tema</a> --}}
                                    <a id="next-lesson-link" wire:click="changelesson({{ $this->next->id }})"
                                        class="ml-auto cursor-pointer disabled">Siguiente Tema</a>
                            @else
                                <span class="ml-auto text-white">No hay siguiente tema</span>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
        @php
            $currentSectionId = null;

            if ($current) {
                $currentSectionId = $current->seccion_curso_id ?? optional($course->Seccion_curso->first(function ($section) use ($current) {
                    return $section->Leccioncurso->contains('id', $current->id);
                }))->id;
            }

            $routeMap = [
                'Configuración Inicial' => ['admin', 'tercero', 'usuario', 'parametro', 'config', 'rol', 'permiso'],
                'Operación Comercial' => ['crm', 'venta', 'compra', 'pago', 'cliente', 'proveedor', 'cotizacion'],
                'Inventario y Bodega' => ['inventario', 'wms', 'bodega', 'almacen', 'stock', 'producto'],
                'Gestión Financiera' => ['financ', 'contab', 'cartera', 'factur', 'cuenta', 'costo', 'tesorer'],
                'Producción' => ['produccion', 'orden', 'manufact', 'proceso', 'costeo'],
                'Logística' => ['logistica', 'despacho', 'envio', 'ruta', 'transporte'],
                'Comunicación' => ['effichat', 'chat', 'mensaje', 'notificacion'],
            ];

            $routeForSection = function ($sectionName) use ($routeMap) {
                $normalized = Str::lower(Str::ascii($sectionName));

                foreach ($routeMap as $routeName => $keywords) {
                    foreach ($keywords as $keyword) {
                        if (Str::contains($normalized, $keyword)) {
                            return $routeName;
                        }
                    }
                }

                return 'Otros módulos ERP';
            };

            $sectionsByRoute = $course->Seccion_curso->groupBy(fn ($section) => $routeForSection($section->nombre));
            $finalExamEvaluations = $course->examFinalEvaluations->where('is_active', true);
        @endphp

        <aside class="lg:sticky lg:top-24 self-start bg-white border border-slate-200 shadow-xl shadow-blue-900/5 rounded-2xl overflow-hidden"
               x-data="{ search: '', openSection: {{ $currentSectionId ?? 'null' }}, expandedLessons: {} }">
            <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-5 py-5 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-blue-100 font-semibold">Ruta de capacitación</p>
                        <h1 class="text-xl leading-6 font-black mt-1">{{ $course->nombre }}</h1>
                    </div>
                    <span class="shrink-0 rounded-full bg-white/15 px-3 py-1 text-xs font-bold">{{ $this->advance }}%</span>
                </div>

                <div class="mt-4 flex items-center gap-3">
                    <img class="w-10 h-10 object-cover rounded-full ring-2 ring-white/30" src="{{ $course->teacher->profile_photo_url }}" alt="">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold truncate">{{ $course->teacher->name }}</p>
                        <p class="text-xs text-blue-100 truncate">{{ '@' . Str::slug($course->teacher->name, '') }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-blue-100 mb-1">
                        <span>Progreso general</span>
                        <span>{{ $this->advance }}% completado</span>
                    </div>
                    <div class="overflow-hidden h-2 rounded-full bg-blue-950/40">
                        <div style="width:{{ $this->advance . '%' }}" class="h-2 rounded-full bg-cyan-300 transition-all duration-500"></div>
                    </div>
                </div>
            </div>

            <div class="p-4 border-b border-slate-200 bg-slate-50">
                <label class="relative block">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input x-model.debounce.150ms="search"
                           type="search"
                           placeholder="Buscar módulo, lección o tema"
                           class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-700 placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500">
                </label>
            </div>

            <div class="max-h-[calc(100vh-18rem)] overflow-y-auto px-4 py-4 space-y-5">
                @foreach ($sectionsByRoute as $routeName => $sections)
                    <section x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())" class="space-y-2">
                        <div class="flex items-center justify-between">
                            <h2 class="text-[11px] font-black uppercase tracking-wider text-slate-500">{{ $routeName }}</h2>
                            <span class="text-[11px] font-semibold text-slate-400">{{ $sections->count() }} módulos</span>
                        </div>

                        @foreach ($sections as $seccion)
                            @php
                                $totalSection = $seccion->Leccioncurso->count();
                                $completedSection = $seccion->Leccioncurso->filter(fn ($l) => $l->completed)->count();
                                $sectionPercent = $totalSection > 0 ? round(($completedSection / $totalSection) * 100) : 0;
                                $sectionExamEvaluations = $seccion->examEvaluations->where('is_active', true);
                            @endphp

                            <article wire:key="course-section-{{ $seccion->id }}"
                                     x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())"
                                     class="rounded-xl border border-slate-200 bg-white overflow-hidden">
                                <button type="button"
                                        class="w-full px-4 py-3 text-left hover:bg-slate-50 transition"
                                        @click="openSection = openSection === {{ $seccion->id }} ? null : {{ $seccion->id }}">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg {{ $sectionPercent == 100 ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-700' }}">
                                            <i class="fas {{ $sectionPercent == 100 ? 'fa-check' : 'fa-layer-group' }} text-xs"></i>
                                        </span>
                                        <span class="min-w-0 flex-1">
                                            <span class="block text-sm font-bold text-slate-800 leading-5">{{ $seccion->nombre }}</span>
                                            <span class="mt-1 flex items-center gap-2">
                                                <span class="h-1.5 flex-1 rounded-full bg-slate-200 overflow-hidden">
                                                    <span class="block h-full rounded-full {{ $sectionPercent == 100 ? 'bg-emerald-500' : 'bg-blue-600' }}" style="width: {{ $sectionPercent }}%"></span>
                                                </span>
                                                <span class="text-[11px] font-bold text-slate-500">{{ $sectionPercent }}%</span>
                                            </span>
                                        </span>
                                        <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform"
                                           :class="{ 'rotate-180': openSection === {{ $seccion->id }} || search !== '' }"></i>
                                    </div>
                                </button>

                                <div x-cloak x-show="openSection === {{ $seccion->id }} || search !== ''" class="border-t border-slate-100 bg-slate-50/70">
                                    <ul class="p-2 space-y-1">
                                        @foreach ($seccion->Leccioncurso as $leccion)
                                            @php
                                                $isCurrentLesson = $current && $current->id == $leccion->id;
                                            @endphp

                                            <li x-show="search !== '' || expandedLessons[{{ $seccion->id }}] || {{ $loop->index }} < 8"
                                                class="lesson-row rounded-lg {{ $isCurrentLesson ? 'bg-blue-100 ring-1 ring-blue-200' : 'hover:bg-white' }}">
                                                <button type="button"
                                                        class="w-full flex items-start gap-2 px-3 py-2 text-left"
                                                        wire:click="changelesson({{ $leccion->id }})">
                                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full text-[11px] font-bold
                                                        {{ $leccion->completed ? 'bg-emerald-500 text-white' : ($isCurrentLesson ? 'bg-blue-700 text-white' : 'border border-slate-300 text-slate-400') }}">
                                                        @if ($leccion->completed)
                                                            <i class="fas fa-check text-[9px]"></i>
                                                        @elseif ($isCurrentLesson)
                                                            <span class="block h-1.5 w-1.5 rounded-full bg-white"></span>
                                                        @else
                                                            <span class="block h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                                                        @endif
                                                    </span>
                                                    <span class="min-w-0 flex-1">
                                                        <span class="block text-sm leading-5 {{ $isCurrentLesson ? 'font-bold text-blue-950' : 'font-medium text-slate-700' }}">{{ $leccion->nombre }}</span>
                                                        <span class="text-[11px] font-semibold {{ $leccion->completed ? 'text-emerald-600' : ($isCurrentLesson ? 'text-blue-700' : 'text-slate-400') }}">
                                                            {{ $leccion->completed ? 'Completado' : ($isCurrentLesson ? 'Actual' : 'Pendiente') }}
                                                        </span>
                                                    </span>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>

                                    @if ($totalSection > 8)
                                        <button type="button"
                                                x-show="search === ''"
                                                @click="expandedLessons[{{ $seccion->id }}] = !expandedLessons[{{ $seccion->id }}]"
                                                class="w-full border-t border-slate-200 px-4 py-2 text-xs font-bold text-blue-700 hover:bg-blue-50">
                                            <span x-show="!expandedLessons[{{ $seccion->id }}]">Ver {{ $totalSection - 8 }} lecciones más</span>
                                            <span x-show="expandedLessons[{{ $seccion->id }}]">Ver menos</span>
                                        </button>
                                    @endif

                                    @foreach($sectionExamEvaluations as $evaluation)
                                        @if($evaluation->start_mode == 'manual' && !$evaluation->is_visible)
                                            @continue
                                        @endif

                                        <div class="border-t border-slate-200 px-4 py-2 text-sm">
                                            @if(!$this->isExamEvaluationUnlocked($evaluation))
                                                <span class="flex items-center text-slate-400 cursor-not-allowed" title="Debes completar el 100% del curso">
                                                    <i class="fas fa-lock mr-2"></i> {{ $evaluation->name }}
                                                </span>
                                            @else
                                                <button type="button" class="flex items-center text-purple-700 font-semibold" wire:click="showEvaluation({{ $evaluation->id }})">
                                                    <i class="fas fa-tasks mr-2"></i> {{ $evaluation->name }}
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach

                                    @if($sectionExamEvaluations->isEmpty() && $seccion->evaluations->count() > 0)
                                        @foreach($seccion->evaluations as $evaluation)
                                            @if($evaluation->start_mode == 'manual' && !$evaluation->is_visible)
                                                @continue
                                            @endif

                                            <div class="border-t border-slate-200 px-4 py-2 text-sm">
                                                @if(!$this->isLegacyEvaluationUnlocked($evaluation))
                                                    <span class="flex items-center text-slate-400 cursor-not-allowed" title="Debes completar el 100% del curso">
                                                        <i class="fas fa-lock mr-2"></i> {{ $evaluation->name }}
                                                    </span>
                                                @else
                                                    <button type="button"
                                                            class="flex items-center font-semibold {{ $currentEvaluation && $currentEvaluation->id == $evaluation->id ? 'text-purple-900' : 'text-purple-700' }}"
                                                            wire:click="showLegacyEvaluation({{ $evaluation->id }})">
                                                        <i class="fas fa-tasks mr-2"></i> {{ $evaluation->name }}
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </section>
                @endforeach

                @if($finalExamEvaluations->count() > 0 || $course->evaluations->count() > 0)
                    <section class="rounded-xl border border-amber-200 bg-amber-50 overflow-hidden">
                        <div class="px-4 py-3">
                            <h2 class="text-sm font-black text-amber-900">Evaluación Final</h2>
                        </div>

                        <div class="border-t border-amber-200 px-4 py-3 space-y-2">
                            @if($finalExamEvaluations->count() > 0)
                                @foreach($finalExamEvaluations as $evaluation)
                                    @if($evaluation->start_mode == 'manual' && !$evaluation->is_visible)
                                        @continue
                                    @endif

                                    @if(!$this->isExamEvaluationUnlocked($evaluation))
                                        <span class="flex items-center text-sm text-slate-500 cursor-not-allowed" title="Debes completar el 100% del curso">
                                            <i class="fas fa-lock mr-2"></i> {{ $evaluation->name }}
                                        </span>
                                    @else
                                        <button type="button" class="flex items-center text-sm text-amber-800 font-bold" wire:click="showEvaluation({{ $evaluation->id }})">
                                            <i class="fas fa-certificate mr-2"></i> {{ $evaluation->name }}
                                        </button>
                                    @endif
                                @endforeach
                            @else
                                @foreach($course->evaluations as $evaluation)
                                    @if($evaluation->start_mode == 'manual' && !$evaluation->is_visible)
                                        @continue
                                    @endif

                                    @if(!$this->isLegacyEvaluationUnlocked($evaluation))
                                        <span class="flex items-center text-sm text-slate-500 cursor-not-allowed" title="Debes completar el 100% del curso">
                                            <i class="fas fa-lock mr-2"></i> {{ $evaluation->name }}
                                        </span>
                                    @else
                                        <button type="button"
                                                class="flex items-center text-sm font-bold {{ $currentEvaluation && $currentEvaluation->id == $evaluation->id ? 'text-amber-950' : 'text-amber-800' }}"
                                                wire:click="showLegacyEvaluation({{ $evaluation->id }})">
                                            <i class="fas fa-certificate mr-2"></i> {{ $evaluation->name }}
                                        </button>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </section>
                @endif
            </div>
        </aside>
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
                if (result.isConfirmed && event.detail.evaluation_id) {
                    @this.showEvaluation(event.detail.evaluation_id);
                } else if (result.isConfirmed && event.detail.legacy_evaluation_id) {
                    window.location.href = \"{{ url('cursos') }}/{{ $course->slug }}/evaluation/\" + event.detail.legacy_evaluation_id;
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
