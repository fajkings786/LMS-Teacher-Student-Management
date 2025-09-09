<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #f4f4f4
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .card {
            display: inline-block;
            width: 200px;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            background: #6366f1;
            color: white;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="card">
            Pending Users: {{ $pendingCount }} <br>
            <a href="{{ route('admin.pendingUsers') }}">View</a>
        </div>
        <div class="card">
            Approved Users: {{ $approvedCount }}
        </div>
    </div>
</body>

</html>
