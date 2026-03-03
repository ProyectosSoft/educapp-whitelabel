<x-admin-layout>
    <div class="px-4 py-8 md:px-8 space-y-8">
        
        {{-- Corporate Header --}}
        <div class="bg-primary rounded-[2rem] shadow-xl shadow-primary/20 flex flex-col sm:flex-row justify-between items-center p-8 relative overflow-hidden">
            {{-- Abstract bg decoration --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 right-1/4 w-40 h-40 bg-secondary/30 rounded-full blur-2xl transform translate-y-1/2 pointer-events-none"></div>
            
            <div class="relative z-10 flex items-center gap-5">
                <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-md shadow-inner text-[#ECBD2D]">
                    <i class="fas fa-award text-3xl drop-shadow-md"></i>
                </div>
                <div>
                   <h2 class="text-3xl font-extrabold text-white tracking-tight mb-1">Mis Certificaciones</h2>
                   <p class="text-blue-100 font-medium text-sm">Historial de insignias y certificaciones emitidas por: <span class="text-[#ECBD2D] font-bold">{{ $empresa->nombre }}</span></p>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative z-10">
            
            @if(isset($certificaciones) && $certificaciones->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Certificación / Examen</th>
                                <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-center">Puntaje</th>
                                <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Fecha de Emisión</th>
                                <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($certificaciones as $certificacion)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 sm:h-12 sm:w-12 rounded-2xl overflow-hidden shadow-sm border border-gray-100 group-hover:border-primary/20 transition-all">
                                                <img class="h-full w-full object-cover" src="{{ optional($certificacion->user)->profile_photo_url }}" alt="{{ optional($certificacion->user)->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-gray-900 text-sm">
                                                    <a href="{{ route('admin.empresas.alumnos.show', $certificacion->user_id) }}" class="hover:text-primary transition-colors">
                                                        {{ optional($certificacion->user)->name ?? 'Usuario Eliminado' }}
                                                    </a>
                                                </div>
                                                <div class="text-xs text-secondary font-medium mt-0.5"><i class="fas fa-envelope mr-1 opacity-70"></i> {{ optional($certificacion->user)->email ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-yellow-50 text-yellow-500 border border-yellow-100 flex items-center justify-center shrink-0">
                                                <i class="fas fa-medal text-lg"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-sm md:text-base">{{ optional(optional($certificacion->evaluation)->exam)->name ?? 'Examen Eliminado' }}</p>
                                                <p class="text-xs text-emerald-600 font-bold"><i class="fas fa-check-circle mr-1"></i> Aprobado</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center font-medium">
                                        <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-sm font-black bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">
                                            {{ $certificacion->final_score !== null ? $certificacion->final_score . '%' : 'S/C' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right text-sm text-gray-500 font-bold">
                                         {{ $certificacion->updated_at->format('d M Y - H:i') }}
                                    </td>
                                    <td class="px-8 py-5 text-right font-medium">
                                        <a href="{{ route('exams.certificate', $certificacion->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white border border-yellow-200 rounded-xl font-bold text-xs text-yellow-600 hover:bg-yellow-50 hover:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all shadow-sm">
                                            <i class="fas fa-file-pdf mr-2"></i> Descargar PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center relative overflow-hidden">
                    {{-- Decorative background element --}}
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-yellow-50/50 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="w-24 h-24 bg-gradient-to-tr from-yellow-100 to-yellow-50 rounded-full flex items-center justify-center mb-6 shadow-inner relative z-10 border border-yellow-200">
                        <i class="fas fa-medal text-5xl text-yellow-500 drop-shadow-sm"></i>
                    </div>
                    
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-3 relative z-10 tracking-tight">Sin Certificaciones Aún</h3>
                    
                    <p class="text-gray-500 max-w-md mx-auto mb-10 font-medium relative z-10 leading-relaxed">
                        Parece que los estudiantes de tu empresa <span class="font-bold text-gray-800">{{ $empresa->nombre }}</span> aún no han completado ningún examen satisfactoriamente.
                    </p>
                </div>
            @endif
            
        </div>

    </div>
</x-admin-layout>
