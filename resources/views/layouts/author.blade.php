<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
         <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
        <!-- Styles -->
        <link rel="icon" type="image/png" href="{{ asset('img/cursos/Isotipo_EducApp_3 _V1.png') }}">
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation')


            <!-- Page Content -->
            <div class="max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-5 gap-6">
                <aside>
                    <h1 class="font-bold text-lg mb-4">Edición del curso</h1>
                    <ul class="text-sm text-gray-600 mb-4">
                        <li class="leading-7 mb-1 border-l-4 @routeIs('author.cursos.edit',$course) border-indigo-400 @else broder-transparent @endif pl-2">
                            <a href="{{route('author.cursos.edit',$course)}}">Información del curso</a>
                        </li>
                        <li class="leading-7 mb-1 border-l-4 @routeIs('author.cursos.curriculum',$course) border-indigo-400 @else broder-transparent @endif pl-2">
                            <a href="{{route('author.cursos.curriculum',$course)}}">Lección del curso</a>
                        </li>
                        <li class="leading-7 mb-1 border-l-4 @routeIs('author.cursos.objetivos',$course) border-indigo-400 @else broder-transparent @endif pl-2">
                            <a href="{{route('author.cursos.objetivos',$course)}}">Metas del curso</a>
                        </li>
                        <li class="leading-7 mb-1 border-l-4 @routeIs('author.cursos.estudiantes',$course) border-indigo-400 @else broder-transparent @endif pl-2">
                            <a href="{{route('author.cursos.estudiantes',$course)}}">Estudiante</a>
                        </li>
                        <li class="leading-7 mb-1 border-l-4 @routeIs('author.cursos.final-exam',$course) border-indigo-400 @else broder-transparent @endif pl-2">
                            <a href="{{route('author.cursos.final-exam',$course)}}">Evaluación Final</a>
                        </li>
                        @if ($course->observation)
                            <li class="leading-7 mb-1 border-l-4 @routeIs('author.cursos.observacion',$course) border-indigo-400 @else broder-transparent @endif pl-2">
                                <a href="{{route('author.cursos.observacion',$course)}}">Observaciones</a>
                            </li>
                        @endif
                        <li class="leading-7 mb-1 border-l-4 @routeIs('author.cursos.cupones',$course) border-indigo-400 @else broder-transparent @endif pl-2">
                            <a href="{{route('author.cursos.cupones',$course)}}">Cupones</a>
                        </li>
                        <li class="leading-7 mb-1 border-l-4 @routeIs('author.cursos.linkreferral',$course) border-indigo-400 @else broder-transparent @endif pl-2">
                            <a href="{{route('author.cursos.linkreferral',$course)}}">Afiliados</a>
                        </li>
                        <li class="leading-7 mb-1 border-l-4 @routeIs('author.cursos.precios',$course) border-indigo-400 @else broder-transparent @endif pl-2">
                            <a href="{{route('author.cursos.precios',$course)}}">precios</a>
                        </li>
                    </ul>
                    @switch($course->status)
                        @case(1)
                            <form action="{{route('author.cursos.status',$course)}}" method="POST">
                                @csrf
                                <button class="font-bold py-2 px-4 rounded-full bg-red-500 text-white">Solicitar Revisión</button>
                            </form>
                            @break
                        @case(2)
                            <div class="bg-white shadow-lg rounded overflow-hidden text-gray-500">
                                <div class=" px-6 py-4">
                                    Este curso se encuentra en revisión
                                </div>
                            </div>
                            @break
                        @case(3)
                            <div class="bg-white shadow-lg rounded overflow-hidden text-gray-500">
                                <div class=" px-6 py-4">
                                    Este curso se encuentra publicado
                                </div>
                            </div>
                            @break
                        @default

                    @endswitch
                </aside>
                <div class="col-span-4 bg-white shadow-lg rounded overflow-hidden">
                    <main class="px-6 py-4 text-gray-600">
                        {{$slot}}
                    </main>
                </div>
            </div>
        </div>

        @stack('modals')

        @livewireScripts
        @isset($js)
            {{$js}}
        @endisset
        <script>
            function dropdown() {
                return {
                    open: false,
                    show() {
                        if (this.open) {
                            //se cierra el menu
                            this.open = false;
                            document.getElemenstByTagName('html')[0].style.overflow = 'auto';
                        } else {
                            //abre el menu
                            this.open = true;
                            document.getElementsByTagName('html')[0].style.overflow = 'hidden';
                        }
                    },
                    close() {
                        this.open = false;
                        document.getElementsByTagName('html')[0].style.overflow = 'auto';
                    }
                }
            }
        </script>
        @stack('script')
    </body>
</html>
