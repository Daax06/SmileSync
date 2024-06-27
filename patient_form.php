<?php
include 'db_connect.php';
?>

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
            max-width: 1000px;
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
    <script>
        function fetchPatients() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_patients.php', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById('patient-list').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }

        function addPatient(event) {
            event.preventDefault();

            var patientName = document.getElementById('patient_name').value;
            var age = document.getElementById('age').value;
            var gender = document.getElementById('gender').value;
            var address = document.getElementById('address').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'patient_form.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status == 200) {
                    fetchPatients();
                    document.getElementById('patientForm').reset();
                }
            };
            xhr.send('patient_name=' + patientName + '&age=' + age + '&gender=' + gender + '&address=' + address);
        }

        window.onload = function() {
            fetchPatients();
        }
    </script>
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
                <?php if (isset($_SESSION["name"])): ?>
                    <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION["name"]); ?>)</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Patient List</h1>
        <div id="patient-list">
            <!-- Patient list will be loaded here by JavaScript -->
        </div>

        <h2>Add New Patient</h2>
        <form id="patientForm" onsubmit="addPatient(event)">
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
    </div>
</body>
</html>
