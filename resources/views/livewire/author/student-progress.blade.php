<div>
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="close"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Progreso de: <span class="font-bold text-indigo-600">{{ $student->name }}</span>
                                </h3>
                                
                                {{-- Tabs Navigation --}}
                                <div class="mt-4 border-b border-gray-200">
                                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                        <button wire:click="setTab('sessions')" class="{{ $activeTab === 'sessions' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                            Sesiones de Estudio
                                        </button>
                                        <button wire:click="setTab('evaluations')" class="{{ $activeTab === 'evaluations' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                            Evaluaciones
                                        </button>
                                        <button wire:click="setTab('details')" class="{{ $activeTab === 'details' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                            Detalle del Curso
                                        </button>
                                        {{-- Future: Add Detailed Progress Tab --}}
                                    </nav>
                                </div>

                                {{-- Tab Content: Sessions --}}
                                @if($activeTab === 'sessions')
                                    <div class="mt-4">
                                        @if(count($sessions) > 0)
                                            <div class="overflow-hidden border border-gray-200 rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inicio</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Actividad</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lección</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach($sessions as $session)
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                    <div x-data="{ 
                                                                        localDate: new Date('{{ $session->started_at->toIso8601String() }}').toLocaleString('es-CO', { 
                                                                            day: '2-digit', 
                                                                            month: '2-digit', 
                                                                            year: 'numeric', 
                                                                            hour: '2-digit', 
                                                                            minute: '2-digit', 
                                                                            hour12: false 
                                                                        }) 
                                                                    }">
                                                                        <span x-text="localDate"></span>
                                                                    </div>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                     <div x-data="{ 
                                                                        localDate: new Date('{{ $session->last_activity_at->toIso8601String() }}').toLocaleString('es-CO', { 
                                                                            day: '2-digit', 
                                                                            month: '2-digit', 
                                                                            year: 'numeric', 
                                                                            hour: '2-digit', 
                                                                            minute: '2-digit', 
                                                                            hour12: false 
                                                                        }) 
                                                                    }">
                                                                    </div>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                                                    {{ $session->ip_address ?? 'N/A' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    {{ $session->lesson ? Str::limit($session->lesson->nombre, 20) : '-' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    {{ gmdate('H:i:s', $session->total_time) }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <div class="flex items-center">
                                                                        <span class="text-sm font-medium text-gray-900 mr-2">{{ $session->end_progress }}%</span>
                                                                        <div class="w-full bg-gray-200 rounded-full h-1.5 w-16">
                                                                            <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $session->end_progress }}%"></div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-4">
                                                {{ $sessions->links() }}
                                            </div>
                                        @else
                                            <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                                <i class="fas fa-history text-3xl mb-2 text-gray-400"></i>
                                                <p>No hay sesiones de estudio registradas.</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Tab Content: Details (New) --}}
                                @if($activeTab === 'details')
                                    <div class="mt-4 space-y-4">
                                        @foreach($courseDetails as $section)
                                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                                <div class="flex justify-between items-center mb-2">
                                                    <h4 class="font-bold text-gray-800">{{ $section['name'] }}</h4>
                                                    <span class="text-xs font-semibold text-gray-600">
                                                        {{ $section['completed'] }}/{{ $section['total'] }} Lecciones
                                                    </span>
                                                </div>
                                                <div class="relative pt-1">
                                                    <div class="flex mb-2 items-center justify-between">
                                                        <div>
                                                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $section['percentage'] == 100 ? 'text-green-600 bg-green-200' : 'text-indigo-600 bg-indigo-200' }}">
                                                                {{ $section['percentage'] }}% Completado
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                                                        <div style="width:{{ $section['percentage'] }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $section['percentage'] == 100 ? 'bg-green-500' : 'bg-indigo-500' }}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Tab Content: Evaluations --}}
                                @if($activeTab === 'evaluations')
                                    @if($selectedAttempt)
                                        <!-- Detalle del Intento -->
                                        <div class="mt-4">
                                            <button wire:click="closeAttemptDetails" class="mb-4 text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                                                <i class="fas fa-arrow-left mr-2"></i> Volver al historial
                                            </button>
                                            
                                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                                                    <div>
                                                        <h4 class="font-bold text-gray-800 text-lg">{{ $selectedAttempt->evaluation->name }}</h4>
                                                        
                                                        <div class="flex items-center mt-1 space-x-2">
                                                            <span class="px-2 py-1 text-xs rounded-full {{ $selectedAttempt->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                {{ $selectedAttempt->passed ? 'Aprobado' : 'Reprobado' }} ({{ $selectedAttempt->score }}%)
                                                            </span>
                                                            
                                                            @if($selectedAttempt->closing_reason)
                                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-700" title="Razón de cierre">
                                                                    <i class="fas fa-info-circle mr-1"></i> 
                                                                    {{ match($selectedAttempt->closing_reason) {
                                                                        'time_out' => 'Tiempo Agotado',
                                                                        'change_tab' => 'Cambio de Pestaña',
                                                                        'window_blur' => 'Ventana Inactiva',
                                                                        'devtools_debugger' => 'DevTools Detectado',
                                                                        'completed' => 'Finalizado Correctamente',
                                                                        default => $selectedAttempt->closing_reason
                                                                    } }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center bg-white p-2 rounded shadow-sm border border-gray-200">
                                                        <label class="text-sm text-gray-600 mr-2 font-medium">Ver Intento:</label>
                                                        <select wire:change="loadAttempt($event.target.value)" class="form-select text-sm border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500">
                                                            @foreach($selectedAttempt->evaluation->attempts->where('user_id', $student->id)->sortByDesc('created_at') as $att)
                                                                <option value="{{ $att->id }}" {{ $selectedAttempt->id == $att->id ? 'selected' : '' }}>
                                                                     Intento #{{ $att->attempt_number }} - {{ $att->created_at->format('d/m/Y H:i') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="space-y-4">
                                                    @foreach($selectedAttempt->answers as $index => $answer)
                                                        <div class="bg-white p-3 rounded shadow-sm border {{ $answer->is_correct ? 'border-green-200' : 'border-red-200' }}">
                                                            <p class="font-bold text-sm text-gray-700 mb-2">{{ $index + 1 }}. {{ $answer->question->statement }}</p>
                                                            
                                                            <div class="ml-4 text-sm">
                                                                <p class="{{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                                                                    <i class="fas {{ $answer->is_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                                    Tu respuesta: {{ $answer->answer ? $answer->answer->text : 'N/A' }}
                                                                </p>
                                                                @if(!$answer->is_correct)
                                                                    <p class="text-gray-500 mt-1 text-xs">
                                                                        Respuesta correcta: {{ $answer->question->answers->where('is_correct', true)->first()->text ?? 'N/A' }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Lista de Evaluaciones -->
                                        <div class="mt-4">
                                            <div class="overflow-hidden border border-gray-200 rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluación</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intentos</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Último Puntaje</th>
                                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @forelse($evaluations as $eval)
                                                            @php
                                                                $attemptsTaken = $eval->attempts->count();
                                                                $latestAttempt = $eval->attempts->first(); // Ordered by desc in query
                                                                $extraAttempts = $eval->exceptions->first()->extra_attempts ?? 0;
                                                                $maxAttempts = $eval->max_attempts + $extraAttempts;
                                                                $passed = $eval->attempts->where('passed', true)->isNotEmpty();
                                                                $canGrant = $attemptsTaken >= $maxAttempts;
                                                            @endphp
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                    {{ $eval->name }}
                                                                    @if($extraAttempts > 0)
                                                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800" title="Se han concedido {{ $extraAttempts }} intentos extra">
                                                                            +{{ $extraAttempts }} extra
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    @if($passed)
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aprobado</span>
                                                                    @elseif($attemptsTaken > 0)
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Reprobado</span>
                                                                    @else
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Sin iniciar</span>
                                                                    @endif
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    <span class="{{ $attemptsTaken >= $maxAttempts ? 'text-red-600 font-bold' : '' }}">
                                                                        {{ $attemptsTaken }}
                                                                    </span> 
                                                                    / {{ $maxAttempts }}
                                                                    @if($attemptsTaken >= $eval->max_attempts && $extraAttempts == 0)
                                                                         <i class="fas fa-exclamation-circle text-red-500 ml-1" title="Límite alcanzado"></i>
                                                                    @endif
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                                                    {{ $latestAttempt ? $latestAttempt->score . '%' : '-' }}
                                                                </td>
                                                                <td class="px-6 py-4 text-right text-sm font-medium">
                                                                    <div class="flex flex-wrap justify-end gap-2">
                                                                        @if($canGrant)
                                                                            <button wire:click="grantExtraAttempt({{ $eval->id }})" class="text-green-600 hover:text-green-900 font-bold text-xs border border-green-600 rounded px-2 py-1 hover:bg-green-50 transition whitespace-nowrap">
                                                                                <i class="fas fa-plus-circle"></i> +1
                                                                            </button>
                                                                        @endif
                                                                        
                                                                        @if($latestAttempt)
                                                                            <button wire:click="showAttemptDetails({{ $latestAttempt->id }})" class="text-indigo-600 hover:text-indigo-900 border border-indigo-600 rounded px-2 py-1 text-xs font-medium bg-indigo-50 hover:bg-indigo-100 transition whitespace-nowrap">
                                                                                <i class="fas fa-eye mr-1"></i> Detalles
                                                                            </button>
                                                                        @else
                                                                            <span class="text-gray-400 cursor-not-allowed self-center">Sin intentos</span>
                                                                        @endif

                                                                        @if($passedAttempt = $eval->attempts->where('passed', true)->first())
                                                                            @if($eval->course_id)
                                                                                <a href="{{ route('certificates.download', ['attempt' => $passedAttempt->id]) }}" target="_blank" class="text-purple-600 hover:text-purple-900 border border-purple-600 rounded px-2 py-1 text-xs font-medium bg-purple-50 hover:bg-purple-100 transition whitespace-nowrap" title="Ver Certificado">
                                                                                    <i class="fas fa-certificate mr-1"></i> Certif.
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No hay evaluaciones configuradas para este curso.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-4">
                                                {{ $evaluations->links() }}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="close" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
