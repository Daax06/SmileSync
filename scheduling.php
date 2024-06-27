<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Appointment Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label, input {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="appointment-container">
        <h1>Dental Appointment Booking</h1>
        <form id="appointment-form" action="scheduling.php" method="POST">
            <label for="date">Select a Date & Time:</label>
            <input type="date" id="date" name="date" required>
            <input type="time" id="time" name="time" required>
            <input type="submit" value="Book Appointment">
        </form>
    </div>

    <script>
        document.getElementById('appointment-form').addEventListener('submit', function(e) {
            const date = document.getElementById('date').value;
            const time = document.getElementById('time').value;

            if (!date || !time) {
                e.preventDefault();
                alert('Please select both a date and a time.');
            }
        });
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $date = $_POST['date'];
        $time = $_POST['time'];

        // Database connection (replace with your own database details)
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "dental_appointments";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO appointments (date, time) VALUES ('$date', '$time')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>New appointment booked successfully</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
