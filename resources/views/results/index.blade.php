@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .card-header a {
            background: #fff;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .card-header a:hover {
            background: #f0f2f5;
            transform: scale(1.05);
        }

        .card-body {
            padding: 25px;
        }

        .alert {
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #eaf9f0;
            color: #1e824c;
            border: 1px solid #b7e0c0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            margin-top: 10px;
        }

        thead {
            background: #222;
            color: #fff;
        }

        th,
        td {
            padding: 14px 12px;
            text-align: center;
        }

        tbody tr {
            transition: 0.2s;
        }

        tbody tr:hover {
            background: #f7faff;
            transform: scale(1.01);
        }

        .fw-semibold {
            font-weight: 600;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
        }

        .bg-success {
            background: #28a745;
        }

        .bg-primary {
            background: #007bff;
        }

        .bg-info {
            background: #17a2b8;
        }

        .bg-warning {
            background: #ffc107;
            color: #222;
        }

        .bg-danger {
            background: #dc3545;
        }

        .text-muted {
            color: #888;
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th> Student</th>
                                <th> Subject</th>
                                <th> Marks</th>
                                <th> Total Marks</th>
                                <th> Grade</th>
                                <th> Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $result)
                                <tr>
                                    <td class="fw-semibold">{{ $result->student->name }}</td>
                                    <td>{{ $result->subject }}</td>
                                    <td><span class="badge bg-success">{{ $result->marks }}</span></td>
                                    <td>{{ $result->total_marks }}</td>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($result->grade == 'A') bg-primary
                                            @elseif($result->grade == 'B') bg-info
                                            @elseif($result->grade == 'C') bg-warning
                                            @else bg-danger @endif">
                                            {{ $result->grade }}
                                        </span>
                                    </td>
                                    <td>{{ $result->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted">🚫 No results found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
