@extends('layouts.app')
@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .main-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .content-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 90%;
            max-width: 1200px;
            margin-left: 2rem;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
        }

        .content-card:hover {
            box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.15), 0 15px 15px -5px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-title {
            display: flex;
            align-items: center;
            font-size: 1.875rem;
            font-weight: 700;
            color: #1e293b;
        }

        .header-icon {
            height: 2.5rem;
            width: 2.5rem;
            margin-right: 0.75rem;
            color: #6366f1;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        }

        .pending-btn {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
            font-weight: 500;
        }

        .pending-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -1px rgba(99, 102, 241, 0.4);
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }

        .success-alert {
            background: linear-gradient(to right, #d1fae5, #a7f3d0);
            border-left: 4px solid #10b981;
            color: #065f46;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
            animation: fadeIn 0.5s ease-out;
        }

        .success-icon {
            height: 1.25rem;
            width: 1.25rem;
            margin-right: 0.5rem;
            color: #10b981;
        }

        .table-container {
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-header {
            background: linear-gradient(to right, #f8fafc, #f1f5f9);
        }

        .table-header th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background-color: #f8fafc;
        }

        .table-row td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            height: 2.5rem;
            width: 2.5rem;
            border-radius: 9999px;
            background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4338ca;
            font-weight: 600;
            margin-right: 1rem;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: #1e293b;
        }

        .user-id {
            font-size: 0.875rem;
            color: #64748b;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .role-admin {
            background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
            color: #6b21a8;
            box-shadow: 0 2px 4px -1px rgba(139, 92, 246, 0.2);
        }

        .role-teacher {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            box-shadow: 0 2px 4px -1px rgba(59, 130, 246, 0.2);
        }

        .role-student {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            box-shadow: 0 2px 4px -1px rgba(16, 185, 129, 0.2);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-approved {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            box-shadow: 0 2px 4px -1px rgba(16, 185, 129, 0.2);
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            box-shadow: 0 2px 4px -1px rgba(245, 158, 11, 0.2);
        }

        .status-indicator {
            height: 0.5rem;
            width: 0.5rem;
            border-radius: 9999px;
            margin-right: 0.25rem;
        }

        .status-approved .status-indicator {
            background: #10b981;
        }

        .status-pending .status-indicator {
            background: #f59e0b;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .edit-btn {
            color: #4f46e5;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .edit-btn:hover {
            color: #3730a3;
            transform: translateY(-1px);
        }

        .delete-btn {
            color: #ef4444;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            font-weight: 500;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .delete-btn:hover {
            color: #dc2626;
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
        }

        .empty-icon {
            height: 3rem;
            width: 3rem;
            margin: 0 auto 1rem;
            color: #cbd5e1;
        }

        .empty-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .empty-text {
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .empty-btn {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
            font-weight: 500;
        }

        .empty-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -1px rgba(99, 102, 241, 0.4);
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .content-card {
                margin-left: 0;
                width: 100%;
            }

            .main-container {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-container {
                overflow-x: auto;
            }

            .action-buttons {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="main-container">
        <div class="content-card">
            <div class="header">
                <h2 class="header-title">
                    <div class="header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    Manage Users
                </h2>
                <a href="{{ route('admin.pendingUsers') }}" class="pending-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0S3.77 2.667 3 4l-3.732 8A2 2 0 005.094 16z" />
                    </svg>
                    Pending Users
                </a>
            </div>

            @if (session('success'))
                <div class="success-alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="success-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-container">
                <table class="data-table">
                    <thead class="table-header">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="table-row">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">{{ $user->name }}</div>
                                            <div class="user-id">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td>
                                    <span
                                        class="role-badge 
                                        {{ $user->role === 'Admin' ? 'role-admin' : ($user->role === 'Teacher' ? 'role-teacher' : 'role-student') }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="status-badge 
                                        {{ $user->status === 'approved' ? 'status-approved' : 'status-pending' }}">
                                        <span class="status-indicator"></span>
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="edit-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                                class="delete-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($users->isEmpty())
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" class="empty-icon" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="empty-title">No users</h3>
                    <p class="empty-text">Get started by creating a new user.</p>
                    <div>
                        <a href="{{ route('admin.pendingUsers') }}" class="empty-btn">
                            View Pending Users
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
