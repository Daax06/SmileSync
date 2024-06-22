<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];

    if (isset($_POST['update'])) {
        $patient_name = $_POST['patient_name'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];

        $query = "UPDATE Patient SET PatientName='$patient_name', Age=$age, Gender='$gender', Address='$address' WHERE PatientID=$patient_id";

        if ($conn->query($query) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $query = "DELETE FROM Patient WHERE PatientID=$patient_id";

        if ($conn->query($query) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
