<?php
// Define available dates and times
$available_dates = ["2024-06-28", "2024-06-29", "2024-06-30"];
$timeslots = ["9:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize input
    $selected_date = isset($_POST['selected_date']) ? htmlspecialchars($_POST['selected_date']) : null;
    $selected_time = isset($_POST['selected_time']) ? htmlspecialchars($_POST['selected_time']) : null;

    if ($selected_date && $selected_time) {
        // Process the appointment booking (for example, inserting into a database)
        // Replace with your actual database connection details
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

        // Close connection
        $conn->close();
    }
}
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
            height: 100vh;
            padding-top: 70px; /* Add padding-top to make space for the fixed header */
        }
        #nav ul li a:hover {
            text-decoration: underline;
        }
        .appointment-container {
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
            <?php
            // Generate calendar
            foreach ($available_dates as $date) {
                echo '<h3>' . date("F j, Y", strtotime($date)) . '</h3>';
                echo '<table>';
                echo '<tr><th>Time</th><th>Status</th></tr>';
                foreach ($timeslots as $time) {
                    echo '<tr><td>' . $time . '</td><td>Available</td></tr>';
                }
                echo '</table>';
            }
            ?>
        </div>
        
        <div class="time-slots">
            <?php
            // Generate time slots buttons
            foreach ($timeslots as $time) {
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
            const calendarCells = document.querySelectorAll('.calendar td:not(.booked)');
            const timeSlots = document.querySelectorAll('.time-slot');

            calendarCells.forEach(cell => {
                cell.addEventListener('click', function() {
                    calendarCells.forEach(cell => cell.classList.remove('selected'));
                    this.classList.add('selected');
                    document.getElementById('selected-date').value = this.parentElement.querySelector('h3').innerText;
                    document.getElementById('appointment-form').querySelector('input[type="submit"]').disabled = false;
                });
            });

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

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selected_date = $_POST['selected_date'];
        $selected_time = $_POST['selected_time'];

        // Database connection details (replace with your actual database credentials)
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

        // Prepare SQL statement to insert data into appointments table
        $sql = "INSERT INTO appointments (date, time) VALUES ('$selected_date', '$selected_time')";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "<p>Appointment booked successfully for $selected_date at $selected_time</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
    }
    ?>
</body>
</html>
