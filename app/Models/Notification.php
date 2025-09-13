<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'chat_id',
        'message_id',
        'read'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
    
    public function message()
    {
        return $this->belongsTo(ChatMessage::class);
    }
}