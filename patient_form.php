<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Patient_Database";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT MAX(PatientID) AS max_id FROM Patient";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$max_id = $row['max_id'];
$new_patient_id = $max_id ? $max_id + 1 : 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $insert_query = "INSERT INTO Patient (PatientID, PatientName, Age, Gender, Address)
                     VALUES ('$new_patient_id', '$name', '$age', '$gender', '$address')";

    if ($conn->query($insert_query) === TRUE) {
        echo "Patient added successfully!";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Form</title>
</head>
<body>
    <h1>Patient Form</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Patient ID: <input type="text" name="patient_id" value="<?php echo $new_patient_id; ?>" readonly><br><br>
        Name: <input type="text" name="name" required><br><br>
        Age: <input type="number" name="age" required><br><br>
        Gender:
        <input type="radio" name="gender" value="Male" required>Male
        <input type="radio" name="gender" value="Female" required>Female
        <input type="radio" name="gender" value="Other" required>Other<br><br>
        Address: <textarea name="address" required></textarea><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
