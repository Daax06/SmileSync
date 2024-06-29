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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize input
    $selected_date = isset($_POST['selected_date']) ? htmlspecialchars($_POST['selected_date']) : null;
    $selected_time = isset($_POST['selected_time']) ? htmlspecialchars($_POST['selected_time']) : null;

    if ($selected_date && $selected_time) {
        // Example: Check if patient exists, or insert new patient record
        // For simplicity, assume we have a function to handle this
        $patientID = getPatientID($conn); // Implement this function to get or insert a patient ID

        // Prepare SQL statement to insert data into Scheduling table
        $stmt = $conn->prepare("INSERT INTO scheduling (PatientID, Date, Time, Doctor) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iss", $patientID, $selected_date, $selected_time, $doctor);

        // Set parameters and execute SQL statement
        $doctor = 'Dr. Smith'; // Example doctor name, replace with actual data

        if ($stmt->execute() === TRUE) {
            session_start();
            $_SESSION['appointment'] = [
                'date' => $selected_date,
                'time' => $selected_time
            ];
            header("Location: confirmation.php"); // Redirect to confirmation page
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Function to get or insert patient ID (example function, adjust as per your actual logic)
function getPatientID($conn) {
    // Example: Inserting a new patient record if not exists and returning the ID
    $firstName = 'John'; // Example first name, replace with actual data
    $lastName = 'Doe'; // Example last name, replace with actual data

    $stmt = $conn->prepare("INSERT INTO patient (FirstName, LastName) VALUES (?, ?)");
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();

    $patientID = $stmt->insert_id;

    $stmt->close();

    return $patientID;
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
            flex-direction: column;
            align-items: center;
        }
        .title-column,
        .calendar,
        .time-slots {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }
        .title-column h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
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
            display: flex;
            justify-content: center;
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
            let currentYear = new Date().getFullYear(); // Current year
            const availableDates = <?php echo json_encode($available_dates); ?>;

            // Function to generate calendar for the given month and year
            function generateCalendar(month, year) {
                // Clear previous calendar body
                calendarBody.innerHTML = '';

                // Get the first day of the month and the number of days in the month
                const firstDay = new Date(year, month).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Update month and year display
                monthYear.textContent = new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

                // Generate calendar rows and cells
                let date = 1;
                for (let i = 0; i < 6; i++) {
                    const row = document.createElement('tr');

                    for (let j = 0; j < 7; j++) {
                        const cell = document.createElement('td');

                        if (i === 0 && j < firstDay) {
                            cell.innerHTML = '';
                        } else if (date > daysInMonth) {
                            break;
                        } else {
                            const currentDate = new Date(year, month, date);
                            const formattedDate = currentDate.toISOString().split('T')[0];

                            cell.innerHTML = date;
                            cell.setAttribute('data-date', formattedDate);

                            if (!availableDates.includes(formattedDate)) {
                                cell.classList.add('booked');
                            }

                            date++;
                        }

                        row.appendChild(cell);
                    }

                    calendarBody.appendChild(row);
                }
            }

            // Function to handle calendar navigation
            function navigateCalendar(direction) {
                if (direction === 'prev') {
                    currentMonth--;
                    if (currentMonth < 0) {
                        currentMonth = 11;
                        currentYear--;
                    }
                } else if (direction === 'next') {
                    currentMonth++;
                    if (currentMonth > 11) {
                        currentMonth = 0;
                        currentYear++;
                    }
                }
                generateCalendar(currentMonth, currentYear);
            }

            // Event listeners for calendar navigation
            document.getElementById('prevMonth').addEventListener('click', () => navigateCalendar('prev'));
            document.getElementById('nextMonth').addEventListener('click', () => navigateCalendar('next'));

            // Initial calendar generation
            generateCalendar(currentMonth, currentYear);

            // Event listener for date selection
            calendarBody.addEventListener('click', function(event) {
                const target = event.target;

                if (target.tagName === 'TD' && target.getAttribute('data-date') && !target.classList.contains('booked')) {
                    document.querySelectorAll('.calendar td').forEach(td => td.classList.remove('selected'));
                    target.classList.add('selected');
                    document.getElementById('selected-date').value = target.getAttribute('data-date');
                    document.querySelector('#appointment-form input[type="submit"]').disabled = false;
                }
            });

            // Event listener for time slot selection
            timeSlots.forEach(slot => {
                slot.addEventListener('click', function() {
                    timeSlots.forEach(s => s.classList.remove('selected'));
                    this.classList.add('selected');
                    document.getElementById('selected-time').value = this.getAttribute('data-time');
                    document.querySelector('#appointment-form input[type="submit"]').disabled = false;
                });
            });
        });
    </script>
</body>
</html>