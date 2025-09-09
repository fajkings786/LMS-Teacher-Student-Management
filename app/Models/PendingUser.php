<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingUser extends Model
{
    protected $fillable = ['name','email','password','role','status','admin_note','approved_by','approved_at'];
    protected $hidden = ['password'];
}
