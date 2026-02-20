<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', // Owner
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class, 'category_id');
    }

    public function evaluations()
    {
        return $this->belongsToMany(ExamEvaluation::class, 'exam_evaluation_category')
                    ->withPivot(['weight_percent', 'questions_per_attempt', 'passing_percentage'])
                    ->withTimestamps();
    }
}
