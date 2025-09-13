@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
        <!-- Stunning Header -->
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
            <div class="relative p-8 text-white">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="bg-white/20 backdrop-blur-md rounded-2xl p-4 mr-6">
                            <i class="fas fa-comments text-3xl"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold mb-1">My Chats</h1>
                            <p class="text-indigo-100">Your conversations</p>
                        </div>
                    </div>
                    <a href="{{ route('chat.create') }}" class="group relative overflow-hidden bg-white text-indigo-600 hover:bg-indigo-50 px-7 py-4 rounded-full font-bold flex items-center transition-all duration-500 shadow-2xl hover:shadow-3xl transform hover:-translate-y-1">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-plus mr-3 group-hover:rotate-90 transition-transform duration-500"></i> 
                            New Chat
                        </span>
                        <span class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 opacity-0 group-hover:opacity-30 transition-opacity duration-500"></span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Chat List -->
        <div class="p-2">
            @if($chats->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach ($chats as $chat)
                        <a href="{{ route('chat.show', $chat->id) }}" class="block group">
                            <div class="p-6 flex items-center transition-all duration-500 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:rounded-2xl">
                                <div class="relative flex-shrink-0 mr-6">
                                    @if($chat->is_group)
                                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500 to-pink-500 flex items-center justify-center shadow-xl group-hover:shadow-2xl transition-all duration-500">
                                            <i class="fas fa-users text-white text-3xl"></i>
                                        </div>
                                    @else
                                        <div class="relative">
                                            <img src="https://ui-avatars.com/api/?name={{ $chat->participants->where('id', '!=', auth()->id())->first()->name ?? 'Unknown' }}&background=random&size=80" class="w-20 h-20 rounded-full border-3 border-white shadow-xl group-hover:shadow-2xl transition-all duration-500" alt="User Avatar">
                                            <div class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 rounded-full border-2 border-white shadow-md"></div>
                                        </div>
                                    @endif
                                    
                                    <!-- Unread notification badge -->
                                    @if($chat->messages->count() > 0 && $chat->messages->last()->user_id != auth()->id())
                                        @php
                                            $unreadCount = \App\Models\Notification::where('chat_id', $chat->id)
                                                ->where('user_id', auth()->id())
                                                ->where('read', false)
                                                ->count();
                                        @endphp
                                        @if($unreadCount > 0)
                                            <span class="absolute -top-2 -right-2 bg-gradient-to-r from-red-500 to-orange-500 text-white text-sm rounded-full h-8 w-8 flex items-center justify-center font-bold border-2 border-white shadow-xl animate-pulse">
                                                {{ $unreadCount }}
                                            </span>
                                        @endif
                                    @endif
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-baseline">
                                        <h3 class="text-2xl font-bold text-gray-900 truncate group-hover:text-indigo-600 transition-colors duration-500">
                                            @if($chat->is_group)
                                                {{ $chat->title }}
                                                <span class="text-sm bg-gradient-to-r from-indigo-500 to-pink-500 text-white rounded-full px-4 py-1 ml-3 shadow-md">
                                                    <i class="fas fa-users mr-1"></i>Group
                                                </span>
                                            @else
                                                {{ $chat->participants->where('id', '!=', auth()->id())->first()->name ?? 'Unknown' }}
                                            @endif
                                        </h3>
                                        <span class="text-sm text-gray-500 whitespace-nowrap ml-2">{{ $chat->updated_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mt-3">
                                        <p class="text-gray-600 truncate group-hover:text-gray-800 transition-colors duration-500">
                                            @if($chat->messages->count() > 0)
                                                @php
                                                    $lastMessage = $chat->messages->last();
                                                @endphp
                                                <span class="font-bold text-gray-800">{{ $lastMessage->user->name }}:</span> 
                                                @if($lastMessage->audio_path)
                                                    <i class="fas fa-microphone text-indigo-500"></i> Audio 
                                                    <span class="text-xs">({{ gmdate('i:s', $lastMessage->audio_duration) }})</span>
                                                @else
                                                    {{ $lastMessage->message }}
                                                @endif
                                            @else
                                                <span class="text-gray-400 italic">No messages yet</span>
                                            @endif
                                        </p>
                                        
                                        <!-- Unread count badge -->
                                        @if($chat->messages->count() > 0 && $chat->messages->last()->user_id != auth()->id())
                                            @php
                                                $unreadCount = \App\Models\Notification::where('chat_id', $chat->id)
                                                    ->where('user_id', auth()->id())
                                                    ->where('read', false)
                                                    ->count();
                                            @endphp
                                            @if($unreadCount > 0)
                                                <span class="bg-gradient-to-r from-indigo-500 to-pink-500 text-white text-xs rounded-full h-7 w-7 flex items-center justify-center font-bold shadow-md">
                                                    {{ $unreadCount }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="py-24 text-center">
                    <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-gradient-to-br from-indigo-50 to-purple-50 mb-8 shadow-inner">
                        <i class="fas fa-comments text-6xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-pink-500"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">No chats yet</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-10">Start a conversation by creating a new chat with someone</p>
                    <a href="{{ route('chat.create') }}" class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-pink-600 hover:from-indigo-700 hover:to-pink-700 text-white font-bold py-4 px-10 rounded-full transition-all duration-500 shadow-2xl hover:shadow-3xl transform hover:-translate-y-1">
                        <i class="fas fa-plus mr-3"></i> Create Chat
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection