<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'student_id',
        'teacher_id',
        'video_path',
        'youtube_url',
        'status' // Add status to fillable if not already there
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Add this admin relationship
    public function admin()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
