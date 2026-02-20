<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExamStatisticsExport implements WithMultipleSheets
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new ExamGeneralStatsExport($this->data),
            new ExamQuestionsStatsExport($this->data['questions']),
            new ExamStudentsStatsExport($this->data['students']),
        ];
    }
}
