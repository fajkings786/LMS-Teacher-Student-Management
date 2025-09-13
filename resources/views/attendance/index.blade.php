@extends('layouts.app')
@section('content')
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --secondary-color: #f59e0b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --light-bg: #f9fafb;
            --white: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 20px 0;
        }

        .attendance-container {
            max-width: 700px;
            position: relative;
            left: 100px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .attendance-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .attendance-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: pulse 15s infinite ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(0.8); opacity: 0.5; }
        }

        .attendance-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .attendance-header h1::before {
            content: "📌";
            margin-right: 10px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 16px 20px;
            border-radius: 12px;
            margin: 20px;
            display: flex;
            align-items: center;
            box-shadow: var(--shadow);
            border-left: 5px solid var(--success-color);
        }

        .alert-success::before {
            content: "✓";
            background: var(--success-color);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-weight: bold;
        }

        .table-container {
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        thead {
            background: var(--primary-color);
            color: var(--white);
        }

        thead th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--border-color);
        }

        tbody tr:hover {
            background-color: rgba(79, 70, 229, 0.05);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 16px;
            font-size: 15px;
            color: var(--text-primary);
        }

        select {
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            background: var(--white);
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 160px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: var(--light-bg);
            border-top: 1px solid var(--border-color);
        }

        .mark-all-buttons {
            display: flex;
            gap: 10px;
        }

        .mark-all-buttons button {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .mark-all-buttons button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .mark-all-buttons .present {
            background: var(--success-color);
        }

        .mark-all-buttons .absent {
            background: var(--danger-color);
        }

        .mark-all-buttons .leave {
            background: var(--secondary-color);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(79, 70, 229, 0.4);
        }

        .btn-submit::before {
            content: "✔";
            margin-right: 8px;
        }

        .status-label {
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 14px;
        }

        .status-present {
            color: var(--success-color);
            background: rgba(16, 185, 129, 0.1);
        }

        .status-absent {
            color: var(--danger-color);
            background: rgba(239, 68, 68, 0.1);
        }

        .status-leave {
            color: var(--secondary-color);
            background: rgba(245, 158, 11, 0.1);
        }

        .export-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .export-buttons a {
            padding: 10px 18px;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .export-buttons a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .export-buttons a.pdf {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        }

        .export-buttons a.pdf::before {
            content: "📄";
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .attendance-header h1 {
                font-size: 24px;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 15px;
            }
            
            .mark-all-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .export-buttons {
                justify-content: center;
            }
            
            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 12px 8px;
            }
        }
    </style>

    <div class="attendance-container">
        <div class="attendance-header">
            <h1>Student Attendance</h1>
        </div>
        
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if ($user->role == 'Admin' || $user->role == 'Teacher')
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf
        @endif
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $att)
                        <tr>
                            <td>{{ $att->date }}</td>
                            <td>{{ $att->student->name }}</td>
                            <td>{{ $att->student->email }}</td>
                            @if ($user->role == 'Admin' || $user->role == 'Teacher')
                                <td>
                                    <input type="hidden" name="attendance[{{ $att->id }}][id]" value="{{ $att->id }}">
                                    <select name="attendance[{{ $att->id }}][status]">
                                        <option value="present" {{ $att->status == 'present' ? 'selected' : '' }}>Present</option>
                                        <option value="absent" {{ $att->status == 'absent' ? 'selected' : '' }}>Absent</option>
                                        <option value="leave" {{ $att->status == 'leave' ? 'selected' : '' }}>Leave</option>
                                    </select>
                                </td>
                            @else
                                <td>
                                    <span class="status-label {{ $att->status == 'present' ? 'status-present' : '' }} {{ $att->status == 'absent' ? 'status-absent' : '' }} {{ $att->status == 'leave' ? 'status-leave' : '' }}">
                                        {{ ucfirst($att->status) }}
                                    </span>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="action-buttons">
            <div class="mark-all-buttons">
                @if ($user->role == 'Admin' || $user->role == 'Teacher')
                    <button type="button" class="present" onclick="markAll('present')">Mark All Present</button>
                    <button type="button" class="absent" onclick="markAll('absent')">Mark All Absent</button>
                    <button type="button" class="leave" onclick="markAll('leave')">Mark All Leave</button>
                @endif
            </div>
            
            <div class="export-buttons">
                <a href="{{ route('attendance.export.pdf') }}" class="pdf">Export PDF</a>
            </div>
        </div>
        
        @if ($user->role == 'Admin' || $user->role == 'Teacher')
            <div style="padding: 0 20px 20px; text-align: right;">
                <button type="submit" class="btn-submit">Submit Attendance</button>
            </div>
            </form>
        @endif
    </div>
    
    <script>
        function markAll(status) {
            document.querySelectorAll("select[name^='attendance']").forEach(el => {
                el.value = status;
            });
        }
    </script>
@endsection