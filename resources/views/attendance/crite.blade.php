@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">Attendance Dashboard & Result Management</h1>

        <!-- Class Summary -->
        <div class="result-summary">
            <h2>Class Attendance Summary</h2>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Total Students</th>
                        <th>Total Present Today</th>
                        <th>Total Absent Today</th>
                        <th>Total Leave Today</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalStudents = $students->count();
                        $today = now()->format('Y-m-d');
                        $presentToday = $attendances->where('date', $today)->where('status', 'present')->count();
                        $absentToday = $attendances->where('date', $today)->where('status', 'absent')->count();
                        $leaveToday = $attendances->where('date', $today)->where('status', 'leave')->count();
                    @endphp
                    <tr>
                        <td>{{ $totalStudents }}</td>
                        <td>{{ $presentToday }}</td>
                        <td>{{ $absentToday }}</td>
                        <td>{{ $leaveToday }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Average Attendance Graph -->
            <div class="chart-box">
                <h3>📊 Attendance Overview</h3>
                <canvas id="summaryChart"></canvas>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="attendance-card">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $att)
                        <tr>
                            <td>{{ $att->student->name }}</td>
                            <td>{{ $att->student->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                            <td>
                                @if ($att->status == 'present')
                                    <span class="status present">Present</span>
                                @elseif($att->status == 'absent')
                                    <span class="status absent">Absent</span>
                                @else
                                    <span class="status leave">Leave</span>
                                @endif
                            </td>
                            <td>
                                <button class="view-btn" onclick="showChart()">View</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 92%;
            max-width: 1000px;
            margin: 40px auto;
        }

        .title {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center;
            color: #4f46e5;
        }

        .attendance-card,
        .result-summary {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
            margin-bottom: 30px;
            padding: 25px;
        }

        .summary-table,
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .summary-table th,
        .attendance-table th {
            background: #f1f5f9;
            padding: 12px 15px;
            font-weight: 600;
            text-align: center;
        }

        .summary-table td,
        .attendance-table td {
            padding: 12px 15px;
            text-align: center;
        }

        .attendance-table tr:nth-child(even),
        .summary-table tr:nth-child(even) {
            background: #fafafa;
        }

        .status {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 13px;
            color: #fff;
        }

        .status.present {
            background: #3b82f6;
        }

        .status.absent {
            background: #ef4444;
        }

        .status.leave {
            background: #fbbf24;
            color: #111;
        }

        .view-btn {
            padding: 6px 12px;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .view-btn:hover {
            background: #4338ca;
            transform: scale(1.05);
        }

        .chart-box {
            text-align: center;
            margin-top: 20px;
        }

        .chart-box h3 {
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #374151;
        }

        #summaryChart {
            max-width: 350px;
            margin: 0 auto;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Summary Chart Data
        const present = {{ $presentToday }};
        const absent = {{ $absentToday }};
        const leave = {{ $leaveToday }};

        const ctxSummary = document.getElementById('summaryChart').getContext('2d');
        new Chart(ctxSummary, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Leave'],
                datasets: [{
                    data: [present, absent, leave],
                    backgroundColor: ['#3b82f6', '#ef4444', '#fbbf24'],
                    borderWidth: 2,
                    borderColor: "#fff"
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
