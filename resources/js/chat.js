document.addEventListener('DOMContentLoaded', function() {
    // Initialize Echo for real-time updates
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        forceTLS: true
    });

    // Handle message sending
    const messageForm = document.getElementById('message-form');
    if (messageForm) {
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const input = document.getElementById('message-input');
            const chatId = input.dataset.chatId;
            
            if (input.value.trim() === '') return;
            
            axios.post(`/chat/${chatId}/send`, {
                message: input.value
            })
            .then(response => {
                if (response.data.success) {
                    input.value = '';
                    appendMessage(response.data.message);
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                if (error.response && error.response.status === 401) {
                    window.location.href = '/login';
                }
            });
        });
    }

    // Handle reply button click
    document.addEventListener('click', function(e) {
        if (e.target.closest('.reply-btn')) {
            const messageElement = e.target.closest('.message');
            if (!messageElement) return;
            
            const messageContent = messageElement.querySelector('.message-content');
            if (!messageContent) return;
            
            const messageText = messageContent.textContent.trim();
            const input = document.getElementById('message-input');
            if (input) {
                input.value = `Replying to: ${messageText}\n`;
                input.focus();
            }
        }
    });

    // Handle context menu
    document.addEventListener('contextmenu', function(e) {
        if (e.target.closest('.message')) {
            e.preventDefault();
            const messageElement = e.target.closest('.message');
            if (!messageElement) return;
            
            const messageContent = messageElement.querySelector('.message-content');
            if (!messageContent) return;
            
            const messageText = messageContent.textContent.trim();
            showContextMenu(e.pageX, e.pageY, messageText);
        }
    });

    // Append message to chat
    function appendMessage(message) {
        const messagesContainer = document.getElementById('chat-messages');
        if (!messagesContainer) return;
        
        const messageElement = document.createElement('div');
        messageElement.className = `message ${message.user_id === currentUserId ? 'sent' : 'received'} p-4 rounded-2xl max-w-xs lg:max-w-md`;
        
        let senderInfo = '';
        if (message.user_id !== currentUserId) {
            senderInfo = `<div class="message-sender font-bold text-gray-700">${message.user.name}</div>`;
        }
        
        messageElement.innerHTML = `
            ${senderInfo}
            <div class="message-content text-gray-800">${message.message}</div>
            <div class="message-time text-xs text-gray-500 mt-1">${moment(message.created_at).fromNow()}</div>
        `;
        
        messagesContainer.appendChild(messageElement);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Show context menu
    function showContextMenu(x, y, messageText) {
        // Remove existing context menu
        const existingMenu = document.getElementById('message-context-menu');
        if (existingMenu) {
            existingMenu.remove();
        }
        
        const menu = document.createElement('div');
        menu.id = 'message-context-menu';
        menu.className = 'absolute bg-white shadow-lg rounded-md py-2 z-50';
        menu.style.left = `${x}px`;
        menu.style.top = `${y}px`;
        
        menu.innerHTML = `
            <button class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                <i class="fas fa-reply mr-2"></i> Reply
            </button>
            <button class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                <i class="fas fa-copy mr-2"></i> Copy
            </button>
            <button class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-red-500">
                <i class="fas fa-trash mr-2"></i> Delete
            </button>
        `;
        
        document.body.appendChild(menu);
        
        // Close menu when clicking elsewhere
        document.addEventListener('click', function closeMenu() {
            menu.remove();
            document.removeEventListener('click', closeMenu);
        });
    }
});