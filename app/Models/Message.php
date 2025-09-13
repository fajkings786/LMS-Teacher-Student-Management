<?php
// app/Models/Message.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'reply_to',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'status'
    ];

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
        return $this->belongsTo(Message::class, 'reply_to');
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
