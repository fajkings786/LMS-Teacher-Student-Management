<!-- Notification Bell -->
<div class="dropdown">
    <button class="btn btn-outline-light position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        @if($unreadNotifications > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadNotifications }}
                <span class="visually-hidden">unread notifications</span>
            </span>
        @endif
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 350px; max-height: 400px; overflow-y: auto;">
        <li><h6 class="dropdown-header">Notifications</h6></li>
        <li><hr class="dropdown-divider"></li>
        <div id="notification-list">
            <!-- Notifications will be loaded here -->
        </div>
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item text-center" href="{{ route('chat.index') }}">
                View All Chats
            </a>
        </li>
    </ul>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">New Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center">
                    <img id="notification-avatar" src="" class="rounded-circle me-3" width="50" height="50" alt="Avatar">
                    <div>
                        <h6 id="notification-sender"></h6>
                        <p id="notification-message" class="mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a id="notification-link" href="#" class="btn btn-primary">View Chat</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Load notifications
    function loadNotifications() {
        fetch("{{ route('notifications.get') }}")
            .then(response => response.json())
            .then(notifications => {
                const notificationList = document.getElementById('notification-list');
                notificationList.innerHTML = '';
                
                if (notifications.length === 0) {
                    notificationList.innerHTML = '<li><span class="dropdown-item-text">No new notifications</span></li>';
                } else {
                    notifications.forEach(notification => {
                        const notificationItem = document.createElement('li');
                        notificationItem.className = 'dropdown-item notification-item';
                        notificationItem.dataset.id = notification.id;
                        
                        const avatar = notification.message.user.profile_picture 
                            ? `/storage/${notification.message.user.profile_picture}` 
                            : `https://ui-avatars.com/api/?name=${notification.message.user.name}&background=random`;
                        
                        notificationItem.innerHTML = `
                            <div class="d-flex align-items-center">
                                <img src="${avatar}" class="rounded-circle me-3" width="40" height="40" alt="Avatar">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong>${notification.message.user.name}</strong>
                                        <small>${moment(notification.created_at).fromNow()}</small>
                                    </div>
                                    <div class="text-truncate">${notification.message.message}</div>
                                </div>
                            </div>
                        `;
                        
                        notificationItem.addEventListener('click', function() {
                            window.location.href = `/chat/${notification.chat_id}`;
                        });
                        
                        notificationList.appendChild(notificationItem);
                    });
                }
            });
    }
    
    // Check for new notifications
    setInterval(function() {
        fetch("{{ route('notifications.get') }}")
            .then(response => response.json())
            .then(notifications => {
                // Show modal for new notifications
                notifications.forEach(notification => {
                    if (!notification.read) {
                        const avatar = notification.message.user.profile_picture 
                            ? `/storage/${notification.message.user.profile_picture}` 
                            : `https://ui-avatars.com/api/?name=${notification.message.user.name}&background=random`;
                        
                        document.getElementById('notification-avatar').src = avatar;
                        document.getElementById('notification-sender').innerText = notification.message.user.name;
                        document.getElementById('notification-message').innerText = notification.message.message;
                        document.getElementById('notification-link').href = `/chat/${notification.chat_id}`;
                        
                        const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                        modal.show();
                        
                        // Mark as read
                        fetch(`/notifications/${notification.id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        });
                    }
                });
                
                // Update notification bell
                const unreadCount = notifications.filter(n => !n.read).length;
                const badge = document.querySelector('.badge.rounded-pill.bg-danger');
                if (badge) {
                    if (unreadCount > 0) {
                        badge.textContent = unreadCount;
                        badge.style.display = 'block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
                
                // Reload notification list
                loadNotifications();
            });
    }, 10000); // Check every 10 seconds
    
    // Initial load
    loadNotifications();
</script>