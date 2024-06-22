<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = $_POST['patient_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    if (empty($patient_name) || empty($age) || empty($gender) || empty($address)) {
        echo "All fields are required.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO Patient (PatientName, Age, Gender, Address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $patient_name, $age, $gender, $address);

    if ($stmt->execute()) {
        echo "New patient added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
