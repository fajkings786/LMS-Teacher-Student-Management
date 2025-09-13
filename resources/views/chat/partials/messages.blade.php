@php
    $currentDate = null;
@endphp

@foreach ($messages as $message)
    @php
        $isSent = $message->user_id == auth()->id();
        $messageDate = $message->created_at->format('Y-m-d');
        if ($messageDate !== $currentDate) {
            $currentDate = $messageDate;
    @endphp
        <div class="date-separator">
            <span>{{ $message->created_at->format('F j, Y') }}</span>
        </div>
    @php
        }
    @endphp

    <div class="message {{ $isSent ? 'sent' : 'received' }}" data-message-id="{{ $message->id }}" data-date="{{ $messageDate }}">
        @if ($message->reply_to)
            @php
                $replyMessage = $message->reply;
            @endphp
            @if ($replyMessage)
                <div class="reply-indicator">
                    <i class="fas fa-reply"></i>
                    Replying to {{ $replyMessage->user->name }}: {{ Str::limit($replyMessage->message, 50) }}
                </div>
            @endif
        @endif

        <div class="message-content">
            @if ($message->message)
                <div class="message-bubble">{{ $message->message }}</div>
            @endif

            @if ($message->is_audio)
                <div class="audio-player">
                    <audio controls>
                        <source src="{{ $message->audio_url }}" type="{{ $message->file_type ?? 'audio/mpeg' }}">
                        Your browser does not support the audio element.
                    </audio>
                    <div class="audio-info">
                        <div class="audio-name">{{ $message->file_name ?? 'Audio Message' }}</div>
                        <div class="audio-duration">{{ gmdate('i:s', $message->audio_duration) }}</div>
                    </div>
                </div>
            @endif

            @if ($message->file_path && !$message->is_audio)
                <div class="file-attachment">
                    <div class="file-icon">
                        <i class="fas fa-file"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name">{{ $message->file_name }}</div>
                        <div class="file-meta">{{ $message->file_size }}</div>
                    </div>
                    <div class="file-download" onclick="window.open('{{ $message->file_path }}', '_blank')">
                        <i class="fas fa-download"></i>
                    </div>
                </div>
            @endif
        </div>

        <div class="message-actions">
            <button class="reply-btn" data-message-id="{{ $message->id }}" data-message-text="{{ $message->message ? e(Str::limit($message->message, 100)) : ($message->is_audio ? 'Audio Message' : 'File') }}" data-sender-name="{{ $message->user->name }}">
                <i class="fas fa-reply"></i>
            </button>
        </div>

        <div class="message-time">
            {{ $message->created_at->diffForHumans() }}
            @if ($isSent)
                <span class="message-status">
                    <i class="fas fa-check-double"></i>
                </span>
            @endif
        </div>
    </div>
@endforeach