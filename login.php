<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "patient_database";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    } else {
        $login_query = "SELECT * FROM PatientAccount WHERE Email = ? AND Password = ?";
        $stmt = $conn->prepare($login_query);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header('Location: patient_form.php');
            exit;
        } else {
            echo "Invalid email or password";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
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
            background-color: transparent;
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 768px;
            min-height: 500px;
            padding: 20px;
            box-sizing: border-box;
        }

        .form-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 400px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            padding: 40px;
            box-sizing: border-box;
        }

        .form-container h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container input {
            margin: 10px 0;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        .form-container button {
            margin-top: 20px;
            padding: 12px;
            font-size: 14px;
            background-color: #abc1d4;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
        }
    </style>
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form method="post">
                <h1>Login</h1>
                <input type="email" name="email" placeholder="youremail@domain.com" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
