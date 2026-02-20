<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExamQuestionsStatsExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $questions;

    public function __construct($questions)
    {
        $this->questions = $questions;
    }

    public function collection()
    {
        return $this->questions;
    }

    public function map($row): array
    {
        $text = is_array($row) ? $row['question_text'] : $row->question_text;
        $accuracy = is_array($row) ? $row['accuracy'] : $row->accuracy;
        $times = is_array($row) ? $row['times_answered'] : $row->times_answered;

        return [
            strip_tags($text),
            number_format($accuracy, 1) . '%',
            $times,
        ];
    }

    public function headings(): array
    {
        return ['Pregunta', 'Tasa Acierto', 'Veces Respondida'];
    }

    public function title(): string
    {
        return 'Análisis Preguntas';
    }
}
