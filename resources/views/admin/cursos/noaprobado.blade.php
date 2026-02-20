<x-admin-layout>
    {{-- Main Container with Clean Corporate Design --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
             {{-- Abstract bg decoration --}}
             <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
             
             <div class="relative z-10 flex items-center gap-4">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-file-signature text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-2xl font-bold tracking-tight">Cursos en Borrador o Rechazados</h2>
                    <p class="text-blue-100 text-sm font-medium">Historial de revisiones y documentos pendientes</p>
                 </div>
             </div>
             
             <div class="relative z-10 flex items-center gap-3">
                 <div class="px-4 py-2 bg-white/10 rounded-xl backdrop-blur-sm border border-white/20 text-white text-xs font-bold">
                     <i class="fas fa-folder-open mr-1 text-[#ECBD2D]"></i>
                     {{ $courses->count() }} Registros
                 </div>
                 <a href="{{ route('admin.cursos.index') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all border border-white/20 shadow-sm hover:shadow-md flex items-center group text-sm">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Volver a Pendientes
                 </a>
             </div>
        </div>
        
        @if (session('info'))
            <div class="px-8 pt-8">
                <div class="flex items-center p-4 mb-4 text-sm text-[#335A92] rounded-xl bg-[#335A92]/10 border border-[#335A92]/20" role="alert">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span class="font-bold">¡Éxito!</span> {{ session('info') }}
                </div>
            </div>
        @endif

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            @if($courses->count())
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-white uppercase bg-[#335A92] border-b border-[#335A92]">
                        <tr>
                            <th scope="col" class="px-8 py-5 font-bold tracking-wider">ID</th>
                            <th scope="col" class="px-8 py-5 font-bold tracking-wider">Curso</th>
                            <th scope="col" class="px-8 py-5 font-bold tracking-wider">Categoría</th>
                            <th scope="col" class="px-8 py-5 font-bold tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($courses as $course)
                            <tr class="bg-white even:bg-[#335A92]/5 hover:bg-[#477EB1]/10 transition duration-200 group">
                                <td class="px-8 py-5 font-bold text-[#335A92]">
                                    #{{ $course->id }}
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                         @if($course->image)
                                            <div class="h-12 w-20 rounded-lg overflow-hidden shadow-sm mr-4 border border-gray-100 group-hover:shadow-md transition-all">
                                                <img class="h-full w-full object-cover grayscale group-hover:grayscale-0 transition-all duration-300" src="{{ Storage::url($course->image->url) }}" alt="">
                                            </div>
                                         @else
                                            <div class="h-12 w-20 bg-gray-100 rounded-lg mr-4 border border-gray-200 flex items-center justify-center text-gray-300">
                                                <i class="fas fa-image"></i>
                                            </div>
                                         @endif
                                        <span class="text-base font-bold text-gray-800 group-hover:text-[#335A92] transition-colors">
                                            {{ $course->title ?? $course->nombre }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#335A92]/10 text-[#335A92] border border-[#335A92]/20">
                                        {{ $course->categoria->nombre }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('admin.cursos.show', $course) }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-200 rounded-xl font-bold text-xs text-gray-600 uppercase tracking-widest hover:bg-[#335A92] hover:text-white hover:border-[#335A92] transition ease-in-out duration-150 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                        <i class="fas fa-search mr-2"></i> Revisar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="p-16 text-center text-gray-500">
                    <div class="bg-gray-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
                        <i class="fas fa-folder-open text-5xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Lista vacía</h3>
                    <p class="text-gray-500">No hay cursos en estado de borrador o rechazados actualmente.</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
