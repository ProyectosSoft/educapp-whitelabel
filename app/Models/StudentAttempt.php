<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttempt extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'completed_at' => 'datetime',
        'passed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
