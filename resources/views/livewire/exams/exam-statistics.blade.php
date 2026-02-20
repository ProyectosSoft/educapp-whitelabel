<div class="space-y-6 font-sans text-slate-600">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-50 opacity-50 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-yellow-50 opacity-50 filter blur-3xl"></div>
        
        <div class="relative z-10 w-full md:w-auto">
             <h2 class="text-2xl md:text-3xl font-bold text-[#335A92] mb-2">
                <i class="fas fa-chart-line mr-2 text-[#ECBD2D]"></i> Estadísticas: {{ $evaluation->name }}
            </h2>
            <p class="text-slate-500 text-base">Análisis detallado de rendimiento y métricas clave.</p>
        </div>
        
        <div class="relative z-10 flex flex-wrap gap-3 justify-center md:justify-end">
            <button wire:click="exportExcel" wire:loading.attr="disabled" class="px-5 py-2.5 bg-green-50 text-green-700 hover:bg-green-100 font-bold rounded-xl transition-all text-sm flex items-center shadow-sm border border-green-200">
                <i class="fas fa-file-excel mr-2 text-green-600" wire:loading.remove target="exportExcel"></i>
                <i class="fas fa-spinner fa-spin mr-2 text-green-600" wire:loading target="exportExcel"></i> 
                Excel
            </button>
            <button wire:click="exportPdf" wire:loading.attr="disabled" class="px-5 py-2.5 bg-red-50 text-red-700 hover:bg-red-100 font-bold rounded-xl transition-all text-sm flex items-center shadow-sm border border-red-200">
                <i class="fas fa-file-pdf mr-2 text-red-600" wire:loading.remove target="exportPdf"></i>
                <i class="fas fa-spinner fa-spin mr-2 text-red-600" wire:loading target="exportPdf"></i> 
                PDF
            </button>
            <a href="{{ route('author.exams.manager') }}" class="px-5 py-2.5 bg-white text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm flex items-center justify-center border border-gray-200 shadow-sm">
                 <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    {{-- General Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-users text-6xl text-[#335A92]"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Total Estudiantes</p>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalStudents }}</h3>
            <p class="text-xs text-[#335A92] mt-2 font-bold bg-blue-50 inline-block px-2 py-1 rounded">Usuarios únicos</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-star text-6xl text-yellow-500"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Promedio Notas</p>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($avgScore, 1) }}%</h3>
            <p class="text-xs {{ $avgScore >= $evaluation->passing_score ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} mt-2 font-bold inline-block px-2 py-1 rounded">
                {{ $avgScore >= $evaluation->passing_score ? 'Aprobatorio Global' : 'Crítico Global' }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-trophy text-6xl text-green-500"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Nota Máxima</p>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($maxScore, 1) }}%</h3>
            <p class="text-xs text-green-600 bg-green-50 mt-2 font-bold inline-block px-2 py-1 rounded">Mejor desempeño</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-arrow-down text-6xl text-red-500"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Nota Mínima</p>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($minScore, 1) }}%</h3>
            <p class="text-xs text-red-600 bg-red-50 mt-2 font-bold inline-block px-2 py-1 rounded">Peor desempeño</p>
        </div>
    </div>

    {{-- Row 2: 3 Cards Centered --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-clock text-6xl text-purple-500"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Tiempo Promedio</p>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $avgTimeMinutes }} min</h3>
            <p class="text-xs text-purple-600 bg-purple-50 mt-2 font-bold inline-block px-2 py-1 rounded">Por intento</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-redo text-6xl text-indigo-500"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Intentos / Alumno</p>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $avgAttemptsPerStudent }}</h3>
            <p class="text-xs text-indigo-600 bg-indigo-50 mt-2 font-bold inline-block px-2 py-1 rounded">Frecuencia</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-check-circle text-6xl text-teal-500"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Tasa Finalización</p>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $completionRate }}%</h3>
            <p class="text-xs text-teal-600 bg-teal-50 mt-2 font-bold inline-block px-2 py-1 rounded">Completados</p>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-slate-500 uppercase mb-6 border-b border-gray-100 pb-2">Distribución de Notas</h3>
            <div class="h-64 relative">
                <canvas id="scoreDistributionChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-slate-500 uppercase mb-6 border-b border-gray-100 pb-2">Tasa de Aprobación</h3>
            <div class="h-64 relative flex justify-center">
                <canvas id="approvalRateChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-2">
                <div>
                    <h3 class="text-sm font-bold text-slate-500 uppercase">Estado de Intentos</h3>
                    <p class="text-[10px] text-slate-400 mt-0.5" id="statusChartHint">
                        <i class="fas fa-mouse-pointer mr-1"></i> Clic en "Anulado" para ver detalles
                    </p>
                </div>
                <button id="resetStatusChartBtn" class="hidden text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 px-3 py-1 rounded-lg transition font-bold">
                    <i class="fas fa-undo mr-1"></i> Volver
                </button>
            </div>
            <div class="h-64 relative flex justify-center">
                <canvas id="statusDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Best Questions --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-green-50/50">
                <h3 class="text-lg font-bold text-green-700 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                        <i class="fas fa-arrow-up text-sm"></i>
                    </div>
                    Top Preguntas (Mayor Acierto)
                </h3>
            </div>
            <div class="p-4 h-80 overflow-y-auto pr-2 custom-scrollbar">
                @if(count($topQuestions) > 0)
                <ul class="space-y-3">
                    @foreach($topQuestions as $q)
                        <li class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 hover:bg-white border border-transparent hover:border-green-100 hover:shadow-sm transition group">
                            <div class="flex-shrink-0 flex items-center gap-2 mt-0.5">
                                <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-white border border-slate-200 text-slate-400 text-xs font-bold shadow-sm">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="bg-green-100 text-green-700 font-bold rounded-lg px-2 py-1 text-xs whitespace-nowrap border border-green-200">
                                    {{ number_format($q->accuracy, 1) }}%
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-slate-700 text-sm font-medium leading-relaxed group-hover:text-green-800 transition-colors" title="{{ strip_tags($q->question_text) }}">
                                    {{ $q->question_text }}
                                </p>
                                <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-wider">Respondida {{ $q->times_answered }} veces</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @else
                    <div class="h-full flex flex-col items-center justify-center text-slate-400">
                        <i class="fas fa-chart-bar text-4xl mb-2 opacity-20"></i>
                        <p class="text-sm">Sin datos suficientes.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Worst Questions --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-red-50/50">
                <h3 class="text-lg font-bold text-red-700 flex items-center">
                     <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center mr-3">
                        <i class="fas fa-arrow-down text-sm"></i>
                    </div>
                    Preguntas Críticas (Menor Acierto)
                </h3>
            </div>
            <div class="p-4 h-80 overflow-y-auto pr-2 custom-scrollbar">
                @if(count($worstQuestions) > 0)
                <ul class="space-y-3">
                    @foreach($worstQuestions as $q)
                        <li class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 hover:bg-white border border-transparent hover:border-red-100 hover:shadow-sm transition group">
                            <div class="flex-shrink-0 flex items-center gap-2 mt-0.5">
                                <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-white border border-slate-200 text-slate-400 text-xs font-bold shadow-sm">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="bg-red-100 text-red-700 font-bold rounded-lg px-2 py-1 text-xs whitespace-nowrap border border-red-200">
                                    {{ number_format($q->accuracy, 1) }}%
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-slate-700 text-sm font-medium leading-relaxed group-hover:text-red-800 transition-colors" title="{{ strip_tags($q->question_text) }}">
                                    {{ $q->question_text }}
                                </p>
                                <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-wider">Respondida {{ $q->times_answered }} veces</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @else
                    <div class="h-full flex flex-col items-center justify-center text-slate-400">
                        <i class="fas fa-chart-bar text-4xl mb-2 opacity-20"></i>
                        <p class="text-sm">Sin datos suficientes.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Top Students Ranking Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Table Header --}}
        <div class="bg-white border-b border-gray-100 px-6 py-5">
            <h3 class="text-lg font-bold text-[#335A92] flex items-center">
                <i class="fas fa-medal text-[#ECBD2D] mr-3 text-xl"></i> Ranking de Estudiantes (Top 10)
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-bold">Posición</th>
                        <th class="px-6 py-4 font-bold">Estudiante</th>
                        <th class="px-6 py-4 font-bold text-center">Mejor Nota</th>
                        <th class="px-6 py-4 font-bold text-center">Intentos Totales</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($topStudents as $index => $ranking)
                        <tr class="hover:bg-blue-50/30 transition duration-150 group">
                            <td class="px-6 py-4 font-bold text-slate-700">
                                @if($index == 0) 
                                    <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center shadow-sm">1</div>
                                @elseif($index == 1) 
                                    <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center shadow-sm">2</div>
                                @elseif($index == 2) 
                                    <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shadow-sm">3</div>
                                @else 
                                    <span class="pl-3 text-slate-400 font-medium">#{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $ranking->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=User&color=7F9CF5&background=EBF4FF' }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                                    <span class="font-bold text-slate-700 group-hover:text-[#335A92] transition-colors">{{ $ranking->user->name ?? 'Usuario Eliminado' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                    {{ $ranking->max_score }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-slate-500 font-mono font-medium">
                                {{ $ranking->attempts_count }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                                <i class="fas fa-users-slash text-4xl mb-3 opacity-30"></i>
                                <p class="font-medium">No hay datos de estudiantes disponibles aún.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Shared Options
        const sharedOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#64748b', // Slate-500
                        font: { family: "'Inter', sans-serif", size: 12, weight: 600 },
                        padding: 20
                    }
                }
            }
        };

        // Score Distribution
        const ctxDist = document.getElementById('scoreDistributionChart').getContext('2d');
        new Chart(ctxDist, {
            type: 'bar',
            data: {
                labels: ['0-20%', '21-40%', '41-60%', '61-80%', '81-100%'],
                datasets: [{
                    label: 'Intentos',
                    data: @json($chartDistData),
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.8)', // Red
                        'rgba(249, 115, 22, 0.8)', // Orange
                        'rgba(234, 179, 8, 0.8)',  // Yellow
                        'rgba(59, 130, 246, 0.8)', // Blue
                        'rgba(16, 185, 129, 0.8)'  // Green
                    ],
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                ...sharedOptions,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', drawBorder: false }, // Slate-100
                        ticks: { color: '#94a3b8' } // Slate-400
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { weight: 600 } } // Slate-500
                    }
                }
            }
        });

        // Approval Rate
        const ctxApproval = document.getElementById('approvalRateChart').getContext('2d');
        new Chart(ctxApproval, {
            type: 'doughnut',
            data: {
                labels: ['Aprobados', 'Reprobados'],
                datasets: [{
                    data: @json($chartApprovalData),
                    backgroundColor: [
                        '#10B981', // Emerald-500
                        '#EF4444'  // Red-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                ...sharedOptions,
                cutout: '75%'
            }
        });

        // Status Distribution
        let statusChart = null;
        const ctxStatus = document.getElementById('statusDistributionChart').getContext('2d');
        const statusDataInitial = {
            labels: ['Finalizado', 'En Progreso', 'Expirado', 'Anulado'],
            datasets: [{
                data: @json($chartStatusData),
                backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#94a3b8'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        };

        const initStatusChart = () => {
             if(statusChart) statusChart.destroy();
             
             statusChart = new Chart(ctxStatus, {
                type: 'doughnut',
                data: statusDataInitial,
                options: {
                    ...sharedOptions,
                    cutout: '75%',
                    onClick: (e, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            if (index === 3) { // Anulado
                                const voidReasons = @json($voidReasons);
                                if (Object.keys(voidReasons).length > 0) {
                                    showVoidReasonsChart(voidReasons);
                                }
                            }
                        }
                    }
                }
            });
            document.getElementById('resetStatusChartBtn').classList.add('hidden');
            document.getElementById('statusChartHint').classList.remove('hidden');
        };

        const showVoidReasonsChart = (reasons) => {
            const labels = Object.keys(reasons);
            const data = Object.values(reasons);
            // Palette consistent with light theme
            const colors = ['#f87171', '#fb923c', '#fbbf24', '#a3e635', '#22d3ee', '#818cf8', '#c084fc', '#f472b6'];

            if(statusChart) statusChart.destroy();

            statusChart = new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    ...sharedOptions,
                    cutout: '60%'
                }
            });
            document.getElementById('resetStatusChartBtn').classList.remove('hidden');
            document.getElementById('statusChartHint').classList.add('hidden');
        };

        // Initialize
        initStatusChart();

        // Reset Listener
        document.getElementById('resetStatusChartBtn').addEventListener('click', () => {
            initStatusChart();
        });

    });
</script>
@endpush
