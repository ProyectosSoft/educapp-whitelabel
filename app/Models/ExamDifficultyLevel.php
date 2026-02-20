<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamDifficultyLevel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'points', 'user_id'];

    // Questions associated with this difficulty level
    public function questions()
    {
        return $this->hasMany(ExamQuestion::class, 'difficulty_level_id');
    }

    // Instructor who created this level
    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
