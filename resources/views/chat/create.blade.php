@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
        <!-- Beautiful Header -->
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
            <div class="relative p-8 text-center text-white">
                <h1 class="text-4xl font-bold mb-3">
                    <span class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 backdrop-blur-md mb-6">
                        <i class="fas fa-plus-circle text-4xl"></i>
                    </span>
                    Create New Chat
                </h1>
                <p class="text-indigo-100">Start a new conversation</p>
            </div>
        </div>
        
        <div class="p-8">
            <form action="{{ route('chat.store') }}" method="POST">
                @csrf
                <div class="mb-12">
                    <label class="block text-2xl font-bold text-gray-800 mb-6">Chat Type</label>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <input type="radio" name="type" id="personal" value="personal" class="peer hidden" checked>
                            <label for="personal" class="block p-8 bg-gray-50 rounded-3xl border-2 border-gray-200 cursor-pointer transition-all duration-500 hover:border-indigo-300 peer-checked:border-indigo-500 peer-checked:bg-gradient-to-br peer-checked:from-indigo-50 peer-checked:to-pink-50">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-100 to-pink-100 flex items-center justify-center mb-5">
                                        <i class="fas fa-user text-indigo-600 text-4xl"></i>
                                    </div>
                                    <span class="font-bold text-gray-800 text-xl">Personal</span>
                                    <span class="text-gray-500 mt-2">One-on-one chat</span>
                                </div>
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="type" id="group" value="group" class="peer hidden">
                            <label for="group" class="block p-8 bg-gray-50 rounded-3xl border-2 border-gray-200 cursor-pointer transition-all duration-500 hover:border-indigo-300 peer-checked:border-indigo-500 peer-checked:bg-gradient-to-br peer-checked:from-indigo-50 peer-checked:to-pink-50">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-100 to-pink-100 flex items-center justify-center mb-5">
                                        <i class="fas fa-users text-indigo-600 text-4xl"></i>
                                    </div>
                                    <span class="font-bold text-gray-800 text-xl">Group</span>
                                    <span class="text-gray-500 mt-2">Multiple participants</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div id="group-fields" class="hidden">
                    <div class="mb-8">
                        <label for="title" class="block text-xl font-bold text-gray-800 mb-4">Group Title</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                <i class="fas fa-heading text-gray-400 text-2xl"></i>
                            </div>
                            <input type="text" name="title" id="title" class="w-full pl-16 pr-6 py-5 bg-gray-50 rounded-2xl border border-gray-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 transition-all duration-500 shadow-sm focus:shadow-md" placeholder="Enter group name">
                        </div>
                    </div>
                    <div class="mb-8">
                        <label class="block text-xl font-bold text-gray-800 mb-4">Participants</label>
                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6 max-h-96 overflow-y-auto">
                            @foreach($users as $user)
                                <div class="flex items-center py-5 border-b border-gray-100 last:border-0">
                                    <input type="checkbox" name="participants[]" value="{{ $user->id }}" id="user-{{ $user->id }}" class="h-6 w-6 text-indigo-600 rounded focus:ring-indigo-500 focus:ring-2">
                                    <label for="user-{{ $user->id }}" class="ml-5 flex items-center cursor-pointer flex-1">
                                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random&size=56" class="w-14 h-14 rounded-full mr-5 border-2 border-white shadow-sm" alt="User Avatar">
                                        <div>
                                            <div class="font-bold text-gray-800 text-lg">{{ $user->name }}</div>
                                            <div class="text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-4 text-gray-500">Select participants for the group chat</p>
                    </div>
                </div>
                
                <div id="personal-fields">
                    <div class="mb-8">
                        <label class="block text-xl font-bold text-gray-800 mb-4">Select User</label>
                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6 max-h-96 overflow-y-auto">
                            @foreach($users as $user)
                                <div class="flex items-center py-5 border-b border-gray-100 last:border-0">
                                    <input type="radio" name="participants[]" value="{{ $user->id }}" id="user-{{ $user->id }}" class="h-6 w-6 text-indigo-600 rounded focus:ring-indigo-500 focus:ring-2">
                                    <label for="user-{{ $user->id }}" class="ml-5 flex items-center cursor-pointer flex-1">
                                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random&size=56" class="w-14 h-14 rounded-full mr-5 border-2 border-white shadow-sm" alt="User Avatar">
                                        <div>
                                            <div class="font-bold text-gray-800 text-lg">{{ $user->name }}</div>
                                            <div class="text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-5 mt-12">
                    <a href="{{ route('chat.index') }}" class="px-8 py-4 border border-gray-300 rounded-2xl text-gray-700 font-bold hover:bg-gray-50 transition-all duration-500 flex items-center">
                        <i class="fas fa-arrow-left mr-3"></i> Back
                    </a>
                    <button type="submit" class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-pink-600 hover:from-indigo-700 hover:to-pink-700 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 flex items-center">
                        <i class="fas fa-paper-plane mr-3"></i> Create Chat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle between personal and group chat
    document.getElementById('personal').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('group-fields').classList.add('hidden');
            document.getElementById('personal-fields').classList.remove('hidden');
        }
    });
    
    document.getElementById('group').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('group-fields').classList.remove('hidden');
            document.getElementById('personal-fields').classList.add('hidden');
        }
    });
</script>
@endsection