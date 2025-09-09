@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="calendar-header">
            <button id="prevMonth" class="nav-btn"><i class="fa-solid fa-chevron-left"></i></button>
            <h2 id="monthYear"></h2>
            <button id="nextMonth" class="nav-btn"><i class="fa-solid fa-chevron-right"></i></button>
        </div>

        <div class="weekdays">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>

        <div class="calendar" id="calendar"></div>
    </div>

    <!-- Modal -->
    <div class="modal" id="attendanceModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">×</span>
            <h3 id="modalDate" class="text-xl font-bold mb-3"></h3>
            <div id="attendanceSummary"></div>
        </div>
    </div>

    <style>
        .container {
            max-width: 800px;
            margin: 30px auto;
            font-family: 'Inter', sans-serif;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .nav-btn {
            background: #3b82f6;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .nav-btn:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: bold;
            padding: 10px 0;
            border-bottom: 2px solid #ccc;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-top: 5px;
        }

        .day {
            padding: 15px 0;
            text-align: center;
            border-radius: 8px;
            background: #f4f4f4;
            cursor: pointer;
            transition: all 0.2s;
        }

        .day:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .day.present {
            background: #22c55e;
            color: #fff;
        }

        .day.absent {
            background: #ef4444;
            color: #fff;
        }

        .day.leave {
            background: #f59e0b;
            color: #fff;
        }

        .day.today {
            border: 2px solid #3b82f6;
            font-weight: bold;
            background: #e0f2fe;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        .close-btn {
            float: right;
            cursor: pointer;
            font-weight: bold;
            font-size: 22px;
            color: #ef4444;
        }

        #attendanceSummary p {
            padding: 6px 10px;
            border-bottom: 1px solid #eee;
        }

        #attendanceSummary strong {
            color: #111;
        }
    </style>

    <script>
        const students = @json($students);
        const attendances = @json($attendances);
        const calendarEl = document.getElementById('calendar');
        const modal = document.getElementById('attendanceModal');
        const modalDate = document.getElementById('modalDate');
        const monthYear = document.getElementById('monthYear');

        let currentDate = new Date();

        function generateCalendar(date) {
            const year = date.getFullYear();
            const month = date.getMonth();
            monthYear.innerText = date.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const todayStr = new Date().toISOString().slice(0, 10);

            calendarEl.innerHTML = '';
            for (let i = 0; i < firstDay; i++) calendarEl.innerHTML += `<div></div>`;

            for (let d = 1; d <= daysInMonth; d++) {
                let dateStr = `${year}-${(month+1).toString().padStart(2,'0')}-${d.toString().padStart(2,'0')}`;
                let statusClass = '';
                const attForDay = attendances.filter(a => a.date === dateStr);
                if (attForDay.length > 0) statusClass = attForDay[0].status;

                let todayClass = (dateStr === todayStr) ? 'today' : '';

                calendarEl.innerHTML +=
                    `<div class="day ${statusClass} ${todayClass}" onclick="openModal('${dateStr}')">${d}</div>`;
            }
        }

        function openModal(dateStr) {
            modal.style.display = 'flex';
            modalDate.innerText = 'Attendance Summary for ' + dateStr;

            const attForDay = attendances.filter(a => a.date === dateStr);

            if (attForDay.length === 0) {
                document.getElementById('attendanceSummary').innerHTML = "<p>No attendance recorded.</p>";
                return;
            }

            let presentCount = attForDay.filter(a => a.status === 'present').length;
            let absentCount = attForDay.filter(a => a.status === 'absent').length;
            let leaveCount = attForDay.filter(a => a.status === 'leave').length;

            let summaryHtml = `
                <p><strong>Present:</strong> ${presentCount}</p>
                <p><strong>Absent:</strong> ${absentCount}</p>
                <p><strong>Leave:</strong> ${leaveCount}</p>
                <hr>
                <h4 class="font-bold mt-2 mb-1">Details:</h4>
            `;

            attForDay.forEach(att => {
                let student = students.find(s => s.id === att.student_id);
                summaryHtml += `<p>👤 ${student ? student.name : 'Unknown'} - <strong>${att.status}</strong></p>`;
            });

            document.getElementById('attendanceSummary').innerHTML = summaryHtml;
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar(currentDate);
        });
        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar(currentDate);
        });

        generateCalendar(currentDate);
    </script>
@endsection
