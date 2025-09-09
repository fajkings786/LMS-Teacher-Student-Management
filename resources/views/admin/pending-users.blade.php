@extends('layouts.app')
@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            padding: 0;
            margin: 0;
        }
        
        .main-content {
            margin-left: 288px; /* w-72 = 18rem = 288px */
            padding: 24px;
            position: relative;
            
            /* min-height: 100vh; */
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            position: relative;
            padding-left: 15px;
        }
        
        h1::before {
            content: '';
            position: absolute;
            left: 0;
            top: 8px;
            height: 70%;
            width: 5px;
            background: linear-gradient(to bottom, #6366f1, #8b5cf6);
            border-radius: 4px;
        }
        
        .stats {
            display: flex;
            gap: 20px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 15px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 150px;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .stat-icon.pending {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }
        
        .stat-icon.today {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        
        .stat-content h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
        }
        
        .stat-content p {
            margin: 0;
            font-size: 0.85rem;
            color: #64748b;
        }
        
        .table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 16px 20px;
            text-align: left;
        }
        
        th {
            background: #f8fafc;
            font-weight: 600;
            color: #475569;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        td {
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover {
            background: #f8fafc;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .user-details h4 {
            margin: 0;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .user-details p {
            margin: 0;
            font-size: 0.8rem;
            color: #64748b;
        }
        
        .role-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .role-badge.pending {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }
        
        .role-badge.teacher {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
        }
        
        .role-badge.student {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        
        .date {
            font-size: 0.85rem;
            color: #64748b;
        }
        
        .action-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .role-select {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #334155;
            font-size: 0.85rem;
            min-width: 120px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn.approve {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
        
        .btn.reject {
            background: linear-gradient(135deg, #ef4444, #f43f5e);
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }
        
        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #cbd5e1;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert.success {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-left: 4px solid #10b981;
        }
        
        .alert-icon {
            font-size: 1.2rem;
        }
    </style>
    
    <div class="main-content">
        <div class="header">
            <h1>Pending Users</h1>
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $pendings->count() }}</h3>
                        <p>Pending Users</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon today">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $pendings->where('created_at', '>=', today())->count() }}</h3>
                        <p>Today</p>
                    </div>
                </div>
            </div>
        </div>
        
        @if (session('success'))
            <div class="alert success">
                <i class="fas fa-check-circle alert-icon"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Requested At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendings as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($p->name, 0, 1)) }}
                                    </div>
                                    <div class="user-details">
                                        <h4>{{ $p->name }}</h4>
                                        <p>{{ $p->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="role-badge pending">Pending</span>
                            </td>
                            <td>
                                <div class="date">{{ $p->created_at->format('d M Y') }}</div>
                                <div class="date">{{ $p->created_at->format('H:i A') }}</div>
                            </td>
                            <td>
                                <div class="action-form">
                                    <form style="display:inline" method="POST" action="{{ route('admin.pending.approve', $p->id) }}">
                                        @csrf
                                        <select name="role" class="role-select" required>
                                            <option value="">Select Role</option>
                                            <option value="Teacher">Teacher</option>
                                            <option value="Student">Student</option>
                                        </select>
                                        <button type="submit" class="btn approve">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form style="display:inline" method="POST" action="{{ route('admin.pending.reject', $p->id) }}">
                                        @csrf
                                        <button type="submit" class="btn reject">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <h3>No pending users</h3>
                                    <p>All user requests have been processed.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection