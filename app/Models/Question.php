<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = ['id'];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
