<x-admin-layout>
    <div class="container mx-auto px-6 py-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden relative">
            
            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary-400 opacity-10 filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-primary-400 opacity-10 filter blur-3xl"></div>

            {{-- Header --}}
            <div class="p-6 border-b border-gray-100 dark:border-gray-600 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm relative z-10 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                        <i class="fas fa-graduation-cap text-primary-600 mr-2 bg-primary-50 p-2 rounded-lg"></i>
                        <span class="tracking-tight">Mis Cursos</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-10">Gestiona los cursos asociados a tu empresa: <span class="font-bold text-primary-600">{{ $empresa->nombre }}</span></p>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-8 relative z-10">
                
                @if($cursos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($cursos as $curso)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                             {{-- Course Image --}}
                            <div class="h-40 bg-gray-200 dark:bg-gray-700 relative">
                                @if($curso->image)
                                    <img src="{{ Storage::url($curso->image->url) }}" alt="{{ $curso->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <i class="fas fa-image text-4xl"></i>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2">
                                     @switch($curso->status)
                                        @case(1)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Borrador</span>
                                            @break
                                        @case(2)
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Revisión</span>
                                            @break
                                        @case(3)
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Publicado</span>
                                            @break
                                        @default
                                            <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Desconocido</span>
                                    @endswitch
                                </div>
                            </div>
                            
                            <div class="p-5">
                                <div class="text-xs text-primary-600 font-bold mb-1 uppercase tracking-wide">
                                    {{ $curso->Categoria ? $curso->Categoria->name : 'Sin Categoría' }}
                                </div>
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 leading-tight line-clamp-2" title="{{ $curso->title }}">
                                    {{ $curso->title }}
                                </h3>
                                <div class="flex items-center mt-4">
                                    <img class="w-8 h-8 rounded-full mr-2 object-cover" src="{{ $curso->teacher ? $curso->teacher->profile_photo_url : '' }}" alt="Instructor">
                                    <div class="text-sm">
                                        <p class="text-gray-900 dark:text-white leading-none">{{ $curso->teacher ? $curso->teacher->name : 'Sin Instructor' }}</p>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs text-right">Instructor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                {{-- Placeholder / Content Area when empty --}}
                 <div class="flex flex-col items-center justify-center py-12 px-4 text-center rounded-2xl bg-gray-50 dark:bg-gray-700/50 border-2 border-dashed border-gray-200 dark:border-gray-600">
                    <div class="bg-primary-50 dark:bg-primary-900/30 p-4 rounded-full mb-4">
                        <i class="fas fa-graduation-cap text-4xl text-primary-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No hay cursos asignados</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-sm mb-6">
                        Actualmente no hay cursos vinculados a esta empresa.
                    </p>
                </div>
                @endif
            </div>
        </div>

    </div>
</x-admin-layout>
