<div class="min-h-screen bg-gray-900 text-white font-sans py-12 px-4 sm:px-6 lg:px-8">
     <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600 mb-8 px-2">Exámenes Disponibles</h1>
        
        @if($exams->isEmpty())
             <div class="text-center text-gray-400 py-12">
                <p>No hay exámenes disponibles en este momento.</p>
             </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($exams as $exam)
                    @foreach($exam->evaluations as $eval)
                    <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden hover:border-blue-500/50 transition duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <h2 class="text-xl font-bold text-white leading-tight">{{ $eval->name }}</h2>
                            </div>
                            <span class="inline-block px-3 py-1 bg-gray-700 text-gray-300 rounded-full text-xs font-semibold mb-4">{{ $exam->name }}</span>
                            
                            <p class="text-gray-400 mb-6 text-sm line-clamp-3 h-10">{{ $exam->description }}</p>
                            
                            <div class="flex items-center space-x-6 text-sm text-gray-500 mb-8">
                                <div class="flex items-center" title="Duración">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $eval->time_limit_minutes ?? 'Infinito' }} min
                                </div>
                                <div class="flex items-center" title="Puntaje de Aprobación">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $eval->passing_score }}%
                                </div>
                            </div>

                            @php
                                // Ensure we are checking for approval correctly. 
                                // The is_approved is cast to boolean but let's be safe.
                                $approvedAttempt = $eval->userAttempts->first(function($attempt) {
                                    return $attempt->is_approved == true;
                                });
                            @endphp

                            @if($approvedAttempt)
                                <a href="{{ route('exams.certificate', $approvedAttempt->id) }}" target="_blank" class="block w-full text-center py-3 bg-secondary hover:bg-secondary-400 text-primary-900 rounded-lg transition font-bold shadow-md shadow-secondary/30 group">
                                    <i class="fas fa-certificate mr-2 group-hover:rotate-12 transition-transform"></i> Ver Certificado
                                </a>
                            @else
                                <a href="{{ route('exams.summary', $eval->id) }}" class="block w-full text-center py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition font-medium shadow-md">
                                    Realizar
                                </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endforeach
            </div>
        @endif
     </div>
</div>
