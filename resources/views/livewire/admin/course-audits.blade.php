<div class="py-12 w-full px-4 sm:px-6 lg:px-8">
    {{-- Main Container with Clean Corporate Design --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col lg:flex-row justify-between items-center gap-6 relative overflow-hidden">
             {{-- Abstract bg decoration --}}
             <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
             
             <div class="relative z-10 flex items-center gap-4 w-full lg:w-auto">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-chart-line text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-2xl font-bold tracking-tight">Auditoría de Cursos</h2>
                    <p class="text-blue-100 text-sm font-medium">Seguimiento detallado del progreso académico</p>
                 </div>
             </div>
             
             {{-- Search Bar --}}
             <div class="relative z-10 w-full lg:w-80 group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-blue-200 group-focus-within:text-white transition-colors"></i>
                </div>
                <input wire:model="search" type="text" 
                    class="block w-full pl-10 pr-4 py-2.5 border-none rounded-xl bg-white/10 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-[#ECBD2D] focus:bg-white/20 transition-all shadow-inner font-medium text-sm" 
                    placeholder="Buscar estudiante, curso...">
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
             <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-[#335A92] border-b border-[#335A92]">
                    <tr>
                        <th class="px-6 py-5 font-bold tracking-wider">Estudiante</th>
                        <th class="px-6 py-5 font-bold tracking-wider">Curso</th>
                        <th class="px-6 py-5 font-bold tracking-wider">Duración</th>
                        <th class="px-6 py-5 font-bold tracking-wider w-1/4">Progreso</th>
                        <th class="px-6 py-5 font-bold tracking-wider text-right">Sesión</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sessions as $session)
                        <tr class="bg-white even:bg-[#335A92]/5 hover:bg-[#477EB1]/10 transition duration-200 group">
                             <td class="px-6 py-4">
                                 <div class="flex items-center gap-3">
                                     <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-[#477EB1] to-[#335A92] text-white flex items-center justify-center font-bold text-sm shadow-sm border-2 border-white">
                                         {{ substr($session->user->name, 0, 1) }}
                                     </div>
                                     <div class="flex flex-col">
                                         <span class="font-bold text-gray-800 group-hover:text-[#335A92] transition-colors">
                                             {{ $session->user->name }}
                                         </span>
                                         <span class="text-xs text-gray-500">{{ $session->user->email }}</span>
                                     </div>
                                 </div>
                             </td>
                             <td class="px-6 py-4">
                                 <div class="flex items-center">
                                     <i class="fas fa-book-open text-gray-300 mr-2 group-hover:text-[#ECBD2D] transition-colors"></i>
                                     <span class="font-medium text-gray-700">{{ $session->course->nombre }}</span>
                                 </div>
                             </td>
                             <td class="px-6 py-4">
                                 <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-[#335A92]/10 text-[#335A92] border border-[#335A92]/20">
                                     <i class="fas fa-clock mr-1.5"></i>
                                     {{ gmdate('H:i:s', $session->total_time) }}
                                 </span>
                             </td>
                             <td class="px-6 py-4">
                                 <div class="flex flex-col space-y-1.5">
                                     <div class="flex justify-between text-xs font-medium">
                                         <span class="text-gray-500">Inicio: {{ $session->start_progress }}%</span>
                                         <span class="text-[#335A92]">Actual: {{ $session->end_progress }}%</span>
                                     </div>
                                     <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                         <div class="bg-gradient-to-r from-[#477EB1] to-[#335A92] h-2 rounded-full transition-all duration-500 shadow-sm" style="width: {{ $session->end_progress }}%"></div>
                                     </div>
                                     @if($session->end_progress > $session->start_progress)
                                         <div class="flex items-center text-[10px] text-green-600 font-bold mt-1">
                                             <i class="fas fa-arrow-up mr-1"></i>
                                             <span>+{{ number_format($session->end_progress - $session->start_progress, 1) }}% avance</span>
                                         </div>
                                     @endif
                                 </div>
                             </td>
                             <td class="px-6 py-4 text-right">
                                 <div class="flex flex-col items-end">
                                     <span class="text-xs font-bold text-gray-700">
                                         {{ $session->started_at->format('d/m/Y') }}
                                     </span>
                                     <span class="text-[10px] text-gray-400 mb-1">
                                         {{ $session->started_at->format('h:i A') }}
                                     </span>
                                     <span class="text-[9px] text-gray-500 bg-gray-100 px-1.5 rounded">
                                         Hace {{ $session->started_at->diffForHumans(null, true) }}
                                     </span>
                                 </div>
                             </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mb-4 shadow-sm">
                                        <i class="fas fa-inbox text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-lg font-bold text-gray-700">Sin actividad reciente</p>
                                    <p class="text-sm text-gray-400">No se encontraron registros de estudio</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
             </table>
        </div>
        
        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $sessions->links() }}
        </div>
   </div>
</div>
