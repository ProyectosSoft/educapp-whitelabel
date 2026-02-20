<div class="container mx-auto">
    {{-- Header --}}
    <div class="relative bg-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        {{-- Decorative Blur --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary-400 opacity-20 filter blur-3xl"></div>
        
        <div class="relative px-8 py-10 flex flex-col md:flex-row items-center justify-between z-10">
            <div>
                <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Panel de Alumno</p>
                <h1 class="text-3xl font-bold text-white leading-tight">Mis Evaluaciones</h1>
                <p class="text-gray-400 text-sm mt-2">Historial detallado de intentos y certificaciones.</p>
            </div>
            
            <div class="mt-6 md:mt-0 relative">
                 <input wire:model="search" type="text" 
                       class="w-full md:w-64 bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm rounded-xl focus:ring-secondary focus:border-secondary block pl-4 p-2.5 placeholder-gray-400 transition-all shadow-md" 
                       placeholder="Buscar evaluación...">
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="space-y-8">
        @forelse ($evaluations as $evaluation)
            @php
                $bestAttempt = $evaluation->userAttempts->where('is_approved', true)->first();
                $latestAttempt = $evaluation->userAttempts->first(); 
                $isApproved = $bestAttempt ? true : false;
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-2xl group">
                <div class="p-8">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                        <div class="flex-1 space-y-2">
                            <div class="flex items-center gap-3">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-secondary-400 transition-colors">
                                    {{ $evaluation->name }}
                                </h2>
                                @if($isApproved)
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-500/10 text-green-400 border border-green-500/20 flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i> Aprobado
                                    </span>
                                @elseif($latestAttempt && $latestAttempt->status == 'in_progress')
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 flex items-center gap-1">
                                        <i class="fas fa-spinner fa-spin"></i> En Progreso
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-500/10 text-gray-400 border border-gray-500/20 flex items-center gap-1">
                                        <i class="fas fa-clock"></i> Pendiente
                                    </span>
                                @endif
                            </div>
                            <p class="text-base text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                <span class="bg-gray-700/50 px-2 py-1 rounded text-xs font-medium uppercase tracking-wider text-gray-300">Examen</span>
                                {{ $evaluation->exam->name }}
                            </p>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                             @if($isApproved)
                                <a href="{{ route('exams.certificate', $bestAttempt->id) }}" target="_blank" class="flex-1 lg:flex-none justify-center px-6 py-3 bg-gradient-to-r from-secondary to-secondary-600 text-primary-900 font-bold rounded-xl text-sm hover:from-secondary-400 hover:to-secondary transition-all shadow-lg shadow-secondary/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                                    <i class="fas fa-certificate text-lg"></i>
                                    <span>Descargar Certificado</span>
                                </a>
                            @endif

                            <a href="{{ route('exams.summary', $evaluation->id) }}" class="flex-1 lg:flex-none justify-center px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition flex items-center gap-2 border border-gray-200 dark:border-gray-700">
                                <span>Ver Examen</span>
                                <i class="fas fa-arrow-right"></i> 
                            </a>

                            <button wire:click="toggleAttempts({{ $evaluation->id }})" class="flex-1 lg:flex-none justify-center px-6 py-3 bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition flex items-center gap-2 border border-transparent dark:hover:border-gray-600">
                                <span>{{ $viewingAttemptsFor === $evaluation->id ? 'Ocultar' : 'Ver' }} Historial</span>
                                <i class="fas {{ $viewingAttemptsFor === $evaluation->id ? 'fa-chevron-up' : 'fa-chevron-down' }}"></i> 
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Expansion: Attempts List --}}
                @if($viewingAttemptsFor === $evaluation->id)
                    <div class="bg-gray-50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700/50 p-6 md:p-8 animate-fade-in-down">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <i class="fas fa-history mr-2"></i> Historial de Intentos
                            </h3>
                            <span class="text-xs text-gray-500 dark:text-gray-500">Total: {{ $evaluation->userAttempts->count() }} intentos</span>
                        </div>
                        
                        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-100 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-700">
                                    <tr>
                                        <th class="px-6 py-4 font-bold tracking-wider">Intento</th>
                                        <th class="px-6 py-4 font-bold tracking-wider">Fecha</th>
                                        <th class="px-6 py-4 font-bold tracking-wider">Puntaje</th>
                                        <th class="px-6 py-4 font-bold tracking-wider text-center">Estado</th>
                                        <th class="px-6 py-4 font-bold tracking-wider text-right">Certificado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                    @foreach($evaluation->userAttempts as $attempt)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group/row">
                                            <td class="px-6 py-4">
                                                <span class="font-bold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2.5 py-1 rounded-lg">
                                                    #{{ $evaluation->userAttempts->count() - $loop->index }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 font-medium">
                                                {{ $attempt->started_at->format('d M, Y') }}
                                                <span class="block text-xs text-gray-400 font-normal mt-0.5">{{ $attempt->started_at->format('h:i A') }}</span>
                                            </td>
                                            <td class="px-6 py-4 w-48">
                                                <div class="flex flex-col gap-1">
                                                    <div class="flex justify-between text-xs mb-1">
                                                        <span class="font-bold {{ $attempt->final_score >= $evaluation->passing_score ? 'text-green-500' : 'text-red-500' }}">
                                                            {{ number_format($attempt->final_score, 1) }}%
                                                        </span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700 overflow-hidden">
                                                        <div class="h-2 rounded-full transition-all duration-500 {{ $attempt->final_score >= $evaluation->passing_score ? 'bg-green-500' : 'bg-red-500' }}" 
                                                             style="width: {{ $attempt->final_score }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                 @if($attempt->is_approved)
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-green-500/10 text-green-500 border border-green-500/20">
                                                        Aprobado
                                                    </span>
                                                @elseif($attempt->status == 'pending_review')
                                                     <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                                        <i class="fas fa-clipboard-user mr-1.5 opacity-75"></i> En Revisión
                                                    </span>
                                                @elseif($attempt->status == 'void')
                                                     <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-500/10 text-red-500 border border-red-500/20 cursor-help" title="{{ $attempt->invalidation_reason }}">
                                                        Anulado <i class="fas fa-info-circle ml-1 opacity-75"></i>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                                        {{ ucfirst(str_replace('_', ' ', $attempt->status)) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                 @if($attempt->is_approved)
                                                    <a href="{{ route('exams.certificate', $attempt->id) }}" target="_blank" class="inline-flex items-center text-secondary hover:text-white hover:bg-secondary font-bold text-xs transition px-3 py-1.5 rounded-lg border border-secondary/30 hover:border-secondary">
                                                        <i class="fas fa-download mr-1.5"></i> PDF
                                                    </a>
                                                 @else
                                                    <span class="text-gray-600 dark:text-gray-600 text-xs">-</span>
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
            <div class="bg-gray-800 rounded-3xl p-16 text-center border border-gray-700 shadow-xl">
                <div class="w-20 h-20 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                    <i class="fas fa-clipboard-list text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">No has realizado ninguna evaluación aún</h3>
                <p class="text-gray-400">Tus exámenes completados aparecerán aquí.</p>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $evaluations->links() }}
        </div>
    </div>
</div>
