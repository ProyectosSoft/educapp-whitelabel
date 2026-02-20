<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Estadísticas</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 30px; }
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .metric-box { display: inline-block; width: 30%; background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #eee; text-align: center; }
        .metric-value { font-size: 18px; font-weight: bold; display: block; }
        .metric-label { font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Estadísticas: {{ $evaluationName }}</h2>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Métricas Generales</div>
        <div style="text-align: center;">
            <div class="metric-box">
                <span class="metric-value">{{ $totalStudents }}</span>
                <span class="metric-label">Total Estudiantes</span>
            </div>
            <div class="metric-box">
                <span class="metric-value">{{ number_format($avgScore, 1) }}%</span>
                <span class="metric-label">Promedio Notas</span>
            </div>
            <div class="metric-box">
                <span class="metric-value">{{ $avgTimeMinutes }} min</span>
                <span class="metric-label">Tiempo Promedio</span>
            </div>
            <div class="metric-box">
                <span class="metric-value">{{ $avgAttemptsPerStudent }}</span>
                <span class="metric-label">Intentos/Alumno</span>
            </div>
            <div class="metric-box">
                <span class="metric-value">{{ $completionRate }}%</span>
                <span class="metric-label">Tasa Finalización</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Análisis de Preguntas (Top & Críticas)</div>
        <table>
            <thead>
                <tr>
                    <th>Pregunta</th>
                    <th style="width: 80px;">Acierto</th>
                    <th style="width: 80px;">Respuestas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $q)
                    <tr>
                        <td>{{ strip_tags($q->question_text) }}</td>
                        <td style="text-align: center; {{ $q->accuracy < 50 ? 'color: red;' : 'color: green;' }}">
                            {{ number_format($q->accuracy, 1) }}%
                        </td>
                        <td style="text-align: center;">{{ $q->times_answered }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Ranking de Estudiantes (Top 10)</div>
        <table>
            <thead>
                <tr>
                    <th>Pos</th>
                    <th>Estudiante</th>
                    <th>Mejor Nota</th>
                    <th>Intentos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $s)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $s->user->name ?? 'N/A' }}</td>
                        <td style="text-align: center;">{{ $s->max_score }}%</td>
                        <td style="text-align: center;">{{ $s->attempts_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
