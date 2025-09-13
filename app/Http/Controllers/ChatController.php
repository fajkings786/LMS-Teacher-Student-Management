<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $chats = $user->chatParticipations()->with(['user', 'participants', 'lastMessage'])->get();
        $unreadNotifications = $user->unreadNotifications()->count();
        return view('chat.index', compact('chats', 'unreadNotifications'));
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('chat.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:personal,group',
            'title' => 'required_if:type,group',
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id',
        ]);

        $chat = Chat::create([
            'title' => $request->type === 'group' ? $request->title : null,
            'is_group' => $request->type === 'group',
            'user_id' => auth()->id(),
        ]);

        $participants = $request->participants;
        if (!in_array(auth()->id(), $participants)) {
            $participants[] = auth()->id();
        }

        $chat->participants()->attach($participants);

        return redirect()->route('chat.index');
    }

    public function show($id)
    {
        $chat = Chat::with(['messages.user', 'participants'])->findOrFail($id);
        if (!$chat->participants->contains(auth()->id())) {
            abort(403, 'Unauthorized');
        }

        Notification::where('user_id', auth()->id())
            ->where('chat_id', $id)
            ->update(['read' => true]);

        return view('chat.show', compact('chat'));
    }

    public function sendMessage(Request $request, $chatId)
    {
        try {
            $chat = Chat::findOrFail($chatId);

            // Check if user is participant
            if (!$chat->participants->contains(auth()->id())) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $message = new ChatMessage();
            $message->chat_id = $chat->id;
            $message->user_id = auth()->id();
            $message->message = $request->message;
            $message->reply_to = $request->reply_to; // This will handle the reply

            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('chat_files', $fileName, 'public');

                $message->file_path = $filePath;
                $message->file_name = $file->getClientOriginalName();
                $message->file_size = $file->getSize();
                $message->file_type = $file->getMimeType();
            }

            // Handle audio upload
            if ($request->hasFile('audio')) {
                $audioFile = $request->file('audio');
                $fileName = time() . '_' . $audioFile->getClientOriginalName();
                $filePath = $audioFile->storeAs('chat_files', $fileName, 'public');

                $message->audio_path = $filePath;
                $message->audio_duration = $request->audio_duration ?? 0;
            }

            $message->save();

            // Broadcast the message
            broadcast(new MessageSent($message))->toOthers();

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

            // Load relationships
            $message->load('user', 'reply.user'); // Load the reply relationship

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            \Log::error('Message sending error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the message.'
            ], 500);
        }
    }

    public function fetchMessages($chatId)
    {
        $chat = Chat::findOrFail($chatId);

        // Check if user is participant
        if (!$chat->participants->contains(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Mark notifications as read
        Notification::where('chat_id', $chatId)
            ->where('user_id', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);

        $messages = $chat->messages()
            ->with('user', 'reply.user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function getNotifications()
    {
        $user = auth()->user();
        $notifications = $user->notifications()
            ->with(['message.user', 'chat'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($notifications);
    }

    public function markNotificationAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        if ($notification->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $notification->update(['read' => true]);
        return response()->json(['success' => true]);
    }
}
