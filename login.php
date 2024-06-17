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
        $login_query = "SELECT * FROM PatientAccount WHERE Email = '$email' AND Password = '$password'";
        $result = $conn->query($login_query);

        if ($result->num_rows > 0) {
            echo "Login successful";
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
    <link rel="stylesheet" href="login_styles.css">
    <title>Login Page</title>
    
</head>
<body>
            <div class="form-container sign-in">
                <form>
                    <h1>Login</h1>
                    <span> or use your email & password</span>
                    <input type="text" placeholder="username"/>
                    <input type="text" placeholder="youremail@domain.com"/>
                    <input type="text" placeholder="password"/>
                    <a href="#"> Forgot Your Password? </a> 
                    <button>Sign In</button>
                </form>
            </div>
</body>
</html>
