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
    <style> 
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap');
*
html {
    position: relative;
    min-height: 100%;
}

html::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('dentist_background.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    filter: blur(1px);
    opacity: 0.5;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    color: #fff;
    min-height: 100%;
}


html::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

#container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

#email:hover{
    text-decoration: #59B0CC;
}

#header {
    background-color: #59B0CC;
    color: #fff;
    padding: 35px;
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
    position: relative; /* Set position to relative, absolute, or fixed */
    left: -10px; /* Adjust the left position to push the text to the left */
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
    position: relative; 
    left: -10px; 
}

#nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    margin-right: 200px;
}

#nav ul li {
    display: inline;
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
            </ul>
        </nav>
    </header>
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
