<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "clinic";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patients data
$sql = "SELECT id, surname, firstname, middlename, gender, course, year, section FROM patients";
$result = $conn->query($sql);

// HTML structure
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Records</title>
    <link rel="stylesheet" href="patientstyles.css">
</head>
<body>
    <div class="container">
        <h1>Patient Records</h1>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Surname</th>
                <th>Firstname</th>
                <th>Middlename</th>
                <th>Gender</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"]. "</td>
                            <td>" . $row["surname"]. "</td>
                            <td>" . $row["firstname"]. "</td>
                            <td>" . $row["middlename"]. "</td>
                            <td>" . $row["gender"]. "</td>
                            <td>" . $row["course"]. "</td>
                            <td>" . $row["year"]. "</td>
                            <td>" . $row["section"]. "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No records found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
