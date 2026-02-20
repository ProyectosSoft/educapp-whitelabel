<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSession extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'started_at' => 'datetime',
        'last_activity_at' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function course() {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function lesson() {
        return $this->belongsTo(Leccioncurso::class, 'last_lesson_id');
    }
}
