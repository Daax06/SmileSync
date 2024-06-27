<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmileSync - Dental Appointment Booking</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto Condensed', sans-serif;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .appointment-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 600px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .calendar {
            margin-bottom: 20px;
        }

        .time-slots {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .time-slot {
            width: calc(25% - 10px);
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
        }

        .time-slot.disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .time-slot.selected {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="appointment-container">
        <h1>SmileSync - Dental Appointment Booking</h1>
        
        <div class="calendar">
            <h3>Select a Date:</h3>
            <input type="date" id="date" name="date" required>
        </div>
        
        <div class="time-slots">
            <?php
            // Example of available timeslots
            $available_times = [
                "9:00 AM", "10:00 AM", "11:00 AM", "12:00 PM",
                "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM"
            ];

            // Assume already booked times
            $booked_times = [
                "10:00 AM", "1:00 PM", "3:00 PM"
            ];

            // Generate time slots buttons
            foreach ($available_times as $time) {
                $disabled_class = in_array($time, $booked_times) ? ' disabled' : '';
                echo '<button class="time-slot' . $disabled_class . '" data-time="' . $time . '">' . $time . '</button>';
            }
            ?>
        </div>
        
        <form id="appointment-form" action="scheduling.php" method="POST">
            <input type="hidden" id="selected-time" name="selected_time">
            <input type="submit" value="Book Appointment" disabled>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timeSlots = document.querySelectorAll('.time-slot');

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
