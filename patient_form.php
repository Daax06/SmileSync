<!DOCTYPE html>
<html>
<head>
    <title>Patient List</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto Condensed', sans-serif;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('dentist_background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
        .container {
            max-width: 800px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-top: 20px;
        }
        form input, form select, form textarea {
            width: calc(100% - 16px);
            padding: 8px;
            margin: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #45a049;
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
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Patient List</h1>
        <table>
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                $query = "SELECT * FROM Patient";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['PatientID'] . "</td>";
                        echo "<td>" . $row['PatientName'] . "</td>";
                        echo "<td>" . $row['Age'] . "</td>";
                        echo "<td>" . $row['Gender'] . "</td>";
                        echo "<td>" . $row['Address'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No patients found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <h2>Add New Patient</h2>
        <form method="post" action="patient_form.php">
            <label for="patient_name">Name:</label>
            <input type="text" id="patient_name" name="patient_name" required><br>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required><br>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select><br>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" required></textarea><br>

            <button type="submit">Submit</button>
        </form>

        <h2>Update/Delete Patient</h2>
        <form method="post" action="update_delete.php">
            <label for="patient_id">Patient ID:</label>
            <input type="number" id="patient_id" name="patient_id" required><br>

            <label for="patient_name">Name:</label>
            <input type="text" id="patient_name" name="patient_name"><br>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age"><br>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select><br>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4"></textarea><br>

            <button type="submit" name="update">Update</button>
            <button type="submit" name="delete">Delete</button>
        </form>

        <h2>Search Patient</h2>
        <form method="post" action="search.php">
            <label for="search_name">Name:</label>
            <input type="text" id="search_name" name="search_name" required><br>
            <button type="submit">Search</button>
        </form>
    </div>
</body>
</html>
