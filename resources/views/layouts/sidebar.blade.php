<aside
    class="fixed top-0 left-0 h-full w-72 sidebar-bg text-white shadow-2xl flex flex-col border-r border-gray-800 z-10">
    <div class="sidebar-content h-full flex flex-col">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-800">
            <div class="relative">
                <img src="https://flowbite.com/docs/images/logo.svg" alt="Logo" class="h-12 drop-shadow-lg">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full opacity-20 blur-md">
                </div>
            </div>
            <span class="text-2xl font-bold logo-gradient">Dashboard</span>
        </div>

        <!-- User Profile -->
        @if (auth()->check())
            <div
                class="px-6 py-5 flex flex-col items-center gap-3 profile-card rounded-xl mx-4 mt-5 mb-5 transition-all duration-300">
                <div class="relative">
                    <img class="w-20 h-20 rounded-full object-cover border-4 border-indigo-500 shadow-md"
                        src="{{ auth()->user()->profile_picture
                            ? asset('storage/' . auth()->user()->profile_picture)
                            : 'https://flowbite.com/docs/images/people/profile-picture-5.jpg' }}"
                        alt="User Photo">
                    <div
                        class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 rounded-full border-2 border-gray-800 flex items-center justify-center">
                        <div class="w-3 h-3 bg-white rounded-full"></div>
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="text-white font-semibold text-lg">{{ auth()->user()->name }}</h3>
                    <p class="text-gray-400 text-sm">Role: {{ auth()->user()->role }}</p>
                </div>
                <!-- Change Picture Form -->
                <form action="{{ route('profile.updatePicture') }}" method="POST" enctype="multipart/form-data"
                    class="mt-3">
                    @csrf
                    <input type="file" name="profile_picture" class="hidden" id="profileInput" accept="image/*"
                        onchange="this.form.submit()">
                    <label for="profileInput"
                        class="cursor-pointer px-4 py-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                        Change Picture
                    </label>
                </form>
            </div>
        @else
            <div class="px-6 py-5 flex items-center gap-3 bg-gray-700 rounded-lg mx-4 mt-5 mb-5">
                <div>
                    <h3 class="text-white font-semibold">Guest</h3>
                    <p class="text-gray-300 text-sm">Not logged in</p>
                </div>
            </div>
        @endif

        <!-- Navigation -->
        <nav class="mt-2 flex-1 overflow-y-auto px-2 space-y-1 sidebar-nav">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link sidebar-item {{ request()->routeIs('dashboard') ? 'active-link' : '' }}"
                data-page="dashboard">
                <i class="fas fa-tachometer-alt text-indigo-400 sidebar-icon"></i>
                <span>Dashboard</span>
            </a>

            <!-- Students -->
            @if (auth()->user()->role == 'Student')
                <a href="{{ route('results.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link sidebar-item {{ request()->routeIs('results.index') ? 'active-link' : '' }}"
                    data-page="results">
                    <i class="fas fa-file-alt text-blue-400 sidebar-icon"></i>
                    <span>View Result</span>
                </a>
            @endif

            <!-- Users Dropdown -->
            @if (auth()->user()->role == 'Admin')
                @php
                    $usersActive = request()->routeIs('admin.pendingUsers') || request()->routeIs('admin.users');
                @endphp
                <div class="px-2 py-1">
                    <button onclick="toggleDropdown('usersDropdown')"
                        class="flex items-center justify-between w-full px-3 py-2 rounded-lg sidebar-item {{ $usersActive ? 'active' : '' }}"
                        data-menu="users">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-users text-purple-400 sidebar-icon"></i>
                            <span>Users</span>
                        </span>
                        <i id="usersDropdownIcon"
                            class="fas fa-chevron-down transition-transform duration-300 text-gray-400 {{ $usersActive ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="usersDropdown"
                        class="dropdown flex-col mt-1 sidebar-dropdown rounded-lg {{ $usersActive ? 'open' : 'hidden' }}">
                        <a href="{{ route('admin.pendingUsers') }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('admin.pendingUsers') ? 'active-link' : '' }}"
                            data-page="pending-users">
                            Pending Users
                        </a>
                        <a href="{{ route('admin.approved.users', ['id' => auth()->user()->id]) }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('admin.approved.users') ? 'active-link' : '' }}"
                            data-page="approved-users">
                            Approve User
                        </a>
                        <a href="{{ route('admin.users') }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('admin.users') ? 'active-link' : '' }}"
                            data-page="all-users">
                            All Users
                        </a>
                    </div>
                </div>
            @endif

            <!-- Courses Dropdown -->
            @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Student' || auth()->user()->role == 'Teacher')
                @php
                    $coursesActive = request()->is('courses*') || request()->routeIs('attendance.index');
                @endphp
                <div class="px-2 py-1">
                    <button onclick="toggleDropdown('coursesDropdown')"
                        class="flex items-center justify-between w-full px-3 py-2 rounded-lg sidebar-item {{ $coursesActive ? 'active' : '' }}"
                        data-menu="courses">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-book text-green-400 sidebar-icon"></i>
                            <span>Courses</span>
                        </span>
                        <i id="coursesDropdownIcon"
                            class="fas fa-chevron-down transition-transform duration-300 text-gray-400 {{ $coursesActive ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="coursesDropdown"
                        class="dropdown flex-col mt-1 sidebar-dropdown rounded-lg {{ $coursesActive ? 'open' : 'hidden' }}">
                        <a href="{{ route('student.lectures') }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->is('student/lectures') ? 'active-link' : '' }}"
                            data-page="all-courses">
                            All Courses
                        </a>
                        @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Teacher')
                            <a href="{{ route('add.course') }}"
                                class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link"
                                data-page="add-course">
                                Add Course
                            </a>
                        @endif
                        <a href=""
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link"
                            data-page="categories">
                            Categories
                        </a>
                        <a href="{{ route('attendance.index') }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('attendance.index') ? 'active-link' : '' }}"
                            data-page="attendance">
                            Your Attendance
                        </a>
                    </div>
                </div>
            @endif

            <!-- Attendance Dropdown -->
            @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Teacher')
                @php
                    $attendanceActive = request()->routeIs('attendance.*');
                @endphp
                <div class="px-2 py-1">
                    <button onclick="toggleDropdown('reportsDropdown')"
                        class="flex items-center justify-between w-full px-3 py-2 rounded-lg sidebar-item {{ $attendanceActive ? 'active' : '' }}"
                        data-menu="attendance">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-chart-bar text-yellow-400 sidebar-icon"></i>
                            <span>Attendance</span>
                        </span>
                        <i id="reportsDropdownIcon"
                            class="fas fa-chevron-down transition-transform duration-300 text-gray-400 {{ $attendanceActive ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="reportsDropdown"
                        class="dropdown flex-col mt-1 sidebar-dropdown rounded-lg {{ $attendanceActive ? 'open' : 'hidden' }}">
                        <a href="{{ route('attendance.index') }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('attendance.index') ? 'active-link' : '' }}"
                            data-page="all-students">
                            All Students
                        </a>
                        <a href="{{ route('attendance.crite') }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('attendance.crite') ? 'active-link' : '' }}"
                            data-page="crite-area">
                            Total Crite Area
                        </a>
                        <a href="{{ route('attendance.calendar') }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('attendance.calendar') ? 'active-link' : '' }}"
                            data-page="calendar">
                            Calendar View
                        </a>
                    </div>
                </div>
            @endif

            <!-- Results Dropdown -->
            @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Teacher')
                @php
                    $resultsActive = request()->routeIs('results.*');
                @endphp
                <div class="px-2 py-1">
                    <button onclick="toggleDropdown('resultsDropdown')"
                        class="flex items-center justify-between w-full px-3 py-2 rounded-lg sidebar-item {{ $resultsActive ? 'active' : '' }}"
                        data-menu="results">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-graduation-cap text-indigo-400 sidebar-icon"></i>
                            <span>Results</span>
                        </span>
                        <i id="resultsDropdownIcon"
                            class="fas fa-chevron-down transition-transform duration-300 text-gray-400 {{ $resultsActive ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="resultsDropdown"
                        class="dropdown flex-col mt-1 sidebar-dropdown rounded-lg {{ $resultsActive ? 'open' : 'hidden' }}">
                        <a href="{{ route('results.create') }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('results.create') ? 'active-link' : '' }}"
                            data-page="add-result">
                            Add Result
                        </a>
                        <a href="{{ route('results.index') }}"
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('results.index') ? 'active-link' : '' }}"
                            data-page="all-results">
                            All Results
                        </a>
                    </div>
                </div>
            @endif

            <!-- Messages Link -->
            <a href="{{ route('chat.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link sidebar-item">
                <i class="fas fa-envelope text-purple-400 sidebar-icon"></i>
                <span>Messages</span>
                <span class="ml-auto w-2 h-2 bg-red-500 rounded-full pulse"></span>
            </a>

            <!-- More Options -->
            @if (auth()->user()->role == 'Admin')
                <div class="px-2 py-1">
                    <button onclick="toggleDropdown('moreDropdown')"
                        class="flex items-center justify-between w-full px-3 py-2 rounded-lg sidebar-item">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-ellipsis-h text-pink-400 sidebar-icon"></i>
                            <span>More Options</span>
                        </span>
                        <i id="moreDropdownIcon"
                            class="fas fa-chevron-down transition-transform duration-300 text-gray-400"></i>
                    </button>
                    <div id="moreDropdown" class="dropdown hidden flex-col mt-1 sidebar-dropdown rounded-lg">
                        <a href=""
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link relative">
                            Calendar
                        </a>
                        <a href=""
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link">Tasks</a>
                        <a href=""
                            class="block px-3 py-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-300 nav-link relative">
                            Notifications
                            <span class="absolute right-3 top-2.5 w-2 h-2 bg-red-500 rounded-full pulse"></span>
                        </a>
                    </div>
                </div>
            @endif
        </nav>

        <!-- Button Container -->
        <div class="button-container">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <button onclick="event.preventDefault(); handleLogout();" class="btn-dashboard btn-logout ripple">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
            <a href="/" class="btn-dashboard btn-home ripple">
                <i class="fas fa-home"></i>
                <span>Go to Home</span>
            </a>
        </div>
    </div>
