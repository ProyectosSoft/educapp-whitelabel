<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExamStudentsStatsExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students;
    }

    public function map($row): array
    {
        $user = is_array($row) ? ($row['user'] ?? null) : $row->user;
        
        $name = is_array($user) ? ($user['name'] ?? 'N/A') : ($user->name ?? 'N/A');
        $email = is_array($user) ? ($user['email'] ?? 'N/A') : ($user->email ?? 'N/A');
        
        $score = is_array($row) ? $row['max_score'] : $row->max_score;
        $attempts = is_array($row) ? $row['attempts_count'] : $row->attempts_count;

        return [
            $name,
            $email,
            $score . '%',
            $attempts,
        ];
    }

    public function headings(): array
    {
        return ['Estudiante', 'Email', 'Mejor Nota', 'Intentos'];
    }

    public function title(): string
    {
        return 'Ranking Estudiantes';
    }
}
