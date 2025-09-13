@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto h-screen flex flex-col">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col h-full">
            <!-- Enhanced Chat Header -->
            <div class="relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600"></div>
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
                                            class="absolute bottom-0 right-3 w-4 h-4 bg-green-400 rounded-full border-2 border-white shadow-md">
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
                                            <i class="fas fa-circle text-green-400 text-xs mr-1"></i> Online now
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <button
                                class="p-3 rounded-full bg-white/20 hover:bg-white/30 transition-all transform hover:scale-110 shadow-md">
                                <i class="fas fa-phone"></i>
                            </button>
                            <button
                                class="p-3 rounded-full bg-white/20 hover:bg-white/30 transition-all transform hover:scale-110 shadow-md">
                                <i class="fas fa-video"></i>
                            </button>
                            <button
                                class="p-3 rounded-full bg-white/20 hover:bg-white/30 transition-all transform hover:scale-110 shadow-md">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Chat Messages -->
            <div class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-gray-100" id="chat-messages">
                <div class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-14 w-14 border-t-3 border-b-3 border-indigo-600">
                    </div>
                    <p class="mt-4 text-gray-600 font-medium">Loading messages...</p>
                </div>
            </div>

            <!-- Enhanced Typing Indicator -->
            <div id="typing-indicator" class="hidden px-6 py-3 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="bg-white rounded-2xl shadow-lg px-4 py-3 inline-flex items-center border border-gray-100">
                        <div class="flex space-x-1 mr-2">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms">
                            </div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms">
                            </div>
                        </div>
                        <span class="text-gray-600 text-sm font-medium">Someone is typing...</span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Scroll to Bottom Button -->
            <button id="scroll-to-bottom"
                class="hidden fixed bottom-24 right-8 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full p-3 shadow-lg hover:shadow-xl transition-all z-10 transform hover:scale-110">
                <i class="fas fa-arrow-down"></i>
            </button>

            <!-- Enhanced Message Input -->
            <div class="p-6 border-t border-gray-200 bg-white">
                <!-- Enhanced Reply Preview -->
                <div id="reply-preview" class="reply-preview hidden mb-4">
                    <div
                        class="flex items-start bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4 border border-indigo-100 shadow-sm">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-reply text-indigo-500 mr-2"></i>
                                <span class="text-sm font-semibold text-gray-700">Replying to <span id="reply-sender-name"
                                        class="text-indigo-600"></span></span>
                            </div>
                            <div class="bg-white rounded-lg p-3 border-l-4 border-indigo-500 shadow-sm">
                                <p id="reply-message-text" class="text-sm text-gray-600"></p>
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
                            <button type="button"
                                class="text-gray-400 hover:text-indigo-600 transition-all transform hover:scale-110 p-2 rounded-full hover:bg-indigo-50">
                                <i class="far fa-smile text-lg"></i>
                            </button>
                            <!-- Enhanced File Upload Button -->
                            <label for="file-upload"
                                class="text-gray-400 hover:text-indigo-600 transition-all transform hover:scale-110 cursor-pointer p-2 rounded-full hover:bg-indigo-50">
                                <i class="fas fa-paperclip text-lg"></i>
                            </label>
                            <input type="file" id="file-upload" class="hidden"
                                accept="image/*,application/pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            <!-- Enhanced Audio Upload Button -->
                            <label for="audio-upload"
                                class="text-gray-400 hover:text-indigo-600 transition-all transform hover:scale-110 cursor-pointer p-2 rounded-full hover:bg-indigo-50">
                                <i class="fas fa-file-audio text-lg"></i>
                            </label>
                            <input type="file" id="audio-upload" class="hidden" accept="audio/*">
                        </div>
                        <input type="text" id="message-input" data-chat-id="{{ $chat->id }}"
                            class="w-full px-5 py-3 bg-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all resize-none shadow-inner"
                            placeholder="Type a message..." rows="1">
                        <div class="absolute right-3 bottom-3">
                            <!-- Enhanced Audio Record Button -->
                            <button type="button" id="audio-record-btn"
                                class="text-gray-400 hover:text-indigo-600 transition-all transform hover:scale-110 p-2 rounded-full hover:bg-indigo-50">
                                <i class="fas fa-microphone text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white flex items-center justify-center hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-110">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>

                <!-- Enhanced Audio Recording UI -->
                <div id="audio-recording-ui"
                    class="hidden mt-4 p-4 bg-gradient-to-r from-red-50 to-pink-50 rounded-xl border border-red-200 shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full animate-pulse mr-3 shadow-md"></div>
                            <div>
                                <span class="text-red-600 font-medium">Recording...</span>
                                <span id="recording-timer" class="ml-2 text-red-600 font-mono text-sm">00:00</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button id="cancel-recording"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all transform hover:scale-105 shadow-sm">
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

    <style>
        /* Enhanced Message bubble styles */
        .message {
            margin-bottom: 24px;
            display: flex;
            flex-direction: column;
            position: relative;
            animation: fadeInUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
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

        .message.sent .message-bubble:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }

        .message.received .message-bubble:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .message-time {
            font-size: 12px;
            color: #999;
            margin-top: 6px;
            opacity: 0.7;
            transition: opacity 0.3s;
            font-weight: 500;
        }

        .message:hover .message-time {
            opacity: 1;
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

        /* Enhanced Message actions */
        .message-actions {
            display: none;
            position: absolute;
            top: -45px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            z-index: 20;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .message.sent .message-actions {
            right: 0;
        }

        .message.received .message-actions {
            left: 0;
        }

        .message:hover .message-actions {
            display: block;
            animation: slideDown 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .action-btn {
            padding: 10px 14px;
            border: none;
            background: none;
            color: #666;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            width: 100%;
            text-align: left;
        }

        .action-btn:hover {
            background: #f5f5f5;
            color: #6366f1;
            transform: translateX(3px);
        }

        .action-btn:first-child {
            border-radius: 14px 14px 0 0;
        }

        .action-btn:last-child {
            border-radius: 0 0 14px 14px;
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

        .message.received .file-download:hover {
            background-color: #dee2e6;
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

        // Reply elements
        const replyPreview = document.getElementById('reply-preview');
        const replySenderId = document.getElementById('reply-sender-name');
        const replyMessageText = document.getElementById('reply-message-text');
        const replyToId = document.getElementById('reply-to-id');
        const cancelReplyBtn = document.getElementById('cancel-reply');

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

            messageElement.innerHTML = `
                <div class="message-content">
                    ${messageContent}
                </div>
                <div class="message-actions">
                    <button class="action-btn reply-btn" data-message-id="${message.id}" data-message-text="${message.message ? (message.message.substring(0, 100) + (message.message.length > 100 ? '...' : '')) : (message.is_audio ? 'Audio Message' : 'File')}" data-sender-name="${message.user.name}">
                        <i class="fas fa-reply mr-1"></i> Reply
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-smile mr-1"></i> React
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-ellipsis-h mr-1"></i> More
                    </button>
                </div>
                <div class="message-time">
                    ${moment(message.created_at).fromNow()}
                    ${message.user_id === currentUserId ? '<span class="message-status"><i class="fas fa-check-double"></i></span>' : ''}
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

        // Show/hide scroll to bottom button
        chatMessages.addEventListener('scroll', function() {
            if (chatMessages.scrollTop + chatMessages.clientHeight < chatMessages.scrollHeight - 100) {
                scrollToBottomBtn.classList.remove('hidden');
            } else {
                scrollToBottomBtn.classList.add('hidden');
            }
        });

        // Scroll to bottom when button is clicked
        scrollToBottomBtn.addEventListener('click', scrollToBottom);

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
                            alert('Failed to send message: ' + response.data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        // Remove temporary message
                        const tempElement = document.getElementById(tempId);
                        if (tempElement) tempElement.remove();

                        if (error.response) {
                            console.error('Error response data:', error.response.data);
                            alert('Error: ' + (error.response.data.message || 'Unknown error'));
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
                    const senderName = originalMessage.querySelector('.message-time').previousElementSibling?.textContent ||
                        'Unknown';
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

            messageElement.innerHTML = `
                <div class="message-content">
                    ${messageContent}
                </div>
                <div class="message-actions">
                    <button class="action-btn reply-btn" data-message-id="${message.id}" data-message-text="${message.message ? (message.message.substring(0, 100) + (message.message.length > 100 ? '...' : '')) : (message.is_audio ? 'Audio Message' : 'File')}" data-sender-name="${message.user.name}">
                        <i class="fas fa-reply mr-1"></i> Reply
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-smile mr-1"></i> React
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-ellipsis-h mr-1"></i> More
                    </button>
                </div>
                <div class="message-time">
                    ${moment(message.created_at).fromNow()}
                    ${message.user_id === currentUserId ? '<span class="message-status"><i class="fas fa-check-double"></i></span>' : ''}
                </div>
            `;

            fragment.appendChild(messageElement);
            chatMessages.appendChild(fragment);
            scrollToBottom();

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
                        showTypingIndicator();
                        // Hide typing indicator after 3 seconds
                        setTimeout(hideTypingIndicator, 3000);
                    }
                });
        } else {
            console.warn('Echo is not defined. Real-time updates may not work.');
        }

        // Typing indicator functions
        function showTypingIndicator() {
            typingIndicator.classList.remove('hidden');
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
                        user_id: currentUserId
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
                    alert('Could not access microphone. Please check permissions.');
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
    </script>
@endsection
