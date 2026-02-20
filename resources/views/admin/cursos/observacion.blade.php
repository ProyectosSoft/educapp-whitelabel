<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Card --}}
        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden relative mb-8">
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-50 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
            
            <div class="px-8 py-8 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                         <div class="flex items-center mb-2">
                             <div class="bg-red-100 p-2 rounded-lg text-red-600 mr-3">
                                <i class="fas fa-ban text-xl"></i>
                             </div>
                            <h1 class="text-2xl font-bold text-[#335A92]">
                                 Observaciones de Rechazo
                            </h1>
                        </div>
                        <p class="text-gray-500 text-sm font-medium ml-12">
                            Curso: <span class="font-bold text-gray-800">{{ $course->nombre }}</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                         <span class="px-4 py-2 rounded-xl text-xs font-bold bg-red-50 text-red-600 border border-red-100 flex items-center shadow-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Acción Requerida
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-8">
             <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 flex items-center mb-2">
                    <i class="fas fa-comment-alt text-[#ECBD2D] mr-2"></i> Motivo del Rechazo
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed bg-blue-50 p-4 rounded-xl border border-blue-100">
                    <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                    Por favor, detalla las correcciones necesarias de manera clara. Estas observaciones serán enviadas al instructor para que realice los ajustes pertinentes antes de volver a solicitar la aprobación.
                </p>
            </div>

            {!! Form::open(['route'=>['admin.cursos.rechazado',$course]]) !!}
                <div class="form-group mb-8">
                    {!! Form::textarea('body', null, ['id' => 'body', 'class' => 'w-full rounded-xl border-gray-200 focus:border-[#335A92] focus:ring-[#335A92]/20']) !!}
                    @error('body')
                        <div class="mt-3 flex items-center text-red-600 text-sm font-bold bg-red-50 p-2 rounded-lg w-fit animate-pulse">
                            <i class="fas fa-times-circle mr-2"></i>
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.cursos.show', $course) }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition shadow-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-600/20 flex items-center transform hover:-translate-y-0.5">
                        <i class="fas fa-ban mr-2"></i> Rechazar Curso
                    </button>
                </div>
            {!! Form::close() !!}
        </div>

    </div>

    <x-slot name="js">
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
        <script>
            //CK Editor
            ClassicEditor
                .create( document.querySelector( '#body' ), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link','blockQuote', 'bulletedList', 'numberedList' ],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Párrafo', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Título 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Título 2', class: 'ck-heading_heading2' }
                        ]
                    },
                     language: 'es'
                } )
                .catch( error => {
                    console.log( error );
                } );
        </script>
    </x-slot>
</x-admin-layout>
