<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['title', 'is_group', 'user_id'];
    
    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
    
    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class)->latest();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function participants()
    {
        return $this->belongsToMany(User::class, 'chat_users', 'chat_id', 'user_id')
            ->withTimestamps();
    }
}