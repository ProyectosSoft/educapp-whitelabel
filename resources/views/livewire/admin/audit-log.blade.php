<div class="py-12 w-full px-4 sm:px-6 lg:px-8">
    {{-- Main Container with Clean Corporate Design --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col lg:flex-row justify-between items-center gap-6 relative overflow-hidden">
             {{-- Abstract bg decoration --}}
             <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
             
             <div class="relative z-10 flex items-center gap-4 w-full lg:w-auto">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-history text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-2xl font-bold tracking-tight">Auditoría del Sistema</h2>
                    <p class="text-blue-100 text-sm font-medium">Registro de actividad y seguridad</p>
                 </div>
             </div>
             
             {{-- Search Bar --}}
             <div class="relative z-10 w-full lg:w-80 group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-blue-200 group-focus-within:text-white transition-colors"></i>
                </div>
                <input wire:model="search" type="text" 
                    class="block w-full pl-10 pr-4 py-2.5 border-none rounded-xl bg-white/10 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-[#ECBD2D] focus:bg-white/20 transition-all shadow-inner font-medium text-sm" 
                    placeholder="Buscar usuario, IP, evento...">
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
             <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-[#335A92] border-b border-[#335A92]">
                    <tr>
                        <th class="px-6 py-5 font-bold tracking-wider">ID</th>
                        <th class="px-6 py-5 font-bold tracking-wider">Usuario</th>
                        <th class="px-6 py-5 font-bold tracking-wider">Evento</th>
                        <th class="px-6 py-5 font-bold tracking-wider">IP / Agente</th>
                        <th class="px-6 py-5 font-bold tracking-wider">URL / Detalles</th>
                        <th class="px-6 py-5 font-bold tracking-wider text-right">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($audits as $audit)
                        <tr class="bg-white even:bg-[#335A92]/5 hover:bg-[#477EB1]/10 transition duration-200 group">
                             <td class="px-6 py-4 font-bold text-[#335A92]/70 text-xs">
                                 #{{ $audit->id }}
                             </td>
                             <td class="px-6 py-4">
                                 @if($audit->user)
                                     <div class="flex items-center gap-3">
                                         @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                            <img class="h-8 w-8 rounded-full object-cover border border-gray-200" src="{{ $audit->user->profile_photo_url }}" alt="{{ $audit->user->name }}" />
                                         @else
                                            <div class="h-8 w-8 rounded-full bg-[#335A92]/10 flex items-center justify-center text-[#335A92] font-bold text-xs border border-[#335A92]/20">
                                                {{ substr($audit->user->name, 0, 1) }}
                                            </div>
                                         @endif
                                         <div class="flex flex-col">
                                             <span class="font-bold text-gray-800 group-hover:text-[#335A92] transition-colors text-sm">
                                                 {{ $audit->user->name }}
                                             </span>
                                             <span class="text-xs text-gray-500">{{ $audit->user->email }}</span>
                                         </div>
                                     </div>
                                 @else
                                     <span class="inline-flex items-center px-2 py-1 rounded bg-gray-100 text-gray-500 text-xs font-medium">
                                        <i class="fas fa-user-secret mr-1"></i> Desconocido ({{ $audit->user_id }})
                                     </span>
                                 @endif
                             </td>
                             <td class="px-6 py-4">
                                 @if($audit->event === 'login')
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                         <i class="fas fa-sign-in-alt mr-1"></i> Login
                                     </span>
                                 @elseif($audit->event === 'logout')
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                         <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                     </span>
                                 @elseif($audit->event === 'created')
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#ECBD2D]/20 text-[#335A92] border border-[#ECBD2D]/30">
                                         <i class="fas fa-plus mr-1"></i> Creación
                                     </span>
                                 @elseif($audit->event === 'updated')
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                         <i class="fas fa-pen mr-1"></i> Edición
                                     </span>
                                 @elseif($audit->event === 'deleted')
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                         <i class="fas fa-trash mr-1"></i> Eliminación
                                     </span>
                                 @else
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                         {{ ucfirst($audit->event) }}
                                     </span>
                                 @endif
                             </td>
                             <td class="px-6 py-4">
                                 <div class="flex flex-col">
                                     <span class="text-xs font-mono text-gray-600 bg-gray-50 px-2 py-1 rounded w-fit border border-gray-100 mb-1">
                                         {{ $audit->ip_address }}
                                     </span>
                                     <span class="text-[10px] text-gray-400 truncate max-w-[150px]" title="{{ $audit->user_agent }}">
                                         {{ Str::limit($audit->user_agent, 20) }}
                                     </span>
                                 </div>
                             </td>
                             <td class="px-6 py-4">
                                 <div class="max-w-xs">
                                     <p class="text-xs font-medium text-[#477EB1] mb-1 truncate" title="{{ $audit->url }}">
                                         {{ Str::limit($audit->url, 40) }}
                                     </p>
                                     @if($audit->old_values || $audit->new_values)
                                         <div x-data="{ open: false }">
                                             <button @click="open = !open" class="text-[10px] text-gray-500 hover:text-[#335A92] underline focus:outline-none">
                                                 Ver cambios
                                             </button>
                                             <div x-show="open" @click.away="open = false" class="absolute z-50 bg-white border border-gray-200 shadow-xl rounded-lg p-3 text-[10px] w-64 md:w-80 mt-1 max-h-40 overflow-y-auto font-mono text-gray-600 whitespace-pre-wrap dark:text-gray-600">
                                                 <strong>Old:</strong> {{ json_encode($audit->old_values) }}<br>
                                                 <strong>New:</strong> {{ json_encode($audit->new_values) }}
                                             </div>
                                         </div>
                                     @endif
                                 </div>
                             </td>
                             <td class="px-6 py-4 text-right">
                                 <div class="flex flex-col items-end">
                                     <span class="text-xs font-bold text-gray-700">
                                         {{ $audit->created_at->format('d/m/Y') }}
                                     </span>
                                     <span class="text-[10px] text-gray-400">
                                         {{ $audit->created_at->format('H:i:s') }}
                                     </span>
                                     <span class="text-[9px] text-[#335A92] font-medium bg-[#335A92]/5 px-1.5 rounded mt-0.5">
                                         {{ $audit->created_at->diffForHumans() }}
                                     </span>
                                 </div>
                             </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mb-4">
                                        <i class="fas fa-search text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-lg font-bold text-gray-700">No se encontraron registros</p>
                                    <p class="text-sm text-gray-400">Intenta con otros términos de búsqueda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
             </table>
        </div>
        
        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $audits->links() }}
        </div>
   </div>
</div>
