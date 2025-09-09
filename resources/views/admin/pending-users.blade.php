@extends('layouts.app')
@section('content')
    <style>
        body {
            font-family: Inter, Arial;
            padding: 24px;
            background: #f6f8fb
        }

        .wrap {
            max-width: 900px;
            margin: 0 auto
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(20, 20, 50, .06)
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #f1f3f8
        }

        th {
            background: #fafafa
        }

        .btn {
            padding: 8px 12px;
            border-radius: 8px;
            border: 0;
            cursor: pointer
        }

        .approve {
            background: #4f46e5;
            color: white
        }

        .reject {
            background: #ef4444;
            color: white
        }

        select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }
    </style>
    </head>

    <body>
        <div class="wrap">
            <h1>Pending Users</h1>

            @if (session('success'))
                <div style="background:#ecfdf5;padding:10px;border-radius:8px;margin-bottom:12px">{{ session('success') }}
                </div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Requested At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendings as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->email }}</td>
                            <td>
                                <form style="display:inline" method="POST" action="{{ route('admin.pending.approve', $p->id) }}">
                                    @csrf
                                    <select name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="Teacher">Teacher</option>
                                        <option value="Student">Student</option>
                                    </select>
                                    <button class="btn approve">Approve</button>
                                </form>
                            </td>
                            <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <form style="display:inline" method="POST"
                                    action="{{ route('admin.pending.reject', $p->id) }}">
                                    @csrf
                                    <button class="btn reject">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No pending users</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endsection
