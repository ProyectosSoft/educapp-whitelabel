<x-instructor-layout :course="$course">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="{{ route('author.cursos.index') }}" class="hover:text-[#335A92] transition-colors"><i class="fas fa-arrow-left mr-2"></i> Volver a mis cursos</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            @include('author.cursos.partials.edition-sidebar', ['course' => $course])

            <div class="lg:col-span-9 bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
                <div class="bg-[#335A92] px-10 py-8 relative overflow-hidden flex justify-between items-center">
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-yellow-400/20 blur-3xl"></div>

                    <div class="relative z-10">
                        <h1 class="text-3xl font-bold text-white">Observaciones del Curso</h1>
                        <p class="text-blue-100 mt-2 text-lg truncate max-w-2xl">Retroalimentación del proceso de revisión.</p>
                    </div>
                </div>

                <div class="p-10">
                    @if($course->observation)
                        <div class="prose max-w-none text-gray-700">
                            {!! $course->observation->body !!}
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-gray-600">
                            Aún no hay observaciones para este curso.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-instructor-layout>
