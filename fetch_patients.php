<?php
include 'db_connect.php';

$query = "SELECT * FROM Patient";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Patient ID</th>";
    echo "<th>Name</th>";
    echo "<th>Age</th>";
    echo "<th>Gender</th>";
    echo "<th>Address</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['PatientID'] . "</td>";
        echo "<td>" . $row['PatientName'] . "</td>";
        echo "<td>" . $row['Age'] . "</td>";
        echo "<td>" . $row['Gender'] . "</td>";
        echo "<td>" . $row['Address'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No patients found</p>";
}

$conn->close();
?>
