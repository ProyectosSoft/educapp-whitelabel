<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'difficulty_level_id',
        'question_text',
        'type', // closed, open
        'value_percent',
        'feedback',
    ];

    public function category()
    {
        return $this->belongsTo(ExamCategory::class, 'category_id');
    }

    public function difficultyLevel()
    {
        return $this->belongsTo(ExamDifficultyLevel::class, 'difficulty_level_id');
    }

    public function options()
    {
        return $this->hasMany(ExamAnswerOption::class, 'question_id');
    }
}
