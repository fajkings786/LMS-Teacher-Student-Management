<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Attendance Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            background: #f9f9f9;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <h2>📊 Attendance Report</h2>
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $att)
                <tr>
                    <td>{{ $att->student->name }}</td>
                    <td>{{ $att->student->email }}</td>
                    <td>{{ ucfirst($att->status) }}</td>
                    <td>{{ $att->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('d M, Y H:i') }} by Fajkings System
    </div>
</body>

</html>
