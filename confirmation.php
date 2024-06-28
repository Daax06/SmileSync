<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .confirmation-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 50%;
            max-width: 500px;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        p {
            margin-bottom: 10px;
        }
        .details {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h1>Appointment Confirmation</h1>
        <?php
        session_start();
        if (isset($_POST['selected_date']) && isset($_POST['selected_time'])) {
            $_SESSION['selected_date'] = $_POST['selected_date'];
            $_SESSION['selected_time'] = $_POST['selected_time'];
        }
        if (isset($_SESSION['selected_date']) && isset($_SESSION['selected_time'])) {
            $selected_date = $_SESSION['selected_date'];
            $selected_time = $_SESSION['selected_time'];
            echo "<p>Selected Date: $selected_date</p>";
            echo "<p>Selected Time: $selected_time</p>";
        } else {
            echo "<p>No appointment selected.</p>";
            exit();
        }
        ?>

        <form action="save_appointment.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="sex">Sex</label>
                <select id="sex" name="sex" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="procedure">Procedure</label>
                <select id="procedure" name="procedure" required>
                    <option value="">Select Procedure</option>
                    <option value="Cleaning">Cleaning</option>
                    <option value="Braces">Braces</option>
                    <option value="Braces Extraction">Braces Extraction</option>
                    <option value="Tooth Whitening">Tooth Whitening</option>
                    <option value="Tooth Extraction">Tooth Extraction</option>
                    <option value="Filling">Filling</option>
                    <option value="Root Canal">Root Canal</option>
                    <option value="Check-Up">Check-Up</option>
                    <!-- Add more procedures as needed -->
                </select>
            </div>
            <input type="hidden" name="selected_date" value="<?php echo $selected_date; ?>">
            <input type="hidden" name="selected_time" value="<?php echo $selected_time; ?>">
            <button type="submit">Confirm Appointment</button>
        </form>
    </div>
</body>
</html>
