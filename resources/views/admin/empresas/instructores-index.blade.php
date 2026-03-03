<x-admin-layout>
    <div class="px-4 py-8 md:px-8 space-y-8">
        
        {{-- Corporate Header --}}
        <div class="bg-primary rounded-[2rem] shadow-xl shadow-primary/20 flex flex-col sm:flex-row justify-between items-center p-8 relative overflow-hidden">
            {{-- Abstract bg decoration --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 right-1/4 w-40 h-40 bg-secondary/30 rounded-full blur-2xl transform translate-y-1/2 pointer-events-none"></div>
            
            <div class="relative z-10 flex items-center gap-5">
                <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-md shadow-inner text-[#ECBD2D]">
                    <i class="fas fa-chalkboard-user text-3xl drop-shadow-md"></i>
                </div>
                <div>
                   <h2 class="text-3xl font-extrabold text-white tracking-tight mb-1">Mis Instructores</h2>
                   <p class="text-blue-100 font-medium text-sm">Gestiona los instructores exclusivos de tu empresa: <span class="text-[#ECBD2D] font-bold">{{ $empresa->nombre }}</span></p>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative z-10">
            
            @if($instructores->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Fecha de Registro</th>
                            <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($instructores as $instructor)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-2xl overflow-hidden shadow-sm border border-gray-100 group-hover:border-primary/20 transition-all">
                                            <img class="h-full w-full object-cover" src="{{ $instructor->profile_photo_url }}" alt="{{ $instructor->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-bold text-gray-900 text-sm">{{ $instructor->name }}</div>
                                            <div class="text-xs text-secondary font-medium mt-0.5"><i class="fas fa-chalkboard-user mr-1 opacity-70"></i> Instructor</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium">
                                    <a href="mailto:{{ $instructor->email }}" class="hover:text-primary transition-colors">{{ $instructor->email }}</a>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium">
                                    <div class="flex items-center">
                                        <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                                        {{ $instructor->created_at->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right font-medium">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600 border border-green-200 shadow-sm justify-end">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-2"></span> Activo
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                <div class="w-24 h-24 bg-primary-50 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <i class="fas fa-chalkboard-user text-4xl text-primary-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No tienes instructores asignados</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8 font-medium">
                    Aún no hay usuarios con rol de Instructor operando bajo <span class="font-bold text-gray-700">{{ $empresa->nombre }}</span>.
                </p>
                <button class="px-6 py-3 bg-gray-100 text-gray-400 font-bold rounded-xl cursor-not-allowed border border-gray-200" disabled tooltip="Solicita esto a tu administrador">
                    <i class="fas fa-user-plus mr-2"></i> Asignar Instructores
                </button>
            </div>
            @endif
        </div>

    </div>
</x-admin-layout>
