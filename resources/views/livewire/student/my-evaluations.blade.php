<div>
    {{-- Hero Header Section --}}
    <div class="bg-white rounded-[2rem] shadow-lg shadow-gray-200/50 ring-1 ring-gray-100 p-8 md:p-12 relative overflow-hidden group mb-8">
        <!-- Decorative background elements -->
        <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3 pointer-events-none transition-transform duration-700 group-hover:scale-110"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary-50/50 rounded-full blur-3xl transform -translate-x-1/3 translate-y-1/3 pointer-events-none transition-transform duration-700 group-hover:scale-105"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 bg-primary-900 rounded-2xl flex items-center justify-center shadow-md shadow-primary-900/20 transform group-hover:scale-105 transition-all duration-300 ring-1 ring-primary-100">
                        <i class="fas fa-clipboard-check text-4xl text-white"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-primary-900 mb-2 tracking-tight">
                        Mis Evaluaciones
                    </h1>
                    <div class="flex items-center justify-center md:justify-start gap-3 mt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary-50 text-primary-800 text-xs font-bold ring-1 ring-primary-100 shadow-sm">
                            <i class="fas fa-user-graduate text-secondary"></i> Panel de Alumno
                        </span>
                        <span class="text-xs font-medium text-gray-500">
                            Historial detallado de intentos y certificaciones.
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-auto mt-4 md:mt-0 relative group/search">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400 group-hover/search:text-primary-600 transition-colors"></i>
                </div>
                <input wire:model="search" type="text" 
                       class="w-full md:w-72 bg-gray-50 ring-1 ring-gray-200 text-gray-700 text-sm font-medium rounded-xl focus:ring-2 focus:ring-primary-500/30 transition-all outline-none py-3 pl-11 pr-4 shadow-sm hover:bg-white" 
                       placeholder="Buscar evaluación...">
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="space-y-6">
        @forelse ($evaluations as $evaluation)
            @php
                $bestAttempt = $evaluation->userAttempts->where('is_approved', true)->first();
                $latestAttempt = $evaluation->userAttempts->first(); 
                $isApproved = $bestAttempt ? true : false;
            @endphp

            <div class="bg-white rounded-[2rem] shadow-sm ring-1 ring-gray-100 overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-primary-900/10 hover:-translate-y-1 group">
                <div class="p-6 md:p-8 relative">
                    {{-- Color Accent Bar --}}
                    @if($isApproved)
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-green-500 transition-opacity duration-300"></div>
                    @elseif($latestAttempt && $latestAttempt->status == 'in_progress')
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500 transition-opacity duration-300"></div>
                    @else
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-gray-300 transition-opacity duration-300"></div>
                    @endif

                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 pl-4 lg:pl-0">
                        <div class="flex-1 space-y-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="text-xl font-extrabold text-primary-900 group-hover:text-secondary transition-colors duration-300">
                                    {{ $evaluation->name }}
                               </h2>
                                @if($isApproved)
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-md bg-green-50 text-green-700 ring-1 ring-green-200 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fas fa-check-circle"></i> Aprobado
                                    </span>
                                @elseif($latestAttempt && $latestAttempt->status == 'in_progress')
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-md bg-secondary-50 text-secondary-700 ring-1 ring-secondary-200 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fas fa-spinner fa-spin"></i> En Progreso
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-md bg-gray-50 text-gray-600 ring-1 ring-gray-200 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fas fa-clock"></i> Pendiente
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                <span class="bg-primary-50 text-primary-800 ring-1 ring-primary-100 px-2.5 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider flex items-center">
                                    <i class="fas fa-book mr-1.5 text-secondary"></i> Examen
                                </span>
                                {{ $evaluation->exam->name }}
                            </p>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                             @if($isApproved)
                                <a href="{{ route('exams.certificate', $bestAttempt->id) }}" target="_blank" class="flex-1 lg:flex-none justify-center px-5 py-2.5 bg-accent text-primary-950 font-bold rounded-xl text-xs hover:bg-yellow-400 transition-all shadow-sm shadow-accent/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                                    <i class="fas fa-certificate text-base"></i>
                                    <span>Certificado</span>
                                </a>
                            @endif

                            <a href="{{ route('exams.summary', $evaluation->id) }}" class="flex-1 lg:flex-none justify-center px-5 py-2.5 bg-white text-gray-600 font-bold rounded-xl text-xs hover:text-primary-900 hover:bg-gray-50 transition-colors flex items-center gap-2 ring-1 ring-gray-200 shadow-sm">
                                <span>Ver Examen</span>
                                <i class="fas fa-arrow-right"></i> 
                            </a>

                            <button wire:click="toggleAttempts({{ $evaluation->id }})" class="flex-1 lg:flex-none justify-center px-5 py-2.5 bg-primary-50 text-primary-800 font-bold rounded-xl text-xs hover:bg-primary-900 hover:text-white transition-all flex items-center gap-2 ring-1 ring-primary-100 shadow-sm">
                                <span>{{ $viewingAttemptsFor === $evaluation->id ? 'Ocultar' : 'Ver' }} Historial</span>
                                <i class="fas {{ $viewingAttemptsFor === $evaluation->id ? 'fa-chevron-up' : 'fa-chevron-down' }}"></i> 
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Expansion: Attempts List --}}
                @if($viewingAttemptsFor === $evaluation->id)
                    <div class="bg-gray-50/50 border-t border-gray-100 p-6 md:p-8 relative z-10 transition-all">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-sm font-extrabold text-primary-900 tracking-tight flex items-center">
                                <i class="fas fa-history mr-2 text-secondary"></i> Historial de Intentos
                            </h3>
                            <span class="text-xs font-bold text-gray-500 bg-white ring-1 ring-gray-200 px-3 py-1.5 rounded-lg shadow-sm">
                                {{ $evaluation->userAttempts->count() }} intentos totales
                            </span>
                        </div>
                        
                        <div class="overflow-x-auto rounded-xl ring-1 ring-gray-200 bg-white shadow-sm">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-primary-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-[11px] font-extrabold text-primary-900 uppercase tracking-wider">Intento</th>
                                        <th class="px-6 py-4 text-[11px] font-extrabold text-primary-900 uppercase tracking-wider">Fecha</th>
                                        <th class="px-6 py-4 text-[11px] font-extrabold text-primary-900 uppercase tracking-wider">Puntaje</th>
                                        <th class="px-6 py-4 text-[11px] font-extrabold text-primary-900 uppercase tracking-wider text-center">Estado</th>
                                        <th class="px-6 py-4 text-[11px] font-extrabold text-primary-900 uppercase tracking-wider text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($evaluation->userAttempts as $attempt)
                                        <tr class="hover:bg-gray-50 transition-colors group/row">
                                            <td class="px-6 py-4">
                                                <span class="font-black text-primary-900 bg-primary-50 ring-1 ring-primary-100 px-3 py-1.5 rounded-lg text-xs">
                                                    #{{ $evaluation->userAttempts->count() - $loop->index }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-gray-800 text-sm">
                                                    {{ $attempt->started_at->format('d M, Y') }}
                                                </div>
                                                <div class="text-[10px] text-gray-500 font-medium mt-0.5 tracking-wider">
                                                    {{ $attempt->started_at->format('h:i A') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 w-56">
                                                <div class="flex flex-col gap-1.5">
                                                    <div class="flex justify-between items-center text-xs">
                                                        <span class="font-black {{ $attempt->final_score >= $evaluation->passing_score ? 'text-green-600' : 'text-red-500' }}">
                                                            {{ number_format($attempt->final_score, 1) }}%
                                                        </span>
                                                        <span class="text-[10px] font-bold text-gray-400">Min. {{ number_format($evaluation->passing_score, 0) }}%</span>
                                                    </div>
                                                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                                        <div class="h-1.5 rounded-full transition-all duration-500 {{ $attempt->final_score >= $evaluation->passing_score ? 'bg-green-500' : 'bg-red-500' }}" 
                                                             style="width: {{ $attempt->final_score }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                 @if($attempt->is_approved)
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] uppercase font-bold bg-green-50 text-green-700 ring-1 ring-green-200">
                                                        Aprobado
                                                    </span>
                                                @elseif($attempt->status == 'pending_review')
                                                     <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] uppercase font-bold bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200">
                                                        <i class="fas fa-clipboard-user mr-1.5 opacity-75"></i> En Revisión
                                                    </span>
                                                @elseif($attempt->status == 'void')
                                                     <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] uppercase font-bold bg-red-50 text-red-700 ring-1 ring-red-200 cursor-help" title="{{ $attempt->invalidation_reason }}">
                                                        Anulado <i class="fas fa-info-circle ml-1 opacity-75"></i>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] uppercase font-bold bg-gray-50 text-gray-600 ring-1 ring-gray-200">
                                                        {{ ucfirst(str_replace('_', ' ', $attempt->status)) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                 @if($attempt->is_approved)
                                                    <a href="{{ route('exams.certificate', $attempt->id) }}" target="_blank" class="inline-flex items-center text-primary-600 hover:text-white hover:bg-primary-900 font-bold text-[10px] uppercase tracking-wider transition-colors px-3 py-1.5 rounded-lg ring-1 ring-primary-200 hover:ring-primary-900 shadow-sm">
                                                        <i class="fas fa-download mr-1.5"></i> PDF
                                                    </a>
                                                 @else
                                                    <span class="text-gray-400 font-bold text-sm">-</span>
                                                 @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-[2rem] p-12 md:p-16 text-center shadow-sm ring-1 ring-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary-50/50 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
                <div class="relative z-10 max-w-sm mx-auto">
                    <div class="w-20 h-20 bg-primary-50 text-primary-900 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm ring-1 ring-primary-100 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                        <i class="fas fa-clipboard-list text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-primary-900 mb-3 tracking-tight">Sin Evaluaciones</h3>
                    <p class="text-gray-500 text-sm font-medium mb-8">No has realizado ninguna evaluación aún. Tus exámenes completados aparecerán aquí para que revises tus certificados.</p>
                </div>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $evaluations->links() }}
        </div>
    </div>
</div>
