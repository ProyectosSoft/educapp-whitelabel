<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamEvaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exam_id',
        'course_id',
        'section_id',
        'context_type',
        'start_mode',
        'is_visible',
        'name',
        'max_attempts',
        'wait_time_minutes',
        'time_limit_minutes',
        'passing_score',
        'is_active',
        'is_public',
        'empresa_id',
        'departamento_id',
        'user_id',
        'categoria_id',
        'subcategoria_id',
        'internal_category_id',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function course()
    {
        return $this->belongsTo(Curso::class, 'course_id');
    }

    public function section()
    {
        return $this->belongsTo(Seccion_curso::class, 'section_id');
    }

    public function internalCategory()
    {
        return $this->belongsTo(ExamCategory::class, 'internal_category_id');
    }

    // Refactored to belongsToMany for Question Bank support
    public function categories()
    {
        return $this->belongsToMany(ExamCategory::class, 'exam_evaluation_category')
                    ->withPivot(['weight_percent', 'questions_per_attempt', 'passing_percentage'])
                    ->withTimestamps();
    }

    public function userAttempts()
    {
        return $this->hasMany(ExamUserAttempt::class, 'evaluation_id');
    }
}