</aside>

<style>
    /* Custom Scrollbar - Enhanced */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #6366f1, #9333ea);
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
    }

    ::-webkit-scrollbar-track {
        background: #111827;
        border-radius: 10px;
    }

    /* Enhanced scrollbar on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #818cf8, #a78bfa);
    }

    /* Active Menu Highlight */
    .active-link {
        background: linear-gradient(90deg, #6366f1, #9333ea);
        color: #fff !important;
        box-shadow: 0 0 12px rgba(147, 51, 234, 0.5);
    }

    .active-link i {
        color: #fff !important;
    }

    /* Dropdown Animation */
    .dropdown {
        transition: all 0.3s ease-in-out;
    }

    .dropdown.hidden {
        max-height: 0;
        opacity: 0;
        overflow: hidden;
    }

    .dropdown.open {
        max-height: 500px;
        opacity: 1;
    }

    /* Smooth Hover */
    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }

    /* Animated gradient background */
    .gradient-bg {
        background: linear-gradient(-45deg, #111827, #1f2937, #111827, #1f2937);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Glass morphism effect */
    .glass {
        background: rgba(31, 41, 55, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Pulse animation for notifications */
    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
        }
    }

    /* Custom tooltip */
    .tooltip {
        position: relative;
    }

    .tooltip::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #1f2937;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s;
    }

    .tooltip:hover::after {
        opacity: 1;
    }

    /* Loading animation */
    .loader {
        border: 3px solid rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        border-top: 3px solid #6366f1;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Small chart containers */
    .small-chart-container {
        height: 150px;
        position: relative;
    }

    /* Enhanced Sidebar Styles */
    .sidebar-bg {
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        position: relative;
        overflow: hidden;
    }

    .sidebar-bg::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 90% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
        z-index: 0;
    }

    .sidebar-content {
        position: relative;
        z-index: 1;
    }

    .sidebar-item {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .sidebar-item::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(180deg, #6366f1, #9333ea);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .sidebar-item:hover::before {
        transform: scaleY(1);
    }

    .sidebar-item:hover {
        background: rgba(99, 102, 241, 0.1);
    }

    .sidebar-item.active {
        background: linear-gradient(90deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
        border-left: 3px solid #6366f1;
    }

    .sidebar-item.active::before {
        transform: scaleY(1);
    }

    .profile-card {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        border: 1px solid rgba(99, 102, 241, 0.2);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .profile-card:hover {
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
    }

    .logo-gradient {
        background: linear-gradient(90deg, #6366f1, #9333ea);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .sidebar-icon {
        transition: all 0.3s ease;
    }

    .sidebar-item:hover .sidebar-icon {
        transform: translateX(3px);
    }

    .sidebar-dropdown {
        background: rgba(15, 23, 42, 0.6);
        border-left: 1px dashed rgba(99, 102, 241, 0.3);
        margin-left: 1rem;
    }

    /* Enhanced Button Styles */
    .btn-dashboard {
        position: relative;
        overflow: hidden;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1;
        text-decoration: none;
        width: 100%;
    }

    .btn-dashboard:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-dashboard:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Logout Button */
    .btn-logout {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .btn-logout:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    /* Home Button */
    .btn-home {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .btn-home:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }

    /* Ripple Effect */
    .ripple {
        position: relative;
        overflow: hidden;
    }

    .ripple::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .ripple:active::before {
        width: 300px;
        height: 300px;
    }

    /* Button Container */
    .button-container {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Enhanced sidebar scrollbar */
    .sidebar-nav::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.5);
        border-radius: 10px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #6366f1, #9333ea);
        border-radius: 10px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #818cf8, #a78bfa);
    }

    /* Notification Button */
    .btn-notification {
        position: relative;
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 50%;
        background: rgba(31, 41, 55, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-notification:hover {
        background: rgba(31, 41, 55, 0.9);
        transform: scale(1.05);
    }

    /* Icon Button */
    .icon-btn {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        background: rgba(31, 41, 55, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .icon-btn:hover {
        background: rgba(31, 41, 55, 0.9);
        transform: translateY(-2px);
    }

    /* Message button styles */
    .message-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 50%;
        background: rgba(31, 41, 55, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: visible;
    }

    .message-btn:hover {
        background: rgba(31, 41, 55, 0.9);
        transform: scale(1.05);
    }

    .message-btn .notification-dot {
        position: absolute;
        top: 0;
        right: 0;
        width: 12px;
        height: 12px;
        background-color: #ef4444;
        border-radius: 50%;
        border: 2px solid #1f2937;
        animation: pulse 2s infinite;
    }
</style>

<script>
    // Dropdown Toggle
    function toggleDropdown(id) {
        const dropdowns = document.querySelectorAll('.dropdown');
        const icons = document.querySelectorAll('[id$="Icon"]');

        dropdowns.forEach(d => {
            const relatedIcon = document.getElementById(d.id + "Icon");
            if (d.id !== id) {
                d.classList.remove('open');
                d.classList.add('hidden');
                if (relatedIcon) relatedIcon.classList.remove('rotate-180');
            }
        });

        const dropdown = document.getElementById(id);
        const icon = document.getElementById(id + "Icon");
        const isOpen = dropdown.classList.contains('open');

        if (isOpen) {
            dropdown.classList.remove('open');
            dropdown.classList.add('hidden');
            icon.classList.remove('rotate-180');
            localStorage.removeItem('activeMenu');
        } else {
            dropdown.classList.remove('hidden');
            dropdown.classList.add('open');
            icon.classList.add('rotate-180');
            const menuName = id.replace('Dropdown', '');
            localStorage.setItem('activeMenu', menuName);
        }
    }

    // Handle logout functionality
    function handleLogout() {
        const logoutForm = document.getElementById('logout-form');
        const logoutBtn = document.querySelector('.btn-logout');
        // Show loading state
        logoutBtn.disabled = true;
        logoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Logging out...</span>';
        // Clear localStorage and sessionStorage
        localStorage.clear();
        sessionStorage.clear();
        // Submit the logout form using fetch
        fetch(logoutForm.action, {
                method: 'POST',
                body: new FormData(logoutForm),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Logout successful:', data);
                // Redirect to home page
                window.location.href = '/';
            })
            .catch(error => {
                console.error('Logout error:', error);
                // Even if there's an error, redirect to home
                window.location.href = '/';
            });
    }

    // Store active link in localStorage
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            localStorage.setItem('activeLink', this.dataset.page);
        });
    });

    // Add ripple effect to buttons
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.ripple');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Create ripple element
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                // Style the ripple
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple-effect');

                // Add ripple styles if not already in CSS
                if (!document.querySelector('#ripple-styles')) {
                    const style = document.createElement('style');
                    style.id = 'ripple-styles';
                    style.textContent = `
                        .ripple-effect {
                            position: absolute;
                            border-radius: 50%;
                            background: rgba(255, 255, 255, 0.5);
                            transform: scale(0);
                            animation: ripple-animation 0.6s ease-out;
                            pointer-events: none;
                        }
                        @keyframes ripple-animation {
                            to {
                                transform: scale(4);
                                opacity: 0;
                            }
                        }
                    `;
                    document.head.appendChild(style);
                }

                // Remove any existing ripples
                const existingRipple = this.querySelector('.ripple-effect');
                if (existingRipple) {
                    existingRipple.remove();
                }

                // Add ripple to button
                this.appendChild(ripple);

                // Remove ripple after animation completes
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Restore active state on page load
        const activeLink = localStorage.getItem('activeLink');
        if (activeLink) {
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.dataset.page === activeLink) {
                    link.classList.add('active-link');
                } else {
                    link.classList.remove('active-link');
                }
            });
        }

        const activeMenu = localStorage.getItem('activeMenu');
        if (activeMenu) {
            const dropdown = document.getElementById(activeMenu + 'Dropdown');
            const icon = document.getElementById(activeMenu + 'DropdownIcon');
            if (dropdown) {
                dropdown.classList.remove('hidden');
                dropdown.classList.add('open');
            }
            if (icon) {
                icon.classList.add('rotate-180');
            }
        }
    });
</script>
