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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_styles.css">
    <title>Login Page</title>
    
</head>
<body>
    <h1 id="header">Login</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>