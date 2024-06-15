<?php
// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "patient_database"; // Change this to the name of your MySQL database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    } else {
        // Check if email already exists
        $check_email_query = "SELECT * FROM PatientAccount WHERE Email = '$email'";
        $check_email_result = $conn->query($check_email_query);
        if ($check_email_result->num_rows > 0) {
            echo "Email already exists";
        } else {
            // Insert new user into database
            $insert_query = "INSERT INTO PatientAccount (PatientID, Email, Password) VALUES ((SELECT PatientID FROM Patient WHERE PatientName = '$name'), '$email', '$password')";
            $conn->query($insert_query);
            echo "Account created successfully";
            header('Location: login.php'); // Redirect to login page
            exit;
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <title>Register Page</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            position: relative; /* Set position to relative, absolute, or fixed */
            left: -10px; /* Adjust the left position to push the text to the left */
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
        <h2>Register Form</h2>
        <!-- PHP code for registration form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
