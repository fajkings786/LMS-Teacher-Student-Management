@extends('layouts.app')

@section('content')
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

    <style>
        /* Yahan sirf table aur status ke CSS rakho */
        .table-container {
            display: flex;
            justify-content: center;
            margin-left:200px ;
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
    </style>
@endsection
