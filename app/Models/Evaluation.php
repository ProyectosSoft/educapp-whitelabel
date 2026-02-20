<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Curso::class);
    }

    public function section()
    {
        return $this->belongsTo(Seccion_curso::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(StudentAttempt::class);
    }

    public function exceptions()
    {
        return $this->hasMany(EvaluationException::class);
    }
}
