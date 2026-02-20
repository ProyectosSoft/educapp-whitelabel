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
                        <i class="fas fa-user-graduate text-primary-600 mr-2 bg-primary-50 p-2 rounded-lg"></i>
                        <span class="tracking-tight">Mis Alumnos</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-10">Gestiona los alumnos matriculados en tu empresa: <span class="font-bold text-primary-600">{{ $empresa->nombre }}</span></p>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-8 relative z-10">
                
                @if($alumnos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nombre</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Fecha Registro</th>
                                <th scope="col" class="px-6 py-3">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos as $alumno)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $alumno->profile_photo_url }}" alt="{{ $alumno->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-base font-semibold">{{ $alumno->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">{{ $alumno->email }}</td>
                                    <td class="px-6 py-4">{{ $alumno->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Estudiante</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                {{-- Placeholder / Content Area when empty --}}
                 <div class="flex flex-col items-center justify-center py-12 px-4 text-center rounded-2xl bg-gray-50 dark:bg-gray-700/50 border-2 border-dashed border-gray-200 dark:border-gray-600">
                    <div class="bg-indigo-50 dark:bg-indigo-900/30 p-4 rounded-full mb-4">
                        <i class="fas fa-users text-4xl text-indigo-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No hay alumnos aún</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-sm mb-6">
                        No se han encontrado alumnos matriculados en esta empresa.
                    </p>
                </div>
                @endif

            </div>
        </div>

    </div>
</x-admin-layout>
