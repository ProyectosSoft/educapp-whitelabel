<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExamGeneralStatsExport implements FromArray, WithHeadings, WithTitle
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return [
            ['Total Estudiantes', $this->data['totalStudents']],
            ['Promedio Notas', $this->data['avgScore'] . '%'],
            ['Tiempo Promedio (min)', $this->data['avgTimeMinutes']],
            ['Intentos por Alumno', $this->data['avgAttemptsPerStudent']],
            ['Tasa de Finalización', $this->data['completionRate'] . '%'],
        ];
    }

    public function headings(): array
    {
        return ['Métrica', 'Valor'];
    }

    public function title(): string
    {
        return 'General';
    }
}
