<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject',
        'marks',
        'total_marks',
        'grade',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
