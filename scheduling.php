<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "patient_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available dates and times
$available_dates = [];
$available_times = ["9:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM"];

$sql = "SELECT DISTINCT date FROM appointments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $available_dates[] = $row['date'];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize input
    $selected_date = isset($_POST['selected_date']) ? htmlspecialchars($_POST['selected_date']) : null;
    $selected_time = isset($_POST['selected_time']) ? htmlspecialchars($_POST['selected_time']) : null;

    if ($selected_date && $selected_time) {
        // Prepare SQL statement to insert data into appointments table
        $sql = "INSERT INTO appointments (date, time) VALUES ('$selected_date', '$selected_time')";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            session_start();
            $_SESSION['appointment'] = [
                'date' => $selected_date,
                'time' => $selected_time
            ];
            header("Location: confirmation.php"); // Redirect to confirmation page
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmileSync - Dental Appointment Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        header {
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
        header h1 {
            margin: 0;
            font-size: 24px;
            text-shadow: 2px 2px 4px #000;
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
        .appointment-container {
            background-color: rgba(203, 211, 255, 0.555);
            margin: 100px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            display: flex;
            justify-content: space-between;
        }
        .title-column {
            flex: 0 0 20%;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .title-column h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .calendar {
            flex: 0 0 55%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .calendar h3 {
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        .calendar table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .calendar th,
        .calendar td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }
        .calendar th {
            background-color: #f2f2f2;
        }
        .calendar td {
            cursor: pointer;
        }
        .calendar td.booked {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
        }
        .calendar td.selected {
            background-color: #4CAF50;
            color: white;
        }
        .time-slots {
            flex: 0 0 25%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .time-slot {
            margin-bottom: 10px;
            padding: 10px;
            width: 80px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
        .time-slot.disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .time-slot.selected {
            background-color: #4CAF50;
            color: white;
        }
        #appointment-form {
            margin-top: 20px;
        }
        #appointment-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #59B0CC;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        #appointment-form input[type="submit"]:hover {
            background-color: #4F96AB;
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

    <div class="appointment-container">
        <div class="title-column">
            <h1>SmileSync - Dental Appointment Booking</h1>
            <p>Select a date and time for your appointment:</p>
        </div>
        
        <div class="calendar">
            <div class="calendar-header">
                <button id="prevMonth">Previous</button>
                <div id="monthYear"></div>
                <button id="nextMonth">Next</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                </tbody>
            </table>
        </div>
        
        <div class="time-slots">
            <?php
            // Generate time slots buttons
            foreach ($available_times as $time) {
                echo '<button class="time-slot" data-time="' . $time . '">' . $time . '</button>';
            }
            ?>
        </div>
        
        <form id="appointment-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" id="selected-date" name="selected_date">
            <input type="hidden" id="selected-time" name="selected_time">
            <input type="submit" value="Book Appointment" disabled>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarBody = document.getElementById('calendar-body');
            const monthYear = document.getElementById('monthYear');
            const timeSlots = document.querySelectorAll('.time-slot');
            let currentMonth = new Date().getMonth(); // Current month (0-11)
            let currentYear = new Date().getFullYear();

            const availableDates = <?php echo json_encode($available_dates); ?>;
            const availableTimes = <?php echo json_encode($available_times); ?>;

            function generateCalendar(month, year) {
                // Display current month and year
                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                monthYear.innerText = monthNames[month] + ' ' + year;

                // Clear previous calendar
                calendarBody.innerHTML = '';

                // Get the first day of the month
                const firstDay = new Date(year, month).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Create calendar cells
                let date = 1;
                for (let i = 0; i < 6; i++) {
                    let row = document.createElement('tr');

                    for (let j = 0; j < 7; j++) {
                        if (i === 0 && j < firstDay) {
                            let cell = document.createElement('td');
                            cell.appendChild(document.createTextNode(''));
                            row.appendChild(cell);
                        } else if (date > daysInMonth) {
                            break;
                        } else {
                            let cell = document.createElement('td');
                            let cellText = document.createTextNode(date);
                            cell.appendChild(cellText);

                            const fullDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;

                            if (availableDates.includes(fullDate)) {
                                cell.classList.add('available');
                                cell.addEventListener('click', function() {
                                    document.querySelectorAll('.calendar td').forEach(cell => cell.classList.remove('selected'));
                                    cell.classList.add('selected');
                                    document.getElementById('selected-date').value = fullDate;
                                    document.getElementById('appointment-form').querySelector('input[type="submit"]').disabled = false;
                                });
                            } else {
                                cell.classList.add('booked');
                            }

                            row.appendChild(cell);
                            date++;
                        }
                    }

                    calendarBody.appendChild(row);
                }
            }

            // Initial calendar generation
            generateCalendar(currentMonth, currentYear);

            // Event listeners for navigation buttons
            document.getElementById('prevMonth').addEventListener('click', function() {
                currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
                currentYear = (currentMonth === 11) ? currentYear - 1 : currentYear;
                generateCalendar(currentMonth, currentYear);
            });

            document.getElementById('nextMonth').addEventListener('click', function() {
                currentMonth = (currentMonth === 11) ? 0 : currentMonth + 1;
                currentYear = (currentMonth === 0) ? currentYear + 1 : currentYear;
                generateCalendar(currentMonth, currentYear);
            });

            // Event listener for time slots
            timeSlots.forEach(slot => {
                slot.addEventListener('click', function() {
                    timeSlots.forEach(slot => slot.classList.remove('selected'));
                    this.classList.add('selected');
                    document.getElementById('selected-time').value = this.getAttribute('data-time');
                    document.getElementById('appointment-form').querySelector('input[type="submit"]').disabled = false;
                });
            });
        });
    </script>
</body>
</html>
