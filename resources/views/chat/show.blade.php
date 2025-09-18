@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto h-screen flex flex-col">
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden flex flex-col h-full transition-colors duration-300">
            <!-- Enhanced Chat Header -->
            <div class="relative overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-800 dark:via-purple-800 dark:to-pink-800">
                </div>
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20">
                </div>
                <div class="relative p-6 text-white">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <a href="{{ route('chat.index') }}"
                                class="mr-4 text-white hover:text-indigo-200 transition-all transform hover:scale-110">
                                <i class="fas fa-arrow-left text-xl"></i>
                            </a>
                            <div class="flex items-center">
                                @if ($chat->is_group)
                                    <div
                                        class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-pink-500 flex items-center justify-center mr-4 shadow-lg border-2 border-white/30">
                                        <i class="fas fa-users text-white text-2xl"></i>
                                    </div>
                                @else
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name={{ $chat->participants->where('id', '!=', auth()->id())->first()->name ?? 'Unknown' }}&background=random&size=56"
                                            class="w-14 h-14 rounded-full mr-4 border-2 border-white/50 shadow-md"
                                            alt="User Avatar">
                                        <div
                                            class="absolute bottom-0 right-3 w-4 h-4 bg-green-400 rounded-full border-2 border-white shadow-md animate-pulse">
                                        </div>
                                    </div>
                                @endif
                                <div>
                                    <h1 class="text-2xl font-bold">
                                        @if ($chat->is_group)
                                            {{ $chat->title }}
                                            <span
                                                class="text-sm bg-white/20 backdrop-blur-md rounded-full px-3 py-1 ml-2 shadow-inner">
                                                <i class="fas fa-users mr-1"></i>{{ $chat->participants->count() }}
                                            </span>
                                        @else
                                            {{ $chat->participants->where('id', '!=', auth()->id())->first()->name ?? 'Unknown' }}
                                        @endif
                                    </h1>
                                    <p class="text-indigo-100 flex items-center">
                                        @if ($chat->is_group)
                                            <i class="fas fa-users mr-1"></i> Group chat •
                                            {{ $chat->participants->count() }} members
                                        @else
                                            <i class="fas fa-circle text-green-400 text-xs mr-1 animate-pulse"></i> Online
                                            now
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <!-- Search Button -->
                            <button onclick="toggleSearch()"
                                class="p-3 rounded-full bg-white/20 hover:bg-white/30 transition-all transform hover:scale-110 shadow-md">
                                <i class="fas fa-search"></i>
                            </button>
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-3 rounded-full bg-white/20 hover:bg-white/30 transition-all transform hover:scale-110 shadow-md">
                                <i class="fas fa-moon dark:hidden"></i>
                                <i class="fas fa-sun hidden dark:inline"></i>
                            </button>
                            <!-- Call Buttons -->
                            <button onclick="startCall('voice')"
                                class="p-3 rounded-full bg-white/20 hover:bg-white/30 transition-all transform hover:scale-110 shadow-md">
                                <i class="fas fa-phone"></i>
                            </button>
                            <button onclick="startCall('video')"
                                class="p-3 rounded-full bg-white/20 hover:bg-white/30 transition-all transform hover:scale-110 shadow-md">
                                <i class="fas fa-video"></i>
                            </button>
                            <!-- More Options -->
                            <button onclick="toggleChatOptions()"
                                class="p-3 rounded-full bg-white/20 hover:bg-white/30 transition-all transform hover:scale-110 shadow-md">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div id="search-bar"
                class="hidden p-4 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 transition-all duration-300">
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Search messages..."
                        class="w-full px-4 py-2 pl-10 bg-white dark:bg-gray-600 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-inner">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <button onclick="toggleSearch()" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Enhanced Chat Messages -->
            <div class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800"
                id="chat-messages">
                <div class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-14 w-14 border-t-3 border-b-3 border-indigo-600">
                    </div>
                    <p class="mt-4 text-gray-600 dark:text-gray-300 font-medium">Loading messages...</p>
                </div>
            </div>

            <!-- Enhanced Typing Indicator -->
            <div id="typing-indicator"
                class="hidden px-6 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 transition-all duration-300">
                <div class="flex items-center">
                    <div
                        class="bg-white dark:bg-gray-600 rounded-2xl shadow-lg px-4 py-3 inline-flex items-center border border-gray-100 dark:border-gray-500">
                        <div class="flex space-x-1 mr-2">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms">
                            </div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms">
                            </div>
                        </div>
                        <span class="text-gray-600 dark:text-gray-300 text-sm font-medium"><span
                                id="typing-user-name">Someone</span> is typing...</span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Scroll to Bottom Button -->
            <button id="scroll-to-bottom"
                class="hidden fixed bottom-24 right-8 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full p-3 shadow-lg hover:shadow-xl transition-all z-10 transform hover:scale-110 animate-bounce">
                <i class="fas fa-arrow-down"></i>
            </button>

            <!-- New Messages Notification -->
            <div id="new-messages-notification"
                class="hidden fixed bottom-24 left-1/2 transform -translate-x-1/2 bg-indigo-600 text-white px-4 py-2 rounded-full shadow-lg cursor-pointer hover:bg-indigo-700 transition-all z-10 animate-pulse">
                <span id="new-messages-count">0</span> new messages
            </div>

            <!-- Enhanced Message Input -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800">
                <!-- Enhanced Reply Preview -->
                <div id="reply-preview" class="reply-preview hidden mb-4">
                    <div
                        class="flex items-start bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-xl p-4 border border-indigo-100 dark:border-indigo-800 shadow-sm transition-all duration-300">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-reply text-indigo-500 dark:text-indigo-400 mr-2"></i>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Replying to <span
                                        id="reply-sender-name" class="text-indigo-600 dark:text-indigo-400"></span></span>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 border-l-4 border-indigo-500 shadow-sm">
                                <p id="reply-message-text" class="text-sm text-gray-600 dark:text-gray-300"></p>
                            </div>
                        </div>
                        <button id="cancel-reply"
                            class="ml-3 text-gray-400 hover:text-red-500 transition-colors transform hover:scale-110">
                            <i class="fas fa-times-circle text-xl"></i>
                        </button>
                    </div>
                </div>

                <form id="message-form" class="flex items-end space-x-3">
                    <input type="hidden" id="chat-id" value="{{ $chat->id }}">
                    <input type="hidden" id="reply-to-id" value="">
                    <div class="flex-1 relative">
                        <div class="flex items-center space-x-2 mb-2">
                            <!-- Enhanced Emoji Button -->
                            <button type="button" onclick="toggleEmojiPicker()"
                                class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all transform hover:scale-110 p-2 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700">
                                <i class="far fa-smile text-lg"></i>
                            </button>
                            <!-- Enhanced File Upload Button -->
                            <label for="file-upload"
                                class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all transform hover:scale-110 cursor-pointer p-2 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700">
                                <i class="fas fa-paperclip text-lg"></i>
                            </label>
                            <input type="file" id="file-upload" class="hidden"
                                accept="image/*,application/pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            <!-- Enhanced GIF Button -->
                            <button type="button" onclick="toggleGifPicker()"
                                class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all transform hover:scale-110 p-2 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700">
                                <i class="fas fa-film text-lg"></i>
                            </button>
                            <!-- Enhanced Audio Upload Button -->
                            <label for="audio-upload"
                                class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all transform hover:scale-110 cursor-pointer p-2 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700">
                                <i class="fas fa-file-audio text-lg"></i>
                            </label>
                            <input type="file" id="audio-upload" class="hidden" accept="audio/*">
                            <!-- Enhanced Location Button -->
                            <button type="button" onclick="shareLocation()"
                                class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all transform hover:scale-110 p-2 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                            </button>
                        </div>
                        <input type="text" id="message-input" data-chat-id="{{ $chat->id }}"
                            class="w-full px-5 py-3 bg-gray-100 dark:bg-gray-700 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-gray-600 transition-all resize-none shadow-inner"
                            placeholder="Type a message..." rows="1">
                        <div class="absolute right-3 bottom-3">
                            <!-- Enhanced Audio Record Button -->
                            <button type="button" id="audio-record-btn"
                                class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all transform hover:scale-110 p-2 rounded-full hover:bg-indigo-50 dark:hover:bg-gray-700">
                                <i class="fas fa-microphone text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white flex items-center justify-center hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-110">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>

                <!-- Emoji Picker -->
                <div id="emoji-picker"
                    class="hidden absolute bottom-20 left-6 bg-white dark:bg-gray-700 rounded-xl shadow-xl p-4 z-20 w-80 h-80 overflow-y-auto transition-all duration-300">
                    <div class="grid grid-cols-8 gap-2">
                        <!-- Emojis will be populated by JavaScript -->
                    </div>
                </div>

                <!-- GIF Picker -->
                <div id="gif-picker"
                    class="hidden absolute bottom-20 left-6 bg-white dark:bg-gray-700 rounded-xl shadow-xl p-4 z-20 w-80 h-80 overflow-y-auto transition-all duration-300">
                    <div class="mb-3">
                        <input type="text" id="gif-search" placeholder="Search GIFs..."
                            class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div id="gif-container" class="grid grid-cols-2 gap-2">
                        <!-- GIFs will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Enhanced Audio Recording UI -->
                <div id="audio-recording-ui"
                    class="hidden mt-4 p-4 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 rounded-xl border border-red-200 dark:border-red-800 shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full animate-pulse mr-3 shadow-md"></div>
                            <div>
                                <span class="text-red-600 dark:text-red-400 font-medium">Recording...</span>
                                <span id="recording-timer"
                                    class="ml-2 text-red-600 dark:text-red-400 font-mono text-sm">00:00</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button id="cancel-recording"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-all transform hover:scale-105 shadow-sm">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </button>
                            <button id="save-recording"
                                class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg hover:from-red-600 hover:to-pink-600 transition-all transform hover:scale-105 shadow-md">
                                <i class="fas fa-check mr-1"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Options Modal -->
    <div id="chat-options-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-96 max-w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="chat-options-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Chat Options</h3>
                    <button onclick="toggleChatOptions()"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="space-y-3">
                    <button onclick="viewContactInfo()"
                        class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-all duration-200">
                        <i class="fas fa-user-circle text-indigo-500 mr-3 text-lg"></i>
                        <span class="text-gray-700 dark:text-gray-300">View Contact</span>
                    </button>
                    <button onclick="clearChat()"
                        class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-all duration-200">
                        <i class="fas fa-trash-alt text-red-500 mr-3 text-lg"></i>
                        <span class="text-gray-700 dark:text-gray-300">Clear Chat</span>
                    </button>
                    <button onclick="toggleNotifications()"
                        class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-all duration-200">
                        <i class="fas fa-bell text-yellow-500 mr-3 text-lg"></i>
                        <span class="text-gray-700 dark:text-gray-300">Mute Notifications</span>
                    </button>
                    <button onclick="exportChat()"
                        class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-all duration-200">
                        <i class="fas fa-download text-green-500 mr-3 text-lg"></i>
                        <span class="text-gray-700 dark:text-gray-300">Export Chat</span>
                    </button>
                    @if ($chat->is_group)
                        <button onclick="manageGroup()"
                            class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-all duration-200">
                            <i class="fas fa-users-cog text-purple-500 mr-3 text-lg"></i>
                            <span class="text-gray-700 dark:text-gray-300">Manage Group</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Call Modal -->
    <div id="call-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 transition-opacity duration-300">
        <div class="text-center transform transition-all duration-300 scale-95 opacity-0" id="call-content">
            <div class="mb-8">
                <img src="https://ui-avatars.com/api/?name={{ $chat->participants->where('id', '!=', auth()->id())->first()->name ?? 'Unknown' }}&background=random&size=120"
                    class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg" alt="User Avatar">
                <h3 class="text-2xl font-bold text-white mt-4">
                    {{ $chat->participants->where('id', '!=', auth()->id())->first()->name ?? 'Unknown' }}</h3>
                <p id="call-status" class="text-indigo-300 mt-2">Connecting...</p>
            </div>
            <div class="flex justify-center space-x-6">
                <button onclick="endCall()"
                    class="w-16 h-16 rounded-full bg-red-500 hover:bg-red-600 flex items-center justify-center text-white shadow-lg transform hover:scale-110 transition-all">
                    <i class="fas fa-phone-slash text-2xl"></i>
                </button>
                <button id="mute-call-btn" onclick="toggleMute()"
                    class="w-16 h-16 rounded-full bg-gray-600 hover:bg-gray-700 flex items-center justify-center text-white shadow-lg transform hover:scale-110 transition-all">
                    <i class="fas fa-microphone text-2xl"></i>
                </button>
                <button id="video-call-btn" onclick="toggleVideo()"
                    class="w-16 h-16 rounded-full bg-gray-600 hover:bg-gray-700 flex items-center justify-center text-white shadow-lg transform hover:scale-110 transition-all">
                    <i class="fas fa-video text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Contact Info Modal -->
    <div id="contact-info-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-96 max-w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="contact-info-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Contact Information</h3>
                    <button onclick="toggleContactInfo()"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="text-center mb-6">
                    <img src="https://ui-avatars.com/api/?name={{ $chat->participants->where('id', '!=', auth()->id())->first()->name ?? 'Unknown' }}&background=random&size=120"
                        class="w-24 h-24 rounded-full mx-auto border-4 border-white shadow-lg" alt="User Avatar">
                    <h4 class="text-xl font-bold text-gray-800 dark:text-white mt-3">
                        {{ $chat->participants->where('id', '!=', auth()->id())->first()->name ?? 'Unknown' }}</h4>
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ $chat->participants->where('id', '!=', auth()->id())->first()->email ?? 'No email' }}</p>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Status</span>
                        <span class="text-green-500 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Online
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Phone</span>
                        <span
                            class="text-gray-800 dark:text-gray-200">{{ $chat->participants->where('id', '!=', auth()->id())->first()->phone ?? 'Not provided' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Last seen</span>
                        <span class="text-gray-800 dark:text-gray-200">Just now</span>
                    </div>
                </div>
                <div class="mt-6 flex space-x-3">
                    <button onclick="startCall('voice')"
                        class="flex-1 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition-all transform hover:scale-105">
                        <i class="fas fa-phone mr-2"></i> Voice Call
                    </button>
                    <button onclick="startCall('video')"
                        class="flex-1 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-all transform hover:scale-105">
                        <i class="fas fa-video mr-2"></i> Video Call
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced Message bubble styles */
        .message {
            margin-bottom: 24px;
            display: flex;
            flex-direction: column;
            position: relative;
            animation: fadeInUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition: all 0.3s ease;
        }

        .message.sent {
            align-items: flex-end;
        }

        .message.received {
            align-items: flex-start;
        }

        .message-wrapper {
            max-width: 70%;
            position: relative;
        }

        .message-bubble {
            padding: 16px 20px;
            border-radius: 20px;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            word-wrap: break-word;
            cursor: pointer;
        }

        .message.sent .message-bubble {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border-bottom-right-radius: 8px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .message.received .message-bubble {
            background-color: white;
            color: #333;
            border-bottom-left-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .dark .message.received .message-bubble {
            background-color: #374151;
            color: #f3f4f6;
        }

        .message.sent .message-bubble:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }

        .message.received .message-bubble:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        /* Enhanced Message actions */
        .message-actions {
            display: none;
            position: absolute;
            top: -45px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            z-index: 20;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .dark .message-actions {
            background: #374151;
            border: 1px solid #4b5563;
        }

        .message.sent .message-actions {
            right: 0;
        }

        .message.received .message-actions {
            left: 0;
        }

        .message:hover .message-actions {
            display: flex;
            animation: fadeInUp 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .action-btn {
            padding: 12px 16px;
            border: none;
            background: none;
            color: #666;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
        }

        .dark .action-btn {
            color: #d1d5db;
        }

        .action-btn:hover {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
            color: #6366f1;
            transform: translateX(3px);
        }

        .dark .action-btn:hover {
            background: rgba(99, 102, 241, 0.2);
            color: #818cf8;
        }

        .action-btn i {
            margin-right: 10px;
            width: 18px;
            text-align: center;
        }

        .action-btn:first-child {
            border-radius: 16px 16px 0 0;
        }

        .action-btn:last-child {
            border-radius: 0 0 16px 16px;
        }

        .action-btn.reply-btn {
            color: #6366f1;
        }

        .dark .action-btn.reply-btn {
            color: #818cf8;
        }

        .action-btn.react-btn {
            color: #f59e0b;
        }

        .dark .action-btn.react-btn {
            color: #fbbf24;
        }

        .action-btn.forward-btn {
            color: #10b981;
        }

        .dark .action-btn.forward-btn {
            color: #34d399;
        }

        .action-btn.star-btn {
            color: #f59e0b;
        }

        .dark .action-btn.star-btn {
            color: #fbbf24;
        }

        .action-btn.delete-btn {
            color: #ef4444;
        }

        .dark .action-btn.delete-btn {
            color: #f87171;
        }

        /* Enhanced Reply styles */
        .reply-indicator {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border-radius: 14px;
            padding: 12px 16px;
            margin-bottom: 10px;
            font-size: 13px;
            color: #6366f1;
            display: flex;
            align-items: center;
            border-left: 3px solid #6366f1;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
        }

        .message.sent .reply-indicator {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.3) 100%);
            color: rgba(255, 255, 255, 0.9);
            border-left: 3px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .reply-indicator i {
            margin-right: 8px;
            font-size: 14px;
        }

        /* Enhanced File attachment styles */
        .file-attachment {
            background-color: rgba(255, 255, 255, 0.25);
            border-radius: 14px;
            padding: 14px;
            display: flex;
            align-items: center;
            margin-top: 12px;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .message.received .file-attachment {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .dark .message.received .file-attachment {
            background-color: #4b5563;
            border: 1px solid #374151;
        }

        .file-attachment:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .file-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 14px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .message.received .file-icon {
            background-color: #e9ecef;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .dark .message.received .file-icon {
            background-color: #374151;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-weight: 600;
            margin-bottom: 3px;
            font-size: 15px;
        }

        .file-meta {
            font-size: 12px;
            opacity: 0.7;
        }

        .file-download {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .file-download:hover {
            background-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .message.received .file-download {
            background-color: #e9ecef;
        }

        .dark .message.received .file-download {
            background-color: #374151;
        }

        .message.received .file-download:hover {
            background-color: #dee2e6;
        }

        .dark .message.received .file-download:hover {
            background-color: #4b5563;
        }

        /* Enhanced Audio player styles */
        .audio-player {
            margin-top: 12px;
            width: 100%;
        }

        .audio-player audio {
            width: 100%;
            border-radius: 10px;
            height: 42px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .audio-info {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            font-size: 12px;
            opacity: 0.8;
        }

        .audio-wave {
            display: flex;
            align-items: center;
            height: 32px;
            margin-top: 6px;
        }

        .audio-bar {
            width: 3px;
            height: 15px;
            margin: 0 1.5px;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 2px;
            animation: audioWave 1.2s ease-in-out infinite;
        }

        .message.received .audio-bar {
            background-color: #6366f1;
        }

        .dark .message.received .audio-bar {
            background-color: #818cf8;
        }

        .audio-bar:nth-child(2) {
            animation-delay: 0.1s;
        }

        .audio-bar:nth-child(3) {
            animation-delay: 0.2s;
        }

        .audio-bar:nth-child(4) {
            animation-delay: 0.3s;
        }

        .audio-bar:nth-child(5) {
            animation-delay: 0.4s;
        }

        /* Enhanced Typing indicator styles */
        .typing-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #888;
            margin: 0 2px;
            display: inline-block;
            animation: typing 1.4s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        /* Enhanced Scroll to bottom button */
        #scroll-to-bottom {
            position: fixed;
            bottom: 100px;
            right: 20px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        #scroll-to-bottom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.5);
        }

        /* Enhanced Date separator */
        .date-separator {
            text-align: center;
            margin: 24px 0;
            position: relative;
        }

        .date-separator:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #ddd, transparent);
        }

        .dark .date-separator:before {
            background: linear-gradient(90deg, transparent, #4b5563, transparent);
        }

        .date-separator span {
            background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
            padding: 8px 18px;
            position: relative;
            color: #666;
            font-size: 14px;
            font-weight: 600;
            border-radius: 24px;
            border: 1px solid #e0e7ff;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
        }

        .dark .date-separator span {
            background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
            color: #d1d5db;
            border: 1px solid #4b5563;
        }

        /* Enhanced Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes typing {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-10px);
            }
        }

        @keyframes audioWave {

            0%,
            100% {
                height: 15px;
            }

            50% {
                height: 25px;
            }
        }

        /* Enhanced Message status */
        .message-status {
            display: inline-block;
            margin-left: 4px;
            font-size: 12px;
        }

        /* Enhanced Online status indicator */
        .online-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #10b981;
            border: 2px solid white;
            position: absolute;
            bottom: 0;
            right: 0;
            animation: pulse 2s infinite;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
        }

        .dark .online-indicator {
            border-color: #1f2937;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* Enhanced Responsive adjustments */
        @media (max-width: 768px) {
            .message-wrapper {
                max-width: 85%;
            }

            .message-bubble {
                font-size: 14px;
                padding: 14px 16px;
            }

            .file-attachment {
                flex-direction: column;
                align-items: flex-start;
            }

            .file-icon {
                margin-bottom: 10px;
            }
        }
    </style>

    <script>
        // Set current user ID for JavaScript
        const currentUserId = {{ auth()->id() }};
        const chatId = {{ $chat->id }};

        // Audio recording variables
        let mediaRecorder;
        let audioChunks = [];
        let recordingStartTime;
        let recordingTimer;
        let recordingDuration = 0;

        // DOM elements
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const audioRecordBtn = document.getElementById('audio-record-btn');
        const audioUploadInput = document.getElementById('audio-upload');
        const fileUploadInput = document.getElementById('file-upload');
        const audioRecordingUI = document.getElementById('audio-recording-ui');
        const recordingTimerDisplay = document.getElementById('recording-timer');
        const cancelRecordingBtn = document.getElementById('cancel-recording');
        const saveRecordingBtn = document.getElementById('save-recording');
        const chatMessages = document.getElementById('chat-messages');
        const scrollToBottomBtn = document.getElementById('scroll-to-bottom');
        const typingIndicator = document.getElementById('typing-indicator');
        const typingUserName = document.getElementById('typing-user-name');
        const searchBar = document.getElementById('search-bar');
        const searchInput = document.getElementById('search-input');
        const emojiPicker = document.getElementById('emoji-picker');
        const gifPicker = document.getElementById('gif-picker');
        const gifContainer = document.getElementById('gif-container');
        const gifSearchInput = document.getElementById('gif-search');
        const chatOptionsModal = document.getElementById('chat-options-modal');
        const callModal = document.getElementById('call-modal');
        const contactInfoModal = document.getElementById('contact-info-modal');
        const callStatus = document.getElementById('call-status');
        const newMessagesNotification = document.getElementById('new-messages-notification');
        const newMessagesCount = document.getElementById('new-messages-count');
        const chatOptionsContent = document.getElementById('chat-options-content');
        const callContent = document.getElementById('call-content');
        const contactInfoContent = document.getElementById('contact-info-content');

        // Reply elements
        const replyPreview = document.getElementById('reply-preview');
        const replySenderId = document.getElementById('reply-sender-name');
        const replyMessageText = document.getElementById('reply-message-text');
        const replyToId = document.getElementById('reply-to-id');
        const cancelReplyBtn = document.getElementById('cancel-reply');

        // Drag detection variables
        let isDragging = false;
        let dragStartY = 0;
        let dragEndY = 0;
        let dragThreshold = 5; // Minimum distance to consider as drag

        // Emoji list
        const emojis = ['😀', '😃', '😄', '😁', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘',
            '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '🥳', '😏', '😒', '😞', '😔',
            '😟', '😕', '🙁', '☹️', '😣', '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠', '😡', '🤬', '🤯', '😳', '🥵',
            '🥶', '😱', '😨', '😰', '😥', '😓', '🤗', '🤔', '🤭', '🤫', '🤥', '😶', '😐', '😑', '😬', '🙄', '😯', '😦',
            '😧', '😮', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐', '🥴', '🤢', '🤮', '🤧', '😷', '🤒', '🤕', '🤑', '🤠',
            '😈', '👿', '👹', '👺', '🤡', '💩', '👻', '💀', '☠️', '👽', '👾', '🤖', '🎃', '😺', '😸', '😹', '😻', '😼',
            '😽', '🙀', '😿', '😾', '👋', '🤚', '🖐', '✋', '🖖', '👌', '🤌', '🤏', '✌️', '🤞', '🤟', '🤘', '🤙', '👈',
            '👉', '👆', '🖕', '👇', '☝️', '👍', '👎', '✊', '👊', '🤛', '🤜', '👏', '🙌', '👐', '🤲', '🤝', '🙏', '✍️',
            '💅', '🤳', '💪', '🦾', '🦿', '🦵', '🦶', '👂', '🦻', '👃', '🧠', '🫀', '🫁', '🦷', '🦴', '👀', '👁️', '👅',
            '👄', '👶', '🧒', '👦', '👧', '🧑', '👱', '👨', '🧔', '👨‍🦰', '👨‍🦱', '👨‍🦳', '👨‍🦲', '👩', '👩‍🦰',
            '👩‍🦱', '👩‍🦳', '👩‍🦲', '🧓', '👴', '👵', '🙍', '🙍‍♂️', '🙍‍♀️', '🙎', '🙎‍♂️', '🙎‍♀️', '🙅', '🙅‍♂️',
            '🙅‍♀️', '🙆', '🙆‍♂️', '🙆‍♀️', '💁', '💁‍♂️', '💁‍♀️', '🙋', '🙋‍♂️', '🙋‍♀️', '🧏', '🧏‍♂️', '🧏‍♀️',
            '🙇', '🙇‍♂️', '🙇‍♀️', '🤦', '🤦‍♂️', '🤦‍♀️', '🤷', '🤷‍♂️', '🤷‍♀️', '🧑‍⚕️', '👨‍⚕️', '👩‍⚕️', '🧑‍🎓',
            '👨‍🎓', '👩‍🎓', '🧑‍🏫', '👨‍🏫', '👩‍🏫', '🧑‍⚖️', '👨‍⚖️', '👩‍⚖️', '🧑‍🌾', '👨‍🌾', '👩‍🌾', '🧑‍🍳',
            '👨‍🍳', '👩‍🍳', '🧑‍🔧', '👨‍🔧', '👩‍🔧', '🧑‍🏭', '👨‍🏭', '👩‍🏭', '🧑‍💼', '👨‍💼', '👩‍💼', '🧑‍🔬',
            '👨‍🔬', '👩‍🔬', '🧑‍💻', '👨‍💻', '👩‍💻', '🧑‍🎤', '👨‍🎤', '👩‍🎤', '🧑‍🎨', '👨‍🎨', '👩‍🎨', '🧑‍✈️',
            '👨‍✈️', '👩‍✈️', '🧑‍🚀', '👨‍🚀', '👩‍🚀', '🧑‍🚒', '👨‍🚒', '👩‍🚒', '👮', '👮‍♂️', '👮‍♀️', '🕵️',
            '🕵️‍♂️', '🕵️‍♀️', '💂', '💂‍♂️', '💂‍♀️', '🥷', '👷', '👷‍♂️', '👷‍♀️', '🤴', '👸', '👳', '👳‍♂️',
            '👳‍♀️', '👲', '🧕', '🤵', '🤵‍♂️', '🤵‍♀️', '👰', '👰‍♂️', '👰‍♀️', '🤰', '🤱', '👩‍🍼', '👨‍🍼', '🧑‍🍼',
            '👼', '🎅', '🤶', '🧑‍🎄', '🦸', '🦸‍♂️', '🦸‍♀️', '🦹', '🦹‍♂️', '🦹‍♀️', '🧙', '🧙‍♂️', '🧙‍♀️', '🧚',
            '🧚‍♂️', '🧚‍♀️', '🧛', '🧛‍♂️', '🧛‍♀️', '🧜', '🧜‍♂️', '🧜‍♀️', '🧝', '🧝‍♂️', '🧝‍♀️', '🧞', '🧞‍♂️',
            '🧞‍♀️', '🧟', '🧟‍♂️', '🧟‍♀️', '💆', '💆‍♂️', '💆‍♀️', '💇', '💇‍♂️', '💇‍♀️', '🚶', '🚶‍♂️', '🚶‍♀️',
            '🧍', '🧍‍♂️', '🧍‍♀️', '🧎', '🧎‍♂️', '🧎‍♀️', '🏃', '🏃‍♂️', '🏃‍♀️', '💃', '🕺', '🕴', '👯', '👯‍♂️',
            '👯‍♀️', '🧖', '🧖‍♂️', '🧖‍♀️', '🧗', '🧗‍♂️', '🧗‍♀️', '🤺', '🏇', '⛷', '🏂', '🏌️', '🏌️‍♂️', '🏌️‍♀️',
            '🏄', '🏄‍♂️', '🏄‍♀️', '🚣', '🚣‍♂️', '🚣‍♀️', '🏊', '🏊‍♂️', '🏊‍♀️', '⛹️', '⛹️‍♂️', '⛹️‍♀️', '🏋️',
            '🏋️‍♂️', '🏋️‍♀️', '🚴', '🚴‍♂️', '🚴‍♀️', '🚵', '🚵‍♂️', '🚵‍♀️', '🤸', '🤸‍♂️', '🤸‍♀️', '🤼', '🤼‍♂️',
            '🤼‍♀️', '🤽', '🤽‍♂️', '🤽‍♀️', '🤾', '🤾‍♂️', '🤾‍♀️', '🤹', '🤹‍♂️', '🤹‍♀️', '🧘', '🧘‍♂️', '🧘‍♀️',
            '🛀', '🛌', '🧑‍🤝‍🧑', '👭', '👫', '👬', '💏', '👩‍❤️‍💋‍👨', '👨‍❤️‍💋‍👨', '👩‍❤️‍💋‍👩', '💑',
            '👩‍❤️‍👨', '👨‍❤️‍👨', '👩‍❤️‍👩', '👪', '👨‍👩‍👦', '👨‍👩‍👧', '👨‍👩‍👧‍👦', '👨‍👩‍👦‍👦',
            '👨‍👩‍👧‍👧', '👨‍👨‍👦', '👨‍👨‍👧', '👨‍👨‍👧‍👦', '👨‍👨‍👦‍👦', '👨‍👨‍👧‍👧', '👩‍👩‍👦', '👩‍👩‍👧',
            '👩‍👩‍👧‍👦', '👩‍👩‍👦‍👦', '👩‍👩‍👧‍👧', '👨‍👦', '👨‍👦‍👦', '👨‍👧', '👨‍👧‍👦', '👨‍👧‍👧', '👩‍👦',
            '👩‍👦‍👦', '👩‍👧', '👩‍👧‍👦', '👩‍👧‍👧', '🗣', '👤', '👥', '🫂', '👣'
        ];

        // Initialize emoji picker
        function initEmojiPicker() {
            const emojiGrid = emojiPicker.querySelector('.grid');
            emojis.forEach(emoji => {
                const button = document.createElement('button');
                button.className =
                    'text-2xl hover:bg-gray-100 dark:hover:bg-gray-600 rounded p-1 transition-colors transform hover:scale-125';
                button.textContent = emoji;
                button.onclick = () => insertEmoji(emoji);
                emojiGrid.appendChild(button);
            });
        }

        // Insert emoji into message input
        function insertEmoji(emoji) {
            messageInput.value += emoji;
            messageInput.focus();
            toggleEmojiPicker();
        }

        // Toggle emoji picker
        function toggleEmojiPicker() {
            emojiPicker.classList.toggle('hidden');
            if (!gifPicker.classList.contains('hidden')) {
                gifPicker.classList.add('hidden');
            }
        }

        // Toggle GIF picker
        function toggleGifPicker() {
            gifPicker.classList.toggle('hidden');
            if (!emojiPicker.classList.contains('hidden')) {
                emojiPicker.classList.add('hidden');
            }
            if (!gifPicker.classList.contains('hidden')) {
                loadGifs();
            }
        }

        // Load GIFs
        function loadGifs(query = '') {
            // In a real implementation, you would fetch from Giphy API
            // For demo purposes, we'll use placeholder images
            gifContainer.innerHTML = '';

            // Simulate loading
            for (let i = 0; i < 6; i++) {
                const gifDiv = document.createElement('div');
                gifDiv.className =
                    'bg-gray-200 dark:bg-gray-600 rounded-lg h-32 flex items-center justify-center cursor-pointer hover:opacity-90 transition-opacity transform hover:scale-105';
                gifDiv.innerHTML = `<span class="text-gray-500 dark:text-gray-400">GIF ${i+1}</span>`;
                gifDiv.onclick = () => sendGif(`gif-${i}`);
                gifContainer.appendChild(gifDiv);
            }
        }

        // Send GIF
        function sendGif(gifId) {
            // In a real implementation, you would send the GIF URL
            messageInput.value = `[GIF: ${gifId}]`;
            messageForm.dispatchEvent(new Event('submit'));
            toggleGifPicker();
        }

        // Search GIFs
        gifSearchInput.addEventListener('input', (e) => {
            loadGifs(e.target.value);
        });

        // Toggle search bar
        function toggleSearch() {
            searchBar.classList.toggle('hidden');
            if (!searchBar.classList.contains('hidden')) {
                searchInput.focus();
            }
        }

        // Toggle dark mode
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }

        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }

        // Toggle chat options modal
        function toggleChatOptions() {
            chatOptionsModal.classList.toggle('hidden');
            if (!chatOptionsModal.classList.contains('hidden')) {
                setTimeout(() => {
                    chatOptionsContent.classList.remove('scale-95', 'opacity-0');
                    chatOptionsContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                chatOptionsContent.classList.remove('scale-100', 'opacity-100');
                chatOptionsContent.classList.add('scale-95', 'opacity-0');
            }
        }

        // View contact info
        function viewContactInfo() {
            toggleChatOptions();
            contactInfoModal.classList.remove('hidden');
            setTimeout(() => {
                contactInfoContent.classList.remove('scale-95', 'opacity-0');
                contactInfoContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Toggle contact info modal
        function toggleContactInfo() {
            contactInfoModal.classList.toggle('hidden');
            if (!contactInfoModal.classList.contains('hidden')) {
                setTimeout(() => {
                    contactInfoContent.classList.remove('scale-95', 'opacity-0');
                    contactInfoContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                contactInfoContent.classList.remove('scale-100', 'opacity-100');
                contactInfoContent.classList.add('scale-95', 'opacity-0');
            }
        }

        // Clear chat
        function clearChat() {
            if (confirm('Are you sure you want to clear all messages? This cannot be undone.')) {
                axios.post(`/chat/${chatId}/clear`, {
                        _token: document.querySelector('meta[name="csrf-token"]').content
                    })
                    .then(response => {
                        if (response.data.success) {
                            chatMessages.innerHTML =
                                '<div class="text-center py-8 text-gray-500 dark:text-gray-400">No messages yet</div>';
                            toggleChatOptions();
                        }
                    })
                    .catch(error => {
                        console.error('Error clearing chat:', error);
                    });
            }
        }

        // Toggle notifications
        function toggleNotifications() {
            // In a real implementation, you would toggle notifications for this chat
            showNotification('Notifications toggled');
            toggleChatOptions();
        }

        // Export chat
        function exportChat() {
            // In a real implementation, you would export the chat
            showNotification('Chat exported successfully');
            toggleChatOptions();
        }

        // Manage group
        function manageGroup() {
            // In a real implementation, you would show group management options
            showNotification('Group management options');
            toggleChatOptions();
        }

        // Start call
        function startCall(type) {
            callModal.classList.remove('hidden');
            callStatus.textContent = `${type === 'voice' ? 'Voice' : 'Video'} call connecting...`;

            setTimeout(() => {
                callContent.classList.remove('scale-95', 'opacity-0');
                callContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            // In a real implementation, you would initiate a WebRTC call
            // For demo purposes, we'll simulate a call
            setTimeout(() => {
                callStatus.textContent = `${type === 'voice' ? 'Voice' : 'Video'} call in progress...`;
            }, 2000);
        }

        // End call
        function endCall() {
            callContent.classList.remove('scale-100', 'opacity-100');
            callContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                callModal.classList.add('hidden');
            }, 300);
        }

        // Toggle mute during call
        function toggleMute() {
            const muteBtn = document.getElementById('mute-call-btn');
            muteBtn.classList.toggle('bg-red-500');
            muteBtn.classList.toggle('bg-gray-600');
        }

        // Toggle video during call
        function toggleVideo() {
            const videoBtn = document.getElementById('video-call-btn');
            videoBtn.classList.toggle('bg-red-500');
            videoBtn.classList.toggle('bg-gray-600');
        }

        // Share location
        function shareLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const {
                            latitude,
                            longitude
                        } = position.coords;
                        messageInput.value = `Location: https://maps.google.com/?q=${latitude},${longitude}`;
                        messageForm.dispatchEvent(new Event('submit'));
                    },
                    (error) => {
                        showNotification('Error getting location: ' + error.message, 'error');
                    }
                );
            } else {
                showNotification('Geolocation is not supported by this browser.', 'error');
            }
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 10);

            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Load initial messages
        function loadMessages() {
            axios.get(`/chat/${chatId}/messages`)
                .then(response => {
                    // Clear the chat messages container
                    chatMessages.innerHTML = '';

                    // Create a temporary container to hold the messages HTML
                    const tempContainer = document.createElement('div');

                    // Add each message to the container
                    response.data.forEach(message => {
                        const messageElement = createMessageElement(message);
                        tempContainer.appendChild(messageElement);
                    });

                    // Add all messages to the chat container
                    chatMessages.appendChild(tempContainer);

                    // Add event listeners to reply buttons
                    addReplyButtonListeners();

                    // Scroll to bottom
                    scrollToBottom();
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                    chatMessages.innerHTML =
                        '<div class="text-center py-8 text-red-500 font-medium">Error loading messages</div>';
                });
        }

        // Create message element from message data
        function createMessageElement(message) {
            // Check if we need to add a date separator
            const messageDate = moment(message.created_at).format('YYYY-MM-DD');
            const lastMessage = chatMessages.lastElementChild;
            let addDateSeparator = false;

            if (!lastMessage || !lastMessage.classList.contains('message')) {
                addDateSeparator = true;
            } else {
                const lastMessageDate = lastMessage.getAttribute('data-date');
                if (lastMessageDate !== messageDate) {
                    addDateSeparator = true;
                }
            }

            // Create a document fragment to hold the message
            const fragment = document.createDocumentFragment();

            // Add date separator if needed
            if (addDateSeparator) {
                const dateSeparator = document.createElement('div');
                dateSeparator.className = 'date-separator';
                dateSeparator.innerHTML = `<span>${moment(message.created_at).format('MMMM D, YYYY')}</span>`;
                fragment.appendChild(dateSeparator);
            }

            // Create message element
            const messageElement = document.createElement('div');
            messageElement.className = `message ${message.user_id === currentUserId ? 'sent' : 'received'}`;
            messageElement.setAttribute('data-date', messageDate);
            messageElement.setAttribute('data-message-id', message.id);
            messageElement.setAttribute('data-sender-name', message.user.name);

            let messageContent = '';

            // Add reply indicator if it's a reply
            if (message.reply_to && message.reply) {
                messageContent += `
                    <div class="reply-indicator">
                        <i class="fas fa-reply"></i>
                        Replying to ${message.reply.user.name}: ${message.reply.message.substring(0, 50)}${message.reply.message.length > 50 ? '...' : ''}
                    </div>
                `;
            }

            // Text message
            if (message.message) {
                messageContent += `<div class="message-bubble">${message.message}</div>`;
            }

            // Audio message
            if (message.is_audio) {
                messageContent += `
                    <div class="audio-player">
                        <audio controls>
                            <source src="${message.audio_url}" type="${message.file_type || 'audio/mpeg'}">
                            Your browser does not support the audio element.
                        </audio>
                        <div class="audio-wave">
                            <div class="audio-bar"></div>
                            <div class="audio-bar"></div>
                            <div class="audio-bar"></div>
                            <div class="audio-bar"></div>
                            <div class="audio-bar"></div>
                        </div>
                        <div class="audio-info">
                            <div class="audio-name">${message.file_name || 'Audio Message'}</div>
                            <div class="audio-duration">${formatDuration(message.audio_duration)}</div>
                        </div>
                    </div>
                `;
            }

            // File attachment
            if (message.file_path && !message.is_audio) {
                messageContent += `
                    <div class="file-attachment">
                        <div class="file-icon">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name">${message.file_name}</div>
                            <div class="file-meta">${message.file_size}</div>
                        </div>
                        <div class="file-download" onclick="window.open('${message.file_path}', '_blank')">
                            <i class="fas fa-download"></i>
                        </div>
                    </div>
                `;
            }

            // Message status
            let statusIcon = '';
            if (message.user_id === currentUserId) {
                if (message.read_at) {
                    statusIcon = '<i class="fas fa-check-double text-blue-400"></i>';
                } else if (message.delivered_at) {
                    statusIcon = '<i class="fas fa-check-double"></i>';
                } else {
                    statusIcon = '<i class="fas fa-check"></i>';
                }
            }

            messageElement.innerHTML = `
                <div class="message-content">
                    ${messageContent}
                </div>
                <div class="message-actions">
                    <button class="action-btn reply-btn" data-message-id="${message.id}" data-message-text="${message.message ? (message.message.substring(0, 100) + (message.message.length > 100 ? '...' : '')) : (message.is_audio ? 'Audio Message' : 'File')}" data-sender-name="${message.user.name}">
                        <i class="fas fa-reply mr-1"></i> Reply
                    </button>
                    <button class="action-btn react-btn">
                        <i class="fas fa-smile mr-1"></i> React
                    </button>
                    <button class="action-btn forward-btn">
                        <i class="fas fa-forward mr-1"></i> Forward
                    </button>
                    <button class="action-btn star-btn">
                        <i class="fas fa-star mr-1"></i> Star
                    </button>
                    <button class="action-btn delete-btn">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </div>
                <div class="message-time">
                    ${moment(message.created_at).fromNow()}
                    ${statusIcon ? `<span class="message-status">${statusIcon}</span>` : ''}
                </div>
            `;

            fragment.appendChild(messageElement);
            return fragment;
        }

        // Add event listeners to reply buttons
        function addReplyButtonListeners() {
            document.querySelectorAll('.reply-btn').forEach(button => {
                // Remove existing event listeners to avoid duplicates
                button.removeEventListener('click', handleReplyClick);
                // Add new event listener
                button.addEventListener('click', handleReplyClick);
            });
        }

        // Handle reply button click
        function handleReplyClick(e) {
            e.preventDefault();
            const messageId = this.getAttribute('data-message-id');
            const messageText = this.getAttribute('data-message-text');
            const senderName = this.getAttribute('data-sender-name');

            // Show reply preview with animation
            replyPreview.classList.remove('hidden');
            replyPreview.style.animation = 'fadeInUp 0.3s ease-out';
            replySenderId.textContent = senderName;
            replyMessageText.textContent = messageText;
            replyToId.value = messageId;

            // Focus on input
            messageInput.focus();

            // Scroll to bottom to show the input
            scrollToBottom();
        }

        // Cancel reply
        if (cancelReplyBtn) {
            cancelReplyBtn.addEventListener('click', function() {
                replyPreview.classList.add('hidden');
                replyToId.value = '';
            });
        }

        // Load messages on page load
        loadMessages();

        // Auto-refresh messages every 30 seconds as fallback
        setInterval(loadMessages, 30000);

        // Scroll to bottom function
        function scrollToBottom() {
            chatMessages.scrollTo({
                top: chatMessages.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Check if user is at the bottom of the chat
        function isAtBottom() {
            return chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 100;
        }

        // Show/hide scroll to bottom button
        function updateScrollButton() {
            if (!isAtBottom()) {
                scrollToBottomBtn.classList.remove('hidden');
            } else {
                scrollToBottomBtn.classList.add('hidden');
            }
        }

        // Show new messages notification
        function showNewMessagesNotification(count) {
            newMessagesCount.textContent = count;
            newMessagesNotification.classList.remove('hidden');
        }

        // Hide new messages notification
        function hideNewMessagesNotification() {
            newMessagesNotification.classList.add('hidden');
        }

        // Add scroll event listener
        chatMessages.addEventListener('scroll', updateScrollButton);

        // Add touch event listeners for mobile drag detection
        chatMessages.addEventListener('touchstart', (e) => {
            dragStartY = e.changedTouches[0].screenY;
            isDragging = false;
        });

        chatMessages.addEventListener('touchmove', (e) => {
            const currentY = e.changedTouches[0].screenY;
            const diff = Math.abs(currentY - dragStartY);

            if (diff > dragThreshold) {
                isDragging = true;
            }

            updateScrollButton();
        });

        chatMessages.addEventListener('touchend', () => {
            isDragging = false;
        });

        // Add mouse drag event listeners for desktop
        chatMessages.addEventListener('mousedown', (e) => {
            dragStartY = e.screenY;
            isDragging = false;
        });

        chatMessages.addEventListener('mousemove', (e) => {
            const currentY = e.screenY;
            const diff = Math.abs(currentY - dragStartY);

            if (diff > dragThreshold) {
                isDragging = true;
            }

            updateScrollButton();
        });

        chatMessages.addEventListener('mouseup', () => {
            isDragging = false;
        });

        chatMessages.addEventListener('mouseleave', () => {
            isDragging = false;
        });

        // Scroll to bottom when button is clicked
        scrollToBottomBtn.addEventListener('click', () => {
            scrollToBottom();
            hideNewMessagesNotification();
        });

        // Scroll to bottom when new messages notification is clicked
        newMessagesNotification.addEventListener('click', () => {
            scrollToBottom();
            hideNewMessagesNotification();
        });

        // Handle message form submission
        if (messageForm) {
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const messageText = messageInput.value.trim();

                if (messageText === '' && !audioChunks.length && !audioUploadInput.files[0] && !fileUploadInput
                    .files[0]) return;

                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                if (messageText) {
                    formData.append('message', messageText);
                }

                // Add reply_to if replying to a message
                if (replyToId.value) {
                    formData.append('reply_to', replyToId.value);
                }

                // Handle recorded audio
                if (audioChunks.length > 0) {
                    const audioBlob = new Blob(audioChunks, {
                        type: 'audio/mp3'
                    });
                    formData.append('audio', audioBlob, 'recording.mp3');
                    formData.append('audio_duration', recordingDuration);
                }

                // Handle uploaded audio file
                if (audioUploadInput.files[0]) {
                    formData.append('audio', audioUploadInput.files[0]);
                }

                // Handle file upload
                if (fileUploadInput.files[0]) {
                    formData.append('file', fileUploadInput.files[0]);
                }

                // Show sending indicator
                const tempId = 'temp-' + Date.now();
                const tempMessage = createTempMessage(messageText, tempId, replyToId.value);
                chatMessages.appendChild(tempMessage);
                scrollToBottom();

                axios.post(`/chat/${chatId}/send`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        console.log('Response:', response.data);
                        if (response.data.success) {
                            // Remove temporary message
                            const tempElement = document.getElementById(tempId);
                            if (tempElement) tempElement.remove();

                            // Add real message
                            appendMessage(response.data.message);

                            // Clear form and reply
                            messageInput.value = '';
                            resetRecording();
                            audioUploadInput.value = '';
                            fileUploadInput.value = '';
                            replyPreview.classList.add('hidden');
                            replyToId.value = '';
                        } else {
                            // Remove temporary message
                            const tempElement = document.getElementById(tempId);
                            if (tempElement) tempElement.remove();
                            showNotification('Failed to send message: ' + response.data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        // Remove temporary message
                        const tempElement = document.getElementById(tempId);
                        if (tempElement) tempElement.remove();

                        if (error.response) {
                            console.error('Error response data:', error.response.data);
                            showNotification('Error: ' + (error.response.data.message || 'Unknown error'),
                                'error');
                        }

                        if (error.response && error.response.status === 401) {
                            window.location.href = '/login';
                        }
                    });
            });
        }

        // Create temporary message while sending
        function createTempMessage(messageText, tempId, replyToId) {
            const messageElement = document.createElement('div');
            messageElement.className = 'message sent';
            messageElement.id = tempId;

            let messageContent = '';

            // Add reply indicator if replying
            if (replyToId) {
                const originalMessage = document.querySelector(`[data-message-id="${replyToId}"]`);
                if (originalMessage) {
                    const senderName = originalMessage.getAttribute('data-sender-name') || 'Unknown';
                    const originalText = originalMessage.querySelector('.message-bubble')?.textContent || 'Message';
                    messageContent += `
                        <div class="reply-indicator">
                            <i class="fas fa-reply"></i>
                            Replying to ${senderName}: ${originalText.substring(0, 50)}${originalText.length > 50 ? '...' : ''}
                        </div>
                    `;
                }
            }

            if (messageText) {
                messageContent += `<div class="message-bubble">${messageText}</div>`;
            }

            messageElement.innerHTML = `
                <div class="message-content">
                    ${messageContent}
                </div>
                <div class="message-time">
                    Sending...
                    <span class="message-status">
                        <i class="fas fa-clock"></i>
                    </span>
                </div>
            `;

            return messageElement;
        }

        // Append message to chat
        function appendMessage(message) {
            // Check if we need to add a date separator
            const messageDate = moment(message.created_at).format('YYYY-MM-DD');
            const lastMessage = chatMessages.lastElementChild;
            let addDateSeparator = false;

            if (!lastMessage || !lastMessage.classList.contains('message')) {
                addDateSeparator = true;
            } else {
                const lastMessageDate = lastMessage.getAttribute('data-date');
                if (lastMessageDate !== messageDate) {
                    addDateSeparator = true;
                }
            }

            // Create a document fragment to hold the message
            const fragment = document.createDocumentFragment();

            // Add date separator if needed
            if (addDateSeparator) {
                const dateSeparator = document.createElement('div');
                dateSeparator.className = 'date-separator';
                dateSeparator.innerHTML = `<span>${moment(message.created_at).format('MMMM D, YYYY')}</span>`;
                fragment.appendChild(dateSeparator);
            }

            // Create message element
            const messageElement = document.createElement('div');
            messageElement.className = `message ${message.user_id === currentUserId ? 'sent' : 'received'}`;
            messageElement.setAttribute('data-date', messageDate);
            messageElement.setAttribute('data-message-id', message.id);
            messageElement.setAttribute('data-sender-name', message.user.name);

            let messageContent = '';

            // Add reply indicator if it's a reply
            if (message.reply_to && message.reply) {
                messageContent += `
                    <div class="reply-indicator">
                        <i class="fas fa-reply"></i>
                        Replying to ${message.reply.user.name}: ${message.reply.message.substring(0, 50)}${message.reply.message.length > 50 ? '...' : ''}
                    </div>
                `;
            }

            // Text message
            if (message.message) {
                messageContent += `<div class="message-bubble">${message.message}</div>`;
            }

            // Audio message
            if (message.is_audio) {
                messageContent += `
                    <div class="audio-player">
                        <audio controls>
                            <source src="${message.audio_url}" type="${message.file_type || 'audio/mpeg'}">
                            Your browser does not support the audio element.
                        </audio>
                        <div class="audio-wave">
                            <div class="audio-bar"></div>
                            <div class="audio-bar"></div>
                            <div class="audio-bar"></div>
                            <div class="audio-bar"></div>
                            <div class="audio-bar"></div>
                        </div>
                        <div class="audio-info">
                            <div class="audio-name">${message.file_name || 'Audio Message'}</div>
                            <div class="audio-duration">${formatDuration(message.audio_duration)}</div>
                        </div>
                    </div>
                `;
            }

            // File attachment
            if (message.file_path && !message.is_audio) {
                messageContent += `
                    <div class="file-attachment">
                        <div class="file-icon">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name">${message.file_name}</div>
                            <div class="file-meta">${message.file_size}</div>
                        </div>
                        <div class="file-download" onclick="window.open('${message.file_path}', '_blank')">
                            <i class="fas fa-download"></i>
                        </div>
                    </div>
                `;
            }

            // Message status
            let statusIcon = '';
            if (message.user_id === currentUserId) {
                if (message.read_at) {
                    statusIcon = '<i class="fas fa-check-double text-blue-400"></i>';
                } else if (message.delivered_at) {
                    statusIcon = '<i class="fas fa-check-double"></i>';
                } else {
                    statusIcon = '<i class="fas fa-check"></i>';
                }
            }

            messageElement.innerHTML = `
                <div class="message-content">
                    ${messageContent}
                </div>
                <div class="message-actions">
                    <button class="action-btn reply-btn" data-message-id="${message.id}" data-message-text="${message.message ? (message.message.substring(0, 100) + (message.message.length > 100 ? '...' : '')) : (message.is_audio ? 'Audio Message' : 'File')}" data-sender-name="${message.user.name}">
                        <i class="fas fa-reply mr-1"></i> Reply
                    </button>
                    <button class="action-btn react-btn">
                        <i class="fas fa-smile mr-1"></i> React
                    </button>
                    <button class="action-btn forward-btn">
                        <i class="fas fa-forward mr-1"></i> Forward
                    </button>
                    <button class="action-btn star-btn">
                        <i class="fas fa-star mr-1"></i> Star
                    </button>
                    <button class="action-btn delete-btn">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </div>
                <div class="message-time">
                    ${moment(message.created_at).fromNow()}
                    ${statusIcon ? `<span class="message-status">${statusIcon}</span>` : ''}
                </div>
            `;

            fragment.appendChild(messageElement);
            chatMessages.appendChild(fragment);

            // Check if user is at bottom before scrolling
            const wasAtBottom = isAtBottom();

            // Only scroll to bottom if user was already at bottom
            if (wasAtBottom) {
                scrollToBottom();
            } else {
                // Show new messages notification
                const currentCount = parseInt(newMessagesCount.textContent) || 0;
                showNewMessagesNotification(currentCount + 1);
            }

            // Add event listener to the new reply button
            const newReplyBtn = messageElement.querySelector('.reply-btn');
            if (newReplyBtn) {
                newReplyBtn.addEventListener('click', handleReplyClick);
            }
        }

        // Helper function to format duration
        function formatDuration(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        // Initialize Echo for real-time updates
        if (typeof Echo !== 'undefined') {
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: "{{ config('broadcasting.connections.pusher.key') }}",
                cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                forceTLS: true
            });

            // Listen for new messages
            window.Echo.private(`chat.${chatId}`)
                .listen('.message.sent', (e) => {
                    if (e.message.user_id !== currentUserId) {
                        appendMessage(e.message);
                        hideTypingIndicator();
                    }
                })
                .listenForWhisper('typing', (e) => {
                    if (e.user_id !== currentUserId) {
                        showTypingIndicator(e.user_name);
                        // Hide typing indicator after 3 seconds
                        setTimeout(hideTypingIndicator, 3000);
                    }
                });
        } else {
            console.warn('Echo is not defined. Real-time updates may not work.');
        }

        // Typing indicator functions
        function showTypingIndicator(userName = 'Someone') {
            typingIndicator.classList.remove('hidden');
            typingUserName.textContent = userName;
        }

        function hideTypingIndicator() {
            typingIndicator.classList.add('hidden');
        }

        // Send typing indicator
        let typingTimer;
        messageInput.addEventListener('input', function() {
            if (typeof Echo !== 'undefined') {
                window.Echo.private(`chat.${chatId}`)
                    .whisper('typing', {
                        user_id: currentUserId,
                        user_name: "{{ auth()->user()->name }}"
                    });
            }

            // Clear existing timer
            clearTimeout(typingTimer);

            // Set new timer
            typingTimer = setTimeout(() => {
                // Typing stopped
            }, 1000);
        });

        // Mark messages as read when user is active
        let lastActivity = Date.now();
        document.addEventListener('mousemove', () => {
            lastActivity = Date.now();
        });
        document.addEventListener('keypress', () => {
            lastActivity = Date.now();
        });

        // Check if user is active every 5 seconds
        setInterval(() => {
            if (Date.now() - lastActivity < 60000) { // Active in the last minute
                // Mark notifications as read
                axios.post(`/notifications/mark-read/${chatId}`, {
                    _token: document.querySelector('meta[name="csrf-token"]').content
                }).catch(error => {
                    console.error('Error marking notifications as read:', error);
                });
            }
        }, 5000);

        // Audio recording functions
        audioRecordBtn.addEventListener('click', function() {
            if (!mediaRecorder || mediaRecorder.state === 'inactive') {
                startRecording();
            } else {
                stopRecording();
            }
        });

        function startRecording() {
            navigator.mediaDevices.getUserMedia({
                    audio: true
                })
                .then(stream => {
                    mediaRecorder = new MediaRecorder(stream);
                    audioChunks = [];

                    mediaRecorder.ondataavailable = event => {
                        audioChunks.push(event.data);
                    };

                    mediaRecorder.onstop = () => {
                        // Audio recording stopped, chunks are collected
                    };

                    mediaRecorder.start();
                    recordingStartTime = Date.now();

                    // Show recording UI
                    audioRecordingUI.classList.remove('hidden');
                    audioRecordBtn.innerHTML = '<i class="fas fa-stop text-red-500"></i>';

                    // Start timer
                    recordingTimer = setInterval(updateRecordingTimer, 1000);
                })
                .catch(error => {
                    console.error('Error accessing microphone:', error);
                    showNotification('Could not access microphone. Please check permissions.', 'error');
                });
        }

        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                mediaRecorder.stream.getTracks().forEach(track => track.stop());

                // Stop timer
                clearInterval(recordingTimer);

                // Update UI
                audioRecordBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            }
        }

        function updateRecordingTimer() {
            recordingDuration = Math.floor((Date.now() - recordingStartTime) / 1000);
            const minutes = Math.floor(recordingDuration / 60);
            const seconds = recordingDuration % 60;
            recordingTimerDisplay.textContent =
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        function resetRecording() {
            audioChunks = [];
            recordingDuration = 0;
            audioRecordingUI.classList.add('hidden');
            audioRecordBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            clearInterval(recordingTimer);
        }

        cancelRecordingBtn.addEventListener('click', function() {
            stopRecording();
            resetRecording();
        });

        saveRecordingBtn.addEventListener('click', function() {
            stopRecording();
            // Keep the recording UI visible to show the duration
            // The actual sending happens when the form is submitted
        });

        // Initialize emoji picker on page load
        initEmojiPicker();

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            // Chat options modal
            if (event.target === chatOptionsModal) {
                toggleChatOptions();
            }

            // Call modal
            if (event.target === callModal) {
                endCall();
            }

            // Contact info modal
            if (event.target === contactInfoModal) {
                toggleContactInfo();
            }

            // Emoji picker
            if (!emojiPicker.contains(event.target) && !event.target.closest(
                    'button[onclick="toggleEmojiPicker()"]')) {
                emojiPicker.classList.add('hidden');
            }

            // GIF picker
            if (!gifPicker.contains(event.target) && !event.target.closest('button[onclick="toggleGifPicker()"]')) {
                gifPicker.classList.add('hidden');
            }
        });
    </script>
@endsection
