<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;

class Student extends Model
{
    use HasFactory;

    protected $table = 'users'; // Student data users table me hai

    protected $guarded = []; // Mass assignment allow

    // Scope to get only students
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    // Attendance relation
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }
}
