@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f9;
        }

        .attendance-container {
            max-width: 1000px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .attendance-container h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        .alert-success {
            background: #e9f9ee;
            color: #2e7d32;
            padding: 12px 18px;
            border-left: 5px solid #2e7d32;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background: #34495e;
            color: #fff;
        }

        thead th {
            text-align: left;
            padding: 14px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tbody tr {
            border-bottom: 1px solid #e6e6e6;
            transition: background 0.3s;
        }

        tbody tr:hover {
            background: #f9f9f9;
        }

        td {
            padding: 14px;
            font-size: 15px;
            color: #333;
        }

        select {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            background: #fff;
            cursor: pointer;
            transition: border 0.2s;
        }

        select:focus {
            outline: none;
            border-color: #2980b9;
        }

        .btn-submit {
            margin-top: 20px;
            background: #2980b9;
            color: #fff;
            border: none;
            padding: 12px 28px;
            font-size: 15px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s, transform 0.2s;
            display: block;
            margin-left: auto;
        }

        .btn-submit:hover {
            background: #1c5980;
            transform: scale(1.03);
        }

        .status-label {
            font-weight: 600;
            padding: 6px 10px;
            border-radius: 6px;
        }

        .status-present {
            color: #2e7d32;
            background: #eaf7ea;
        }

        .status-absent {
            color: #c62828;
            background: #fdecea;
        }

        .status-leave {
            color: #f57c00;
            background: #fff3e0;
        }

        .export-buttons a {
            margin-right: 10px;
            padding: 8px 15px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .export-buttons a.csv {
            background: green;
        }

        .export-buttons a.pdf {
            background: red;
        }

        .mark-all-buttons button {
            margin-right: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        .mark-all-buttons .present {
            background: #2e7d32;
        }

        .mark-all-buttons .absent {
            background: #c62828;
        }

        .mark-all-buttons .leave {
            background: #f57c00;
        }
    </style>

    <div class="attendance-container">
        <h1>📌 Student Attendance</h1>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($user->role == 'Admin' || $user->role == 'Teacher')
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf

                <!-- Mark All Buttons -->
                <div class="mark-all-buttons" style="margin-bottom:15px;">
                    <button type="button" class="present" onclick="markAll('present')">Mark All Present</button>
                    <button type="button" class="absent" onclick="markAll('absent')">Mark All Absent</button>
                    <button type="button" class="leave" onclick="markAll('leave')">Mark All Leave</button>
                </div>
        @endif

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
                                <!-- Har row ka unique attendance_id bhejna -->
                                <input type="hidden" name="attendance[{{ $att->id }}][id]"
                                    value="{{ $att->id }}">
                                <select name="attendance[{{ $att->id }}][status]">
                                    <option value="present" {{ $att->status == 'present' ? 'selected' : '' }}>Present
                                    </option>
                                    <option value="absent" {{ $att->status == 'absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="leave" {{ $att->status == 'leave' ? 'selected' : '' }}>Leave</option>
                                </select>
                            </td>
                        @else
                            <td>
                                <span
                                    class="status-label 
                        {{ $att->status == 'present' ? 'status-present' : '' }}
                        {{ $att->status == 'absent' ? 'status-absent' : '' }}
                        {{ $att->status == 'leave' ? 'status-leave' : '' }}">
                                    {{ ucfirst($att->status) }}
                                </span>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>

        </table>

        <div class="export-buttons" style="text-align:right; margin:15px 0;">
            <a href="{{ route('attendance.export.pdf') }}" class="pdf">📄 Export PDF</a>
        </div>

        @if ($user->role == 'Admin' || $user->role == 'Teacher')
            <button type="submit" class="btn-submit">✔ Submit Attendance</button>
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
