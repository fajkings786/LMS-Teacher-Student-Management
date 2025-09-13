<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'otp_code',
        'is_verified',
        'profile_picture',
        'phone',
        'bio'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class, 'user_id');
    }
    
    public function chatParticipations()
    {
        return $this->belongsToMany(Chat::class, 'chat_users', 'user_id', 'chat_id')
            ->withTimestamps();
    }
    
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'user_id');
    }
    
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    
    public function unreadNotifications()
    {
        return $this->notifications()->where('read', false);
    }
}