<x-author-layout :course="$course">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header Gradient -->
            <div class="bg-gradient-to-r from-red-600 to-pink-600 px-8 py-6">
                <h1 class="text-2xl font-bold text-white">Evaluación Final del Curso</h1>
                <p class="text-red-100 text-sm mt-1">Configura el examen final requerido para la certificación.</p>
            </div>

            <div class="px-8 py-8">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <p class="text-sm text-red-700">
                        <i class="fas fa-info-circle mr-2"></i>
                        Esta evaluación estará disponible para el estudiante solo después de completar todas las lecciones.
                        Aprobar este examen generará automáticamente su certificado.
                    </p>
                </div>

                @livewire('author.evaluation-manager', ['course' => $course], key('final-exam-'.$course->id))
            </div>
        </div>
    </div>
</x-author-layout>
