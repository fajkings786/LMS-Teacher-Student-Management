<?php
// app/Http/Controllers/AudioUploadController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Message;
use App\Models\Chat;
use App\Models\Notification;

class AudioUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'audio' => 'required|mimes:mp3,wav,ogg|max:10240', // Max 10MB
            'chat_id' => 'required|exists:chats,id'
        ]);

        $chat = Chat::findOrFail($request->chat_id);

        // Check if user is participant
        if (!$chat->participants->contains(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $audioFile = $request->file('audio');
        $fileName = time() . '_' . $audioFile->getClientOriginalName();
        $filePath = $audioFile->storeAs('chat_files', $fileName, 'public');

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->user_id = auth()->id();
        $message->message = $request->message ?? '';
        $message->file_path = Storage::url($filePath);
        $message->file_name = $audioFile->getClientOriginalName();
        $message->file_size = $audioFile->getSize();
        $message->file_type = $audioFile->getMimeType();
        $message->save();

        // Create notifications for other participants
        foreach ($chat->participants as $participant) {
            if ($participant->id != auth()->id()) {
                Notification::create([
                    'user_id' => $participant->id,
                    'chat_id' => $chat->id,
                    'message_id' => $message->id,
                    'read' => false
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'file_url' => Storage::url($filePath)
        ]);
    }
}
