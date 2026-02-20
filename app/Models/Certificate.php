<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Curso::class, 'course_id');
    }

    public function attempt()
    {
        return $this->belongsTo(StudentAttempt::class, 'student_attempt_id');
    }
}
