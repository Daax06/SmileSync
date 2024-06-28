<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Web Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto Condensed', sans-serif;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding-top: 70px; /* Add padding-top to make space for the fixed header */
        }
        header {
            background-color: #2196F3; /* Blue theme */
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            background-color: rgba(203, 211, 255, 0.555);
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            height: 450px;
            display: flex;
            justify-content: space-between;
        }
        .column {
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .column:nth-child(1) {
            flex: 0 0 20%;
        }
        .column:nth-child(2) {
            flex: 0 0 55%;
        }
        .column:nth-child(3) {
            flex: 0 0 25%;
        }
        .column:not(:last-child) {
            border-right: 1px solid #ddd;
        }
        .time-buttons {
            text-align: center;
            margin-top: 20px; /* Adjusted margin */
        }
        .time-buttons h2 {
            margin-bottom: 10px;
        }
        .time-buttons button {
            display: block;
            margin: 5px auto;
            padding: 8px 10px; /* Adjusted padding */
            width: 90px; /* Adjusted width */
            background-color: #2196F3; /* Blue theme */
            color: white;
            border: none;
            border-radius: 20px; /* Rounded edges */
            cursor: pointer;
        }
        .time-buttons button:hover {
            background-color: #1976D2; /* Darker shade of blue on hover */
        }
        .calendar {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 10px;
            align-items: center;
        }
        .calendar-header button {
            background-color: #2196F3; /* Blue theme */
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 20px; /* Rounded edges */
        }
        .calendar-header button:hover {
            background-color: #1976D2; /* Darker shade of blue on hover */
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            width: 100%;
        }
        .calendar-grid .calendar-day {
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc; /* Clear lines */
            cursor: pointer;
        }
        .calendar-grid .calendar-day:hover {
            background-color: #e0e0e0; /* Lighter shade on hover */
        }
        .calendar-grid .calendar-day.selected {
            background-color: #2196F3; /* Selected color */
            color: white;
        }
        #header {
            background-color: #59B0CC;
            color: #fff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1;
            position: fixed;
            width: 100%;
            top: 0;
        }

        #header h1 {
            margin: 0;
            font-size: 24px;
            text-shadow: 2px 2px 4px #000;
            position: relative;
            left: -10px;
        }

        #nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            margin-right: 200px;
        }

        #nav ul li {
            display: inline;
            margin-left: 20px;
        }

        #nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            text-shadow: 2px 2px 4px #000;
        }

        #nav ul li a:hover {
            text-decoration: underline;
        }

        .thin-header {
            height: 50px;
            padding: 10px 0;
            transition: height 0.3s ease;
        }
    </style>
</head>
<body>
    <header id="header">
        <h1>SmileSync</h1>
        <nav id="nav">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="patient_form.php">Patient Page</a></li>
                <li><a href="scheduling.php">Scheduling</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="column">
            <h2>Welcome to SmileSync Appointment Setting</h2>
            <p>blah blah blah dito instructions pano mag pa sched paras a mga tanga</p>
        </div>
        <div class="column">
            <div class="calendar">
                <div class="calendar-header">
                    <button id="prevMonth">Previous</button>
                    <div id="monthYear"></div>
                    <button id="nextMonth">Next</button>
                </div>
                <div class="calendar-grid" id="calendarGrid"></div>
            </div>
        </div>
        <div class="column">
            <div class="time-buttons">
                <h2>Time Available</h2>
                <button>9:00 AM</button>
                <button>10:00 AM</button>
                <button>11:00 AM</button>
                <button>12:00 PM</button>
                <button>1:00 PM</button>
                <button>2:00 PM</button>
                <button>3:00 PM</button>
                <button>4:00 PM</button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const monthYear = document.getElementById('monthYear');
            const calendarGrid = document.getElementById('calendarGrid');
            let currentMonth = new Date().getMonth(); // Set to current month (June is 5 because months are zero-indexed)
            let currentYear = new Date().getFullYear();

            function generateCalendar(month, year) {
                calendarGrid.innerHTML = '';
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const startDay = new Date(year, month, 1).getDay();

                monthYear.innerText = ${monthNames[month]} ${year};

                for (let i = 0; i < startDay; i++) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.classList.add('calendar-day');
                    calendarGrid.appendChild(emptyDiv);
                }

                for (let i = 1; i <= daysInMonth; i++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.classListA.add('calendar-day');
                    dayDiv.innerText = i;
                    dayDiv.addEventListener('click', () => {
                        // Add your selection logic here
                        dayDiv.classList.toggle('selected');
                    });
                    calendarGrid.appendChild(dayDiv);
                }
            }

            document.getElementById('prevMonth').addEventListener('click', () => {
                if (currentMonth > new Date().getMonth() - 1) {
                    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
                    currentYear = (currentMonth === 11) ? currentYear - 1 : currentYear;
                    generateCalendar(currentMonth, currentYear);
                }
            });

            document.getElementById('nextMonth').addEventListener('click', () => {
                currentMonth = (currentMonth === 11) ? 0 : currentMonth + 1;
                currentYear = (currentMonth === 0) ? currentYear + 1 : currentYear;
                generateCalendar(currentMonth, currentYear);
            });

            generateCalendar(currentMonth, currentYear);
        });
    </script>
</body>
</html>