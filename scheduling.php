<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmileSync - Scheduling</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@100;400;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto Condensed', sans-serif;
        }
        body {
            background-color: #f4f4f4;
            padding-top: 70px; /* Add padding-top to make space for the fixed header */
        }

        .container {
            width: 80%;
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 20px;
        }

        .section h2 {
            margin-bottom: 10px;
            font-size: 1.5rem;
            color: #4CAF50;
        }

        .section p, .section ul {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .section ul {
            list-style-type: disc;
            margin-left: 20px;
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
        }

        #nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        #nav ul li {
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

        .thin-header h1 {
            font-size: 24px;
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
        <div class="section">
            <h2>Schedule an Appointment</h2>
            <form action="scheduling.php" method="POST">
                <label for="patientID">Patient ID:</label>
                <input type="text" id="patientID" name="patientID" required><br><br>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required><br><br>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required><br><br>
                <input type="submit" value="Schedule Appointment">
            </form>
        </div>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $patientID = $_POST['patientID'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            // Insert the new appointment into the Scheduling table
            $sql = "INSERT INTO Scheduling (PatientID, Date, Time) VALUES ($patientID, '$date', '$time')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='section'><p>New appointment scheduled successfully!</p></div>";
            } else {
                echo "<div class='section'><p>Error: " . $sql . "<br>" . $conn->error . "</p></div>";
            }
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
