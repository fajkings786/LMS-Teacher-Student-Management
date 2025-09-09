<a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-gray-700 transition rounded-lg">
    <i class="fas fa-tachometer-alt text-gray-300 w-5"></i>
    <span>Dashboard</span>
</a>

@if (auth()->user()->role == 'Admin')
    <div class="px-6 py-2">
        <button onclick="toggleDropdown('usersDropdown')"
            class="flex items-center justify-between w-full hover:bg-gray-700 px-3 py-2 rounded-lg transition">
            <span class="flex items-center gap-3"><i class="fas fa-users text-gray-300 w-5"></i> Users</span>
            <i id="usersDropdownIcon" class="fas fa-chevron-down transition-transform"></i>
        </button>
        <div id="usersDropdown" class="hidden flex-col mt-2 ml-6">
            <a href="{{ route('admin.pendingUsers') }}"
                class="block px-3 py-2 text-gray-300 hover:bg-gray-600 rounded-lg transition">Pending Users</a>
            <a href="{{ route('ApprovedUsers') }}"
                class="block px-3 py-2 text-gray-300 hover:bg-gray-600 rounded-lg transition">Approved Users</a>
        </div>
    </div>
@endif

<a href="{{ route('attendance.index') }}"
    class="flex items-center gap-3 px-6 py-3 hover:bg-gray-700 transition rounded-lg">
    <i class="fas fa-book text-gray-300 w-5"></i> Attendance
</a>
