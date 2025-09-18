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
            min-height: 100vh;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
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
            flex-wrap: wrap;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 180px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            transition: all 0.3s ease;
        }
        
        .stat-icon.pending {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: white;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
        }
        
        .stat-icon.today {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        }
        
        .stat-content h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }
        
        .stat-content p {
            margin: 0;
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
        }
        
        .table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.3s ease;
        }
        
        .table-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 18px 24px;
            text-align: left;
        }
        
        th {
            background: linear-gradient(to right, #f8fafc, #f1f5f9);
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e2e8f0;
        }
        
        td {
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-weight: 500;
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
            gap: 15px;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 8px rgba(99, 102, 241, 0.3);
            transition: transform 0.3s ease;
        }
        
        .user-avatar:hover {
            transform: scale(1.1);
        }
        
        .user-details h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1rem;
            color: #1e293b;
        }
        
        .user-details p {
            margin: 0;
            font-size: 0.85rem;
            color: #64748b;
        }
        
        .role-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            transition: all 0.3s ease;
        }
        
        .role-badge.pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            box-shadow: 0 2px 5px rgba(245, 158, 11, 0.2);
        }
        
        .role-badge.teacher {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #3730a3;
            box-shadow: 0 2px 5px rgba(99, 102, 241, 0.2);
        }
        
        .role-badge.student {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            box-shadow: 0 2px 5px rgba(16, 185, 129, 0.2);
        }
        
        .date {
            font-size: 0.85rem;
            color: #64748b;
        }
        
        .action-form {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .role-select {
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #334155;
            font-size: 0.85rem;
            min-width: 140px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .role-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            outline: none;
        }
        
        .btn {
            padding: 10px 18px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }
        
        .btn.approve {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
        
        .btn.approve:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }
        
        .btn.reject {
            background: linear-gradient(135deg, #ef4444, #f43f5e);
            color: white;
        }
        
        .btn.reject:hover {
            background: linear-gradient(135deg, #dc2626, #e11d48);
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #64748b;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #cbd5e1;
            opacity: 0.7;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            font-size: 1rem;
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .alert {
            padding: 18px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert.success {
            background: linear-gradient(to right, #d1fae5, #a7f3d0);
            color: #065f46;
            border-left: 5px solid #10b981;
        }
        
        .alert-icon {
            font-size: 1.4rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .stats {
                width: 100%;
                justify-content: space-between;
            }
            
            .stat-card {
                min-width: 150px;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            table {
                min-width: 700px;
            }
            
            .action-form {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        
        @media (max-width: 640px) {
            .stats {
                flex-direction: column;
                width: 100%;
            }
            
            .stat-card {
                width: 100%;
            }
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