<?php

namespace App\Exports\Exams;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuestionsTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [
            // Row 1: Example Data
            [
                'Matemáticas Básicas', // categoria
                'Baja', // dificultad
                'cerrada', // tipo
                '¿Cuánto es 2 + 2?', // enunciado
                '4', // opcion_1
                'SI', // es_correcta_1
                '3', // opcion_2
                'NO', // es_correcta_2
                '5', // opcion_3
                'NO', // es_correcta_3
                '10', // opcion_4
                'NO', // es_correcta_4
                'Suma básica' // retroalimentacion
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'categoria',
            'dificultad',
            'tipo',
            'enunciado',
            'opcion_1',
            'es_correcta_1',
            'opcion_2',
            'es_correcta_2',
            'opcion_3',
            'es_correcta_3',
            'opcion_4',
            'es_correcta_4',
            'opcion_5', // Extra
            'es_correcta_5', // Extra
            'retroalimentacion'
        ];
    }
}
