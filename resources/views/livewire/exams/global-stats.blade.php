<div class="space-y-8 font-sans text-slate-600" x-data="globalDashboard({
    chartActivity: @entangle('chartActivity'),
    chartStatusDist: @entangle('chartStatusDist'),
    chartScoreDist: @entangle('chartScoreDist')
})">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
        {{-- Background Effects --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-50 opacity-50 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 rounded-full bg-yellow-50 opacity-50 filter blur-3xl"></div>
        
        <div class="relative z-10 w-full md:w-auto">
             <h2 class="text-2xl md:text-3xl font-bold text-[#335A92] mb-2">
                <i class="fas fa-chart-pie mr-2 text-[#ECBD2D]"></i> Dashboard General
            </h2>
            <p class="text-slate-500 text-base">Visión estratégica del rendimiento académico</p>
        </div>
        
        <div class="relative z-10 flex gap-3 flex-wrap justify-center md:justify-end">
            
            {{-- Date Filter --}}
            <div class="relative">
                <select wire:model="dateFilter" class="appearance-none bg-white text-slate-700 pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 hover:border-[#335A92] focus:outline-none focus:ring-2 focus:ring-blue-100 text-sm font-medium cursor-pointer shadow-sm transition-colors">
                    <option value="7">Últimos 7 días</option>
                    <option value="30">Últimos 30 días</option>
                    <option value="this_month">Este Mes</option>
                    <option value="all">Todo el tiempo</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-slate-400">
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
            </div>

            <a href="{{ route('author.exams.manager') }}" class="px-5 py-2.5 bg-white hover:bg-slate-50 text-[#335A92] font-semibold rounded-xl transition-all text-sm flex items-center justify-center border border-gray-200 shadow-sm hover:shadow-md">
                 <i class="fas fa-arrow-left mr-2"></i> Volver al Gestor
            </a>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Evaluations (Active context) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition duration-300">
             <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-extrabold text-[#335A92]">{{ $totalEvaluations }}</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Evaluaciones Activas</p>
            </div>
        </div>

        <!-- Approval Rate -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition duration-300">
             <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    @if($approvalRateTrend != 0)
                        <span class="text-xs font-bold px-2 py-1 rounded-full {{ $approvalRateTrend > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            <i class="fas fa-arrow-{{ $approvalRateTrend > 0 ? 'up' : 'down' }} mr-1"></i>{{ abs($approvalRateTrend) }}%
                        </span>
                    @endif
                </div>
                <h3 class="text-3xl font-extrabold text-[#335A92]">{{ $approvalRate }}%</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Tasa de Aprobación</p>
            </div>
        </div>

        <!-- Avg Time -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition duration-300">
             <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#335A92] flex items-center justify-center text-xl">
                        <i class="fas fa-clock"></i>
                    </div>
                    @if($avgDurationTrend != 0)
                        <span class="text-xs font-bold px-2 py-1 rounded-full {{ $avgDurationTrend < 0 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $avgDurationTrend > 0 ? '+' : '' }}{{ $avgDurationTrend }} min
                        </span>
                    @endif
                </div>
                <h3 class="text-3xl font-extrabold text-[#335A92]">{{ $avgDuration }} <span class="text-sm font-normal text-slate-400">min</span></h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Tiempo Promedio</p>
            </div>
        </div>

        <!-- Global Score -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition duration-300">
             <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-yellow-50 text-[#ECBD2D] flex items-center justify-center text-xl">
                        <i class="fas fa-star"></i>
                    </div>
                     @if($globalAvgScoreTrend != 0)
                        <span class="text-xs font-bold px-2 py-1 rounded-full {{ $globalAvgScoreTrend > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                             <i class="fas fa-arrow-{{ $globalAvgScoreTrend > 0 ? 'up' : 'down' }} mr-1"></i>{{ abs($globalAvgScoreTrend) }}
                        </span>
                    @endif
                </div>
                <h3 class="text-3xl font-extrabold text-[#335A92]">{{ $globalAvgScore }}%</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Promedio Global</p>
            </div>
        </div>
    </div>

    {{-- Main Activity Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Left Column: Charts --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Activity Chart --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-[#335A92] flex items-center">
                        <i class="far fa-chart-bar mr-2 text-indigo-500"></i> Rendimiento por Intentos
                    </h3>
                    <div class="flex items-center gap-4 text-xs font-medium text-slate-500">
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Aprobados</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> Reprobados</div>
                    </div>
                </div>
                <div class="h-72 w-full" wire:ignore>
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            {{-- Row 2: Score Dist & At Risk Students --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Score Distribution -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-[#335A92] mb-4 flex items-center">
                        <i class="fas fa-sort-amount-up mr-2 text-blue-500"></i> Distribución de Notas
                    </h3>
                    <div class="h-60 w-full relative" wire:ignore>
                        <canvas id="scoreDistChart"></canvas>
                    </div>
                </div>

                <!-- Students At Risk -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-100 bg-red-50 flex justify-between items-center">
                        <h3 class="text-base font-bold text-red-800">
                            <i class="fas fa-user-injured mr-2 text-red-500"></i> Estudiantes en Riesgo
                        </h3>
                        <span class="text-[10px] text-red-600 font-bold bg-white px-2 py-1 rounded-lg border border-red-100">Avg < 60%</span>
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($studentsAtRisk as $student)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                <img src="{{ $student->user->profile_photo_url ?? '' }}" class="w-8 h-8 rounded-full bg-gray-200 mr-3 border border-gray-200">
                                                <div>
                                                    <div class="font-bold text-[#335A92] text-xs">{{ $student->user->name }}</div>
                                                    <div class="text-[10px] text-slate-500">{{ $student->total_attempts }} intentos</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <span class="text-red-600 font-bold text-xs bg-red-50 px-2 py-1 rounded-full">
                                                {{ number_format($student->avg_score, 1) }}%
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-8 text-center text-slate-400 text-xs">
                                            <i class="fas fa-check-circle text-green-500 mb-2 block text-xl"></i>
                                            Sin estudiantes en riesgo crítico.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            {{-- Evaluations Tables --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Popular -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-orange-50">
                        <h3 class="text-base font-bold text-orange-800">
                            <i class="fas fa-fire mr-2 text-orange-500"></i> Más Populares
                        </h3>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($topEvaluations as $eval)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-5 py-3">
                                            <div class="font-bold text-[#335A92] text-xs truncate max-w-[150px]" title="{{ $eval->name }}">{{ $eval->name }}</div>
                                            <div class="text-[10px] text-slate-500">{{ $eval->user_attempts_count }} intentos</div>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <a href="{{ route('author.exams.statistics', $eval->id) }}" class="text-slate-400 hover:text-[#335A92] transition">
                                                <i class="fas fa-chevron-right text-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="px-6 py-6 text-center text-slate-400 text-xs">Sin datos en este periodo.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Critical -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-yellow-50">
                        <h3 class="text-base font-bold text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i> Dificultad Alta (Avg Bajo)
                        </h3>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($criticalEvaluations as $eval)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-5 py-3">
                                            <div class="font-bold text-[#335A92] text-xs truncate max-w-[150px]" title="{{ $eval->name }}">{{ $eval->name }}</div>
                                            <div class="text-[10px] text-red-500 font-medium">Avg: {{ number_format($eval->user_attempts_avg_final_score, 1) }}%</div>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <a href="{{ route('author.exams.statistics', $eval->id) }}" class="text-slate-400 hover:text-[#335A92] transition">
                                                <i class="fas fa-chevron-right text-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="px-6 py-6 text-center text-slate-400 text-xs">Sin datos suficientes.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            
            {{-- Status Doughnut --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                 <h3 class="text-lg font-bold text-[#335A92] mb-2">Estado General</h3>
                 <p class="text-xs text-slate-500 mb-6">Distribución de intentos en el periodo</p>
                 <div class="h-48 relative flex justify-center" wire:ignore>
                    <canvas id="statusChart"></canvas>
                </div>
                <div class="mt-6 grid grid-cols-2 gap-2 text-xs font-medium">
                     <div class="flex items-center text-slate-600"><span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Finalizado</div>
                     <div class="flex items-center text-slate-600"><span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span> En Progreso</div>
                     <div class="flex items-center text-slate-600"><span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span> Expirado</div>
                     <div class="flex items-center text-slate-600"><span class="w-2 h-2 rounded-full bg-gray-400 mr-2"></span> Anulado</div>
                </div>
            </div>

            {{-- Recent Activity Feed --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-slate-50">
                    <h3 class="text-base font-bold text-slate-700">
                        <i class="fas fa-history mr-2 text-slate-400"></i> Actividad Reciente
                    </h3>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($recentActivity as $attempt)
                        <div class="flex items-start space-x-3 pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                            <img src="{{ $attempt->user->profile_photo_url ?? '' }}" class="w-8 h-8 rounded-full bg-gray-200 border border-gray-200 flex-shrink-0" alt="Avatar">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-[#335A92] truncate">
                                    {{ $attempt->user->name ?? 'Usuario' }}
                                </p>
                                <p class="text-xs text-slate-500 truncate">
                                    {{ $attempt->evaluation->name ?? 'Evaluación' }}
                                </p>
                                <div class="flex items-center mt-1 space-x-2">
                                    <span class="text-[10px] uppercase font-bold px-1.5 py-0.5 rounded
                                        @if($attempt->status == 'finished' || $attempt->status == 'graded') bg-green-100 text-green-700
                                        @elseif($attempt->status == 'in_progress') bg-blue-100 text-blue-700
                                        @else bg-gray-100 text-gray-600 @endif">
                                        {{ $attempt->final_score !== null ? $attempt->final_score . '%' : $attempt->status }}
                                    </span>
                                    <span class="text-[10px] text-slate-400">{{ $attempt->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-slate-400 py-4 text-xs">Sin actividad reciente.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('globalDashboard', (params) => ({
            chartActivity: params.chartActivity,
            chartStatusDist: params.chartStatusDist,
            chartScoreDist: params.chartScoreDist,

            activityChart: null,
            scoreChart: null,
            statusChart: null,

            init() {
                this.renderCharts();
                
                // Watch for updates from Livewire
                this.$watch('chartActivity', () => this.initActivityChart());
                this.$watch('chartStatusDist', () => this.initStatusChart());
                this.$watch('chartScoreDist', () => this.initScoreChart());
            },

            renderCharts() {
                // Use a small timeout to ensure DOM is ready if needed, mostly for safety
                setTimeout(() => {
                    this.initActivityChart();
                    this.initScoreChart();
                    this.initStatusChart();
                }, 50);
            },

            initActivityChart() {
                const ctx = document.getElementById('activityChart')?.getContext('2d');
                if (!ctx) return;
                
                if (this.activityChart) this.activityChart.destroy();

                const activityData = JSON.parse(JSON.stringify(this.chartActivity));

                this.activityChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: activityData?.labels || [],
                        datasets: [
                            {
                                label: 'Aprobados',
                                data: activityData?.approved || [],
                                borderColor: '#10B981', // Green
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true,
                                pointRadius: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#10B981',
                            },
                            {
                                label: 'Reprobados',
                                data: activityData?.failed || [],
                                borderColor: '#EF4444', // Red
                                backgroundColor: 'rgba(239, 68, 68, 0.05)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true,
                                pointRadius: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#EF4444',
                                borderDash: [5, 5]
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                                ticks: { color: '#64748b', stepSize: 1 }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#64748b', maxTicksLimit: 7 }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#ffffff',
                                titleColor: '#1e293b',
                                bodyColor: '#475569',
                                borderColor: '#e2e8f0',
                                borderWidth: 1,
                                padding: 10,
                                displayColors: true,
                                boxPadding: 4
                            }
                        }
                    }
                });
            },

            initScoreChart() {
                 const ctx = document.getElementById('scoreDistChart')?.getContext('2d');
                if (!ctx) return;

                if (this.scoreChart) this.scoreChart.destroy();

                const scoreData = JSON.parse(JSON.stringify(this.chartScoreDist));

                this.scoreChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['0-20%', '21-40%', '41-60%', '61-80%', '81-100%'],
                        datasets: [{
                            label: 'Intentos',
                            data: scoreData || [0,0,0,0,0],
                            backgroundColor: [
                                'rgba(239, 68, 68, 0.6)',
                                'rgba(249, 115, 22, 0.6)', 
                                'rgba(234, 179, 8, 0.6)', 
                                'rgba(59, 130, 246, 0.6)', 
                                'rgba(16, 185, 129, 0.6)' 
                            ],
                            borderColor: [
                                'rgba(239, 68, 68, 1)',
                                'rgba(249, 115, 22, 1)', 
                                'rgba(234, 179, 8, 1)', 
                                'rgba(59, 130, 246, 1)', 
                                'rgba(16, 185, 129, 1)' 
                            ],
                            borderWidth: 1,
                            borderRadius: 4,
                            barPercentage: 0.6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { display: false },
                            x: { grid: { display: false }, ticks: { color: '#64748b', font: {size: 10} } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            },

            initStatusChart() {
                const ctx = document.getElementById('statusChart')?.getContext('2d');
                if (!ctx) return;

                if (this.statusChart) this.statusChart.destroy();

                const statusData = JSON.parse(JSON.stringify(this.chartStatusDist));

                this.statusChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Finalizado', 'En Progreso', 'Expirado', 'Anulado'],
                        datasets: [{
                            data: statusData || [0,0,0,0],
                            backgroundColor: ['#10B981', '#3B82F6', '#EF4444', '#94a3b8'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }, cutout: '75%' }
                    }
                });
            }
        }));
    });
</script>
@endpush
