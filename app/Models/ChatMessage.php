<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'reply_to',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'audio_path',
        'audio_duration',
        'status'
    ];

    protected $appends = ['is_audio', 'audio_url'];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reply()
    {
        return $this->belongsTo(ChatMessage::class, 'reply_to');
    }

    public function getIsAudioAttribute()
    {
        return !empty($this->audio_path);
    }

    public function getFilePathAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        }
        return $value;
    }

    public function getAudioUrlAttribute()
    {
        if ($this->audio_path) {
            return asset('storage/' . $this->audio_path);
        }
        return null;
    }

    public function getFileSizeAttribute($value)
    {
        if ($value) {
            $units = ['B', 'KB', 'MB', 'GB'];
            $bytes = $value;
            $precision = 2;
            if ($bytes > 0) {
                $power = floor(log($bytes, 1024));
                $power = min($power, count($units) - 1);
                $bytes /= pow(1024, $power);
                return round($bytes, $precision) . ' ' . $units[$power];
            }
        }
        return $value;
    }
}
