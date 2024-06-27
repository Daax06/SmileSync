<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmileSync - Dental Appointment Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .appointment-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 1000px;
        }

        .calendar {
            grid-column: 2 / 3;
            margin-bottom: 20px;
        }

        .time-slots {
            grid-column: 3 / 4;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .calendar table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
<body>
    <div class="appointment-container">
        <div class="title-column">
            <h1>SmileSync - Dental Appointment Booking</h1>
            <p>Select a date and time for your appointment:</p>
        </div>
        
        <div class="calendar">
            <?php
            // Example of available dates and times
            $available_dates = [
                "2024-06-28", "2024-06-29", "2024-06-30"
            ];

            // Example of already booked dates and times
            $booked_slots = [
                "2024-06-28" => ["10:00 AM", "2:00 PM"],
                "2024-06-29" => ["9:00 AM", "11:00 AM", "3:00 PM"],
                "2024-06-30" => ["1:00 PM"]
            ];

            // Generate calendar
            foreach ($available_dates as $date) {
                echo '<h3>' . date("F j, Y", strtotime($date)) . '</h3>';
                echo '<table>';
                echo '<tr><th>Time</th><th>Status</th></tr>';
                $timeslots = ["9:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM"];
                foreach ($timeslots as $time) {
                    $status = in_array($time, $booked_slots[$date] ?? []) ? 'booked' : 'available';
                    $class = $status == 'booked' ? ' class="booked"' : '';
                    echo '<tr><td' . $class . '>' . $time . '</td><td>' . ucfirst($status) . '</td></tr>';
                }
                echo '</table>';
            }
            ?>
        </div>
        
        <div class="time-slots">
            <?php
            // Generate time slots buttons
            foreach ($timeslots as $time) {
                $disabled = in_array($time, $booked_times) ? ' disabled' : '';
                echo '<button class="time-slot' . $disabled . '" data-time="' . $time . '">' . $time . '</button>';
            }
            ?>
        </div>
        
        <form id="appointment-form" action="scheduling.php" method="POST">
            <input type="hidden" id="selected-date" name="date">
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
                    if (!this.classList.contains('booked')) {
                        calendarCells.forEach(cell => cell.classList.remove('selected'));
                        this.classList.add('selected');
                        document.getElementById('selected-date').value = this.parentElement.dataset.date;
                        document.getElementById('appointment-form').querySelector('input[type="submit"]').disabled = false;
                    }
                });
            });

            timeSlots.forEach(slot => {
                slot.addEventListener('click', function() {
                    if (!this.classList.contains('disabled') && !this.classList.contains('selected')) {
                        timeSlots.forEach(slot => slot.classList.remove('selected'));
                        this.classList.add('selected');
                        document.getElementById('selected-time').value = this.getAttribute('data-time');
                        document.getElementById('appointment-form').querySelector('input[type="submit"]').disabled = false;
                    }
                });
            });
        });
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selected_date = $_POST['date'];
        $selected_time = $_POST['selected_time'];

        // Database connection details
        $servername = "localhost"; // Replace with your MySQL host
        $username = "root"; // Replace with your MySQL username
        $password = ""; // Replace with your MySQL password
        $dbname = "dental_appointments"; // Replace with your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement to insert data into appointments table
        $sql = "INSERT INTO appointments (date, time) VALUES ('$selected_date', '$selected_time')";

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
