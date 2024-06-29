<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmileSync - Patient Page</title>
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
            <h2>Personal Information</h2>
            <p>Name: John Doe</p>
            <p>Age: 30</p>
            <p>Gender: Male</p>
            <p>Contact: johndoe@example.com</p>
        </div>
        
        <div class="section">
            <h2>Treatments Conducted</h2>
            <ul>
                <li>Teeth Cleaning - January 15, 2024</li>
                <li>Cavity Filling - March 22, 2024</li>
                <li>Root Canal - June 5, 2024</li>
            </ul>
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

        <div class="section">
            <h2>Maintenance Medications</h2>
            <p>None</p>
        </div>
        $patientID = 1; // Assume patient ID is 1 for demonstration purposes

        // Fetch personal information
        $sql = "SELECT PatientName, Age, Gender, Address FROM Patient WHERE PatientID = $patientID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='section'>
                    <h2>Personal Information</h2>
                    <p>Name: " . $row['PatientName'] . "</p>
                    <p>Age: " . $row['Age'] . "</p>
                    <p>Gender: " . $row['Gender'] . "</p>
                    <p>Address: " . $row['Address'] . "</p>
                </div>";
        } else {
            echo "<div class='section'><h2>Personal Information</h2><p>No information available.</p></div>";
        }

        <div class="section">
            <h2>Current Schedule</h2>
            <ul>
                <li>Dental Check-up - July 10, 2024 at 10:00 AM</li>
            </ul>
        </div>
        // Fetch treatments conducted
        $sql = "SELECT TreatmentStart FROM Progress WHERE PatientID = $patientID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<div class='section'><h2>Treatments Conducted</h2><ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>Treatment Date: " . $row['TreatmentStart'] . "</li>";
            }
            echo "</ul></div>";
        } else {
            echo "<div class='section'><h2>Treatments Conducted</h2><p>No treatments conducted.</p></div>";
        }

        <div class="section">
            <h2>History of Appointments</h2>
            <ul>
                <li>Teeth Cleaning - January 15, 2024</li>
                <li>Cavity Filling - March 22, 2024</li>
                <li>Root Canal - June 5, 2024</li>
            </ul>
        </div>
        // Fetch current schedule
        $sql = "SELECT Date, Time FROM Scheduling WHERE PatientID = $patientID AND Date >= CURDATE() ORDER BY Date, Time LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='section'>
                    <h2>Current Schedule</h2>
                    <ul>
                        <li>Dental Check-up - " . $row['Date'] . " at " . $row['Time'] . "</li>
                    </ul>
                </div>";
        } else {
            echo "<div class='section'><h2>Current Schedule</h2><p>No upcoming appointments.</p></div>";
        }

        // Fetch history of appointments
        $sql = "SELECT Date, Time FROM Scheduling WHERE PatientID = $patientID AND Date < CURDATE() ORDER BY Date DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<div class='section'><h2>History of Appointments</h2><ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>Appointment Date: " . $row['Date'] . " at " . $row['Time'] . "</li>";
            }
            echo "</ul></div>";
        } else {
            echo "<div class='section'><h2>History of Appointments</h2><p>No past appointments.</p></div>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>