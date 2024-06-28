<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $procedure = $_POST['procedure'];
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
    $sql = "INSERT INTO appointments (name, age, sex, procedure, date, time) VALUES ('$name', '$age', '$sex', '$procedure', '$selected_date', '$selected_time')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "<p>Appointment booked successfully for $selected_date at $selected_time</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();

    // Redirect to a success page or display a success message
    header("Location: success.php");
    exit();
}
?>
