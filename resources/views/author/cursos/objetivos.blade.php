<x-author-layout :course="$course">
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
             <!-- Header Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                <h1 class="text-2xl font-bold text-white">Metas del Curso</h1>
                <p class="text-indigo-100 text-sm mt-1">Define los objetivos, requisitos y audiencia de tu curso.</p>
            </div>
            
            <div class="px-8 py-8 space-y-12">
                <!-- Metas -->
                <section>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-bullseye text-indigo-500 text-xl mr-3"></i>
                        <h2 class="text-xl font-bold text-gray-800">Lo que aprenderán los estudiantes</h2>
                    </div>
                    <div class="pl-0 md:pl-2">
                         @livewire('author.cursos-objetivos',['course' => $course], key('cursos-objetivo' . $course->id))
                    </div>
                </section>

                <hr class="border-gray-100">

                <!-- Requisitos -->
                <section>
                     <div class="flex items-center mb-4">
                        <i class="fas fa-list-check text-indigo-500 text-xl mr-3"></i>
                        <h2 class="text-xl font-bold text-gray-800">Requisitos previos</h2>
                    </div>
                    <div class="pl-0 md:pl-2">
                        @livewire('author.cursos-requisitos',['course' => $course], key('cursos-requisitos' . $course->id))
                    </div>
                </section>

                <hr class="border-gray-100">
                
                <!-- Audiencia (Deshabilitado: Funcionalidad no implementada en backend) -->
                {{-- <section>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-users text-indigo-500 text-xl mr-3"></i>
                        <h2 class="text-xl font-bold text-gray-800">¿A quién va dirigido este curso?</h2>
                    </div>
                    <div class="pl-0 md:pl-2">
                        @livewire('author.cursos-audiencia',['course' => $course], key('audiencia-requisitos' . $course->id))
                    </div>
                </section> --}}
            </div>
        </div>
    </div>
</x-author-layout>
