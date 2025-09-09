<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white shadow-lg flex flex-col">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-700">
            <img src="https://flowbite.com/docs/images/logo.svg" alt="Logo" class="h-10">
            <span class="text-xl font-bold">Dashboard</span>
        </div>

        <!-- User Profile -->
        <div
            class="px-6 py-4 flex items-center gap-3 bg-gray-700 rounded-lg mx-3 mt-4 mb-4 hover:bg-gray-600 transition">
            <img class="w-12 h-12 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                alt="User Photo">
            <div>
                <h3 class="text-white font-semibold">{{ auth()->user()->name }}</h3>
                {{-- <p class="text-gray-300 text-sm truncate">{{ auth()->user()->email }}</p> --}}
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-2 flex-1 overflow-y-auto">
            @include('partials.sidebar-links')
        </nav>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-700 mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="flex items-center gap-3 px-4 py-2 bg-red-500 hover:bg-red-600 transition rounded-lg w-full">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-6 overflow-y-auto h-screen">
        @yield('content')
    </main>

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const icon = document.getElementById(id + "Icon");
            dropdown.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>

    @stack('scripts')
</body>

</html>
