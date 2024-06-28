<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
</head>
<body>
    <div>
        <h1>Patient Profile</h1>
        <!-- Display patient details fetched from the database -->
        <?php
        // Example code to fetch and display patient details from the database
        include 'db_connect.php';

        // Assume you have a session or some identifier to fetch the patient's details
        // For example, using a session:
        session_start();
        $patient_id = $_SESSION['patient_id']; // Replace with your actual session variable

        $sql = "SELECT * FROM patients WHERE id = $patient_id"; // Adjust query as per your database schema
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<p>Name: ' . $row['name'] . '</p>';
            echo '<p>Age: ' . $row['age'] . '</p>';
            echo '<p>Sex: ' . $row['sex'] . '</p>';
            // Display other patient details as needed
        } else {
            echo 'No patient found.';
        }

        $conn->close();
        ?>

        <!-- Example: Link back to home or other pages -->
        <p><a href="index.html">Home</a></p>
        <p><a href="patient_form.php">Update Profile</a></p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
