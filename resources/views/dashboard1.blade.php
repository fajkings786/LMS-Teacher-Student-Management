    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <style>
            body {
                min-height: 100vh;
                display: flex;
                background-color: #f4f4f4;
                font-family: Arial, sans-serif;
            }

            /* Sidebar */
            .sidebar {
                width: 240px;
                background-color: #4f46e5;
                color: white;
                height: 100vh;
                padding: 20px;
                position: fixed;
                overflow-y: auto;
            }

            .sidebar h2 {
                font-size: 24px;
                margin-bottom: 30px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .sidebar a,
            .sidebar .dropdown-btn {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                color: white;
                text-decoration: none;
                padding: 12px 15px;
                margin: 5px 0;
                border-radius: 6px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .sidebar a:hover,
            .sidebar .dropdown-btn:hover {
                background-color: #6366f1;
            }

            /* Dropdown container (hidden by default) */
            .dropdown-container {
                display: none;
                padding-left: 15px;
                flex-direction: column;
            }

            .dropdown-container a {
                padding: 10px 15px;
                font-size: 14px;
                background-color: #5c4dd3;
                border-radius: 5px;
            }

            .dropdown-container a:hover {
                background-color: #6366f1;
            }

            /* Main content */
            .main {
                margin-left: 260px;
                padding: 30px;
                flex: 1;
            }

            .card-custom {
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s, box-shadow 0.3s;
            }

            .card-custom:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            }

            .logout-btn {
                margin-top: 20px;
                width: 100%;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .btn-icon {
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .fa-caret-down {
                transition: transform 0.3s;
            }

            .fa-caret-down.rotate {
                transform: rotate(180deg);
            }
        </style>
    </head>

    <body>
        <!-- Sidebar -->
        <div class="sidebar">
            <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
            <a href="#"><i class="fas fa-home"></i> Home</a>

            <!-- Users Dropdown -->
            <div class="dropdown-btn"><span><i class="fas fa-users"></i> Users</span><i class="fas fa-caret-down"></i></div>
            <div class="dropdown-container">
                <a href="#"><i class="fas fa-user-plus"></i> Add User</a>
                <a href="#"><i class="fas fa-eye"></i> View Users</a>
                <a href="#"><i class="fas fa-user-check"></i> Approved Users</a>
            </div>

            <!-- Courses Dropdown -->
            <div class="dropdown-btn"><span><i class="fas fa-book"></i> Courses</span><i class="fas fa-caret-down"></i>
            </div>
            <div class="dropdown-container">
                <a href="#"><i class="fas fa-plus-circle"></i> Add Course</a>
                <a href="#"><i class="fas fa-eye"></i> View Courses</a>
            </div>

            <!-- Reports Dropdown -->
            <div class="dropdown-btn"><span><i class="fas fa-chart-bar"></i> Reports</span><i class="fas fa-caret-down"></i>
            </div>
            <div class="dropdown-container">
                <a href="#"><i class="fas fa-file-alt"></i> Monthly Report</a>
                <a href="#"><i class="fas fa-file-alt"></i> Yearly Report</a>
            </div>

            <a href="#"><i class="fas fa-cog"></i> Settings</a>
            <a href="#"><i class="fas fa-question-circle"></i> Help</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main">
            <h1 class="mb-4">Welcome, {{ $user->name }}!</h1>

            <div class="row">
                @if ($user->role === 'Admin')
                    <!-- Pending Users Card -->
                    <div class="col-md-3">
                        <div class="card card-custom text-white bg-primary mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title"><i class="fas fa-user-clock"></i> Pending Users</h5>
                                <p class="card-text fs-4">{{ $pendingCount }}</p>
                                <a href="{{ route('admin.pendingUsers') }}" class="btn btn-light btn-sm btn-icon">
                                    <i class="fas fa-eye"></i> View Data
                                </a>
                                <a href="#" class="btn btn-light btn-sm btn-icon mt-1">
                                    <i class="fas fa-ellipsis-h"></i> More
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Approved Users Card -->
                    <div class="col-md-3">
                        <div class="card card-custom text-white bg-success mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title"><i class="fas fa-user-check"></i> Approved Users</h5>
                                <p class="card-text fs-4">{{ $approvedCount }}</p>
                                <a href="#" class="btn btn-light btn-sm btn-icon">
                                    <i class="fas fa-eye"></i> View Data
                                </a>
                                <a href="#" class="btn btn-light btn-sm btn-icon mt-1">
                                    <i class="fas fa-ellipsis-h"></i> More
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            You are logged in as <strong>{{ $user->role }}</strong>. Welcome to your dashboard!
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Dropdown functionality
            const dropdowns = document.querySelectorAll('.dropdown-btn');
            dropdowns.forEach(drop => {
                drop.addEventListener('click', () => {
                    const container = drop.nextElementSibling;
                    container.style.display = container.style.display === 'block' ? 'none' : 'block';
                    // Toggle arrow rotation
                    drop.querySelector('.fa-caret-down').classList.toggle('rotate');
                });
            });
        </script>
    </body>

    </html>
