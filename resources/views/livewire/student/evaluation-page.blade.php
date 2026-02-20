<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4">
            <a href="{{ route('cursos.status', $course) }}" class="text-indigo-600 hover:text-indigo-800 font-bold">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Curso
            </a>
        </div>
        
        @livewire('student-evaluation', ['evaluation' => $evaluation])
    </div>
</div>
