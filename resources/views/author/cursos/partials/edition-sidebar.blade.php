<aside class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-5 lg:sticky lg:top-24">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Edición del curso</h2>
    <ul class="text-sm text-gray-700 space-y-1 mb-5">
        <li><a href="{{ route('author.cursos.edit', $course) }}" class="block border-l-2 pl-3 py-1 {{ request()->routeIs('author.cursos.edit') ? 'border-[#335A92] text-[#335A92] font-semibold' : 'border-transparent hover:border-gray-300 hover:text-gray-900' }}">Información del curso</a></li>
        <li><a href="{{ route('author.cursos.curriculum', $course) }}" class="block border-l-2 pl-3 py-1 {{ request()->routeIs('author.cursos.curriculum') ? 'border-[#335A92] text-[#335A92] font-semibold' : 'border-transparent hover:border-gray-300 hover:text-gray-900' }}">Lección del curso</a></li>
        <li><a href="{{ route('author.cursos.objetivos', $course) }}" class="block border-l-2 pl-3 py-1 {{ request()->routeIs('author.cursos.objetivos') ? 'border-[#335A92] text-[#335A92] font-semibold' : 'border-transparent hover:border-gray-300 hover:text-gray-900' }}">Metas del curso</a></li>
        <li><a href="{{ route('author.cursos.estudiantes', $course) }}" class="block border-l-2 pl-3 py-1 {{ request()->routeIs('author.cursos.estudiantes') ? 'border-[#335A92] text-[#335A92] font-semibold' : 'border-transparent hover:border-gray-300 hover:text-gray-900' }}">Estudiante</a></li>
        <li><a href="{{ route('author.cursos.final-exam', $course) }}" class="block border-l-2 pl-3 py-1 {{ request()->routeIs('author.cursos.final-exam') ? 'border-[#335A92] text-[#335A92] font-semibold' : 'border-transparent hover:border-gray-300 hover:text-gray-900' }}">Evaluación Final</a></li>
        <li><a href="{{ route('author.cursos.cupones', $course) }}" class="block border-l-2 pl-3 py-1 {{ request()->routeIs('author.cursos.cupones') ? 'border-[#335A92] text-[#335A92] font-semibold' : 'border-transparent hover:border-gray-300 hover:text-gray-900' }}">Cupones</a></li>
        <li><a href="{{ route('author.cursos.linkreferral', $course) }}" class="block border-l-2 pl-3 py-1 {{ request()->routeIs('author.cursos.linkreferral') ? 'border-[#335A92] text-[#335A92] font-semibold' : 'border-transparent hover:border-gray-300 hover:text-gray-900' }}">Afiliados</a></li>
        <li><a href="{{ route('author.cursos.precios', $course) }}" class="block border-l-2 pl-3 py-1 {{ request()->routeIs('author.cursos.precios') ? 'border-[#335A92] text-[#335A92] font-semibold' : 'border-transparent hover:border-gray-300 hover:text-gray-900' }}">Precios</a></li>
        @if ($course->observation)
            <li><a href="{{ route('author.cursos.observacion', $course) }}" class="block border-l-2 pl-3 py-1 {{ request()->routeIs('author.cursos.observacion') ? 'border-[#335A92] text-[#335A92] font-semibold' : 'border-transparent hover:border-gray-300 hover:text-gray-900' }}">Observaciones</a></li>
        @endif
    </ul>

    @switch($course->status)
        @case(1)
            <form action="{{ route('author.cursos.status', $course) }}" method="POST">
                @csrf
                <button class="w-full px-5 py-2 rounded-xl bg-red-500 text-white text-sm font-bold hover:bg-red-600 transition">
                    Solicitar Revisión
                </button>
            </form>
            @break
        @case(2)
            <div class="inline-flex items-center px-4 py-2 rounded-xl bg-amber-100 text-amber-700 text-sm font-semibold">
                Este curso se encuentra en revisión
            </div>
            @break
        @case(3)
            <div class="inline-flex items-center px-4 py-2 rounded-xl bg-green-100 text-green-700 text-sm font-semibold">
                Este curso se encuentra publicado
            </div>
            @break
    @endswitch
</aside>
