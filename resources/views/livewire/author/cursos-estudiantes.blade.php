<div>
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
                        <h1 class="text-3xl font-bold text-white">Estudiantes del Curso</h1>
                        <p class="text-blue-100 mt-2 text-lg truncate max-w-2xl">Gestiona y visualiza el progreso de tus alumnos inscritos.</p>
                    </div>
                </div>

                <div class="p-10">
                <!-- Search Bar -->
                <div class="mb-6 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input wire:model="search" class="form-input w-full pl-10 bg-gray-50 border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm py-3" placeholder="Buscar estudiante por nombre...">
                </div>

                @if ($students->count())
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($students as $student)
                                    <tr class="hover:bg-indigo-50/30 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm" src="{{$student->profile_photo_url}}" alt="{{ $student->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{$student->name}}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">{{$student->email}}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="$emit('showProgress', {{ $student->id }}, {{ $course->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold hover:underline">Ver Progreso</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{$students->links()}}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center text-gray-500">
                        <div class="bg-gray-100 rounded-full p-4 mb-4">
                            <i class="fas fa-user-slash text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">No se encontraron estudiantes</h3>
                        <p class="text-sm">Intenta con otra búsqueda o espera a que se inscriban alumnos.</p>
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
    
    @livewire('author.student-progress')
</div>
