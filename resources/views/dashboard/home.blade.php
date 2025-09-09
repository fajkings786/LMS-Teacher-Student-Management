@extends('layouts.dashboard')

@section('title', 'Dashboard Home')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Welcome, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-700 mb-6">Select options from sidebar to see details.</p>

    <!-- Your cards/graphs here -->
    <!-- Main Content -->
    <main class="flex-1 ml-64 p-6 overflow-y-auto h-screen">

        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Welcome, {{ $user->name }}!</h1>
        <p class="text-gray-700 dark:text-gray-200 mb-6">Select options from sidebar to see details.</p>

        <!-- Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex items-center gap-4">
                <i class="fas fa-users text-3xl text-blue-500"></i>
                <div>
                    <p class="text-gray-500 text-sm">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800">120</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex items-center gap-4">
                <i class="fas fa-book text-3xl text-green-500"></i>
                <div>
                    <p class="text-gray-500 text-sm">Courses</p>
                    <p class="text-2xl font-bold text-gray-800">35</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex items-center gap-4">
                <i class="fas fa-chart-line text-3xl text-indigo-500"></i>
                <div>
                    <p class="text-gray-500 text-sm">Sales</p>
                    <p class="text-2xl font-bold text-gray-800">$8,540</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition flex items-center gap-4">
                <i class="fas fa-tasks text-3xl text-yellow-500"></i>
                <div>
                    <p class="text-gray-500 text-sm">Tasks</p>
                    <p class="text-2xl font-bold text-gray-800">18</p>
                </div>
            </div>
        </div>

        <!-- Graphs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Sales Overview</h2>
                <canvas id="salesChart" class="w-full"></canvas>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Users Growth</h2>
                <canvas id="usersChart" class="w-full"></canvas>
            </div>
        </div>

    </main>

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const icon = document.getElementById(id + "Icon");
            dropdown.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // Chart.js
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [1200, 1900, 3000, 2500, 4000, 4500],
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79,70,229,0.2)',
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const usersCtx = document.getElementById('usersChart').getContext('2d');
        const usersChart = new Chart(usersCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Users',
                    data: [10, 25, 15, 30, 20, 35],
                    backgroundColor: '#10B981'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

@endsection
