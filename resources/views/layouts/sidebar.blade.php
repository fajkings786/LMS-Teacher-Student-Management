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
                class="px-6 py-5 flex items-center gap-3 profile-card rounded-xl mx-4 mt-5 mb-5 transition-all duration-300">
                <div class="relative">
                    <img class="w-14 h-14 rounded-full object-cover border-2 border-indigo-500"
                        src="{{ auth()->user()->profile_picture
                            ? asset('storage/' . auth()->user()->profile_picture)
                            : 'https://flowbite.com/docs/images/people/profile-picture-5.jpg' }}"
                        alt="User Photo">
                    <div
                        class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 rounded-full border-2 border-gray-800 flex items-center justify-center">
                        <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                    </div>
                </div>
                <div>
                    <h3 class="text-white font-semibold">{{ auth()->user()->name }}</h3>
                    <p class="text-gray-300 text-sm">Role: {{ auth()->user()->role }}</p>
                </div>
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

            @if (auth()->user()->role == 'Student')
                <a href="{{ route('results.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link sidebar-item {{ request()->routeIs('results.index') ? 'active-link' : '' }}"
                    data-page="results">
                    <i class="fas fa-file-alt text-blue-400 sidebar-icon"></i>
                    <span>View Result</span>
                </a>
            @endif

            <!-- Users Dropdown -->
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
                        <!-- Pending Users -->
                        <a href="{{ route('admin.pendingUsers') }}"
                            class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('admin.pendingUsers') ? 'active-link' : '' }}"
                            data-page="pending-users">
                            Pending Users
                        </a>
                        <!-- All Users -->
                        <a href="{{ route('admin.users') }}"
                            class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('admin.users') ? 'active-link' : '' }}"
                            data-page="all-users">
                            All Users
                        </a>
                    </div>
                </div>
            @endif


            <!-- Courses Dropdown -->
            @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Student')
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
                            class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link {{ request()->is('student/lectures') ? 'active-link' : '' }}"
                            data-page="all-courses">
                            All Courses
                        </a>
                        @if (auth()->user()->role == 'Admin')
                            <a href="{{ route('add.course') }}"
                                class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link"
                                data-page="add-course">
                                Add Course
                            </a>
                        @endif
                        <a href="#" class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link"
                            data-page="categories">
                            Categories
                        </a>
                        <a href="{{ route('attendance.index') }}"
                            class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('attendance.index') ? 'active-link' : '' }}"
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
                            class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('attendance.index') ? 'active-link' : '' }}"
                            data-page="all-students">
                            All Students
                        </a>
                        <a href="{{ route('attendance.crite') }}"
                            class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('attendance.crite') ? 'active-link' : '' }}"
                            data-page="crite-area">
                            Total Crite Area
                        </a>
                        <a href="{{ route('attendance.calendar') }}"
                            class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('attendance.calendar') ? 'active-link' : '' }}"
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
                            class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('results.create') ? 'active-link' : '' }}"
                            data-page="add-result">
                            Add Result
                        </a>
                        <a href="{{ route('results.index') }}"
                            class="block px-3 py-2 rounded-lg transition-all duration-300 nav-link {{ request()->routeIs('results.index') ? 'active-link' : '' }}"
                            data-page="all-results">
                            All Results
                        </a>
                    </div>
                </div>
            @endif
        </nav>

        <!-- Logout -->
        <div class="px-6 py-4 border-t border-gray-800 mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="flex items-center gap-3 px-4 py-2 text-white rounded-lg w-full logout-btn shadow-lg">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #4f46e5, #9333ea);
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: #1f2937;
    }

    /* Enhanced Sidebar Styles */
    .sidebar-bg {
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        height: 100% position: relative;
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

    .logout-btn {
        background: linear-gradient(90deg, #ef4444, #dc2626);
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: linear-gradient(90deg, #dc2626, #b91c1c);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
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

    /* Active Menu Highlight */
    .active-link {
        background: linear-gradient(90deg, #4f46e5, #9333ea);
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
</style>

<script>
    // Dropdown Toggle - Close others
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

    // Store active link in localStorage
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            localStorage.setItem('activeLink', this.dataset.page);
        });
    });

    // Restore active state on page load
    window.addEventListener('DOMContentLoaded', () => {
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
