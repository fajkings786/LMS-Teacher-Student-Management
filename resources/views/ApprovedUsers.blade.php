@extends('layouts.app')
@section('content')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #f6f8fa, #e9eff5);
            margin: 0;
            padding-top: 70px;
            /* space for navbar */
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            padding: 15px 30px;
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            /* z-index: 1000; */
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 6px;
            background-color: rgba(255, 255, 255, 0.2);
            transition: background 0.3s;
        }

        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }

        /* Table styling */
        .table-container {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 90%;
            max-width: 900px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        thead {
            background: linear-gradient(90deg, #667eea, #764ba2);
            color: #fff;
        }

        th,
        td {
            padding: 15px 20px;
            text-align: left;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        th {
            cursor: pointer;
            position: relative;
        }

        th:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        tr {
            transition: all 0.2s ease;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f5ff;
            transform: scale(1.01);
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            display: inline-block;
            min-width: 70px;
        }

        .active {
            background-color: #28a745;
            color: #fff;
        }

        .inactive {
            background-color: #dc3545;
            color: #fff;
        }

        .pending {
            background-color: #ffc107;
            color: #000;
        }

        a.back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #fff;
            background-color: #667eea;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        a.back-btn:hover {
            background-color: #5a67d8;
        }

        @media (max-width: 600px) {

            table,
            th,
            td {
                font-size: 14px;
            }

            th,
            td {
                padding: 10px 12px;
            }

            .navbar h1 {
                font-size: 20px;
            }
        }
    </style>
    </head>

    <body>

        <!-- Navbar -->



        <div class="table-container">
            <table id="userTable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th onclick="sortTable(1)">Email</th>
                        <th onclick="sortTable(2)">Role</th>
                        <th onclick="sortTable(3)">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <span
                                    class="status 
                        {{ strtolower($user->status) === 'active' ? 'active' : (strtolower($user->status) === 'inactive' ? 'inactive' : 'pending') }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            function sortTable(n) {
                let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("userTable");
                switching = true;
                dir = "asc";

                while (switching) {
                    switching = false;
                    rows = table.rows;

                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("TD")[n].innerText.toLowerCase();
                        y = rows[i + 1].getElementsByTagName("TD")[n].innerText.toLowerCase();

                        if (dir == "asc") {
                            if (x > y) {
                                shouldSwitch = true;
                                break;
                            }
                        } else if (dir == "desc") {
                            if (x < y) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount++;
                    } else {
                        if (switchcount == 0 && dir == "asc") {
                            dir = "desc";
                            switching = true;
                        }
                    }
                }
            }
        </script>
    @endsection
