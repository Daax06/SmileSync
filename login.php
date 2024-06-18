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
    height: 500px;
    margin: 0;
}

header {
    color: #333;
    
}

.container{
    background-color: white ;
    border-radius: 30px;
    box-shadow: 0 5px 10px rgba(0,0,0.35);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 500px;
}

.container p{
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.3px;
    margin: 20px 0;
}

.container span{
    font-size: 12px;
}

.container a{
    color: #333;
    font-size: 13px;
    text-decoration: none;
    margin: 15px;
}

.container button{
    background-color: #abc1d4;
    color: black;
    font-size: 12px;
    padding: 10px 45px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 10px;
    cursor: pointer;
}

.container button.hidden{
    background-color: transparent !important;
    border-color: #fff;
}

.container form{
    background-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    height: 100%;
}

.container input{
    background-color: #eee;
    border: none;
    margin: 8px 0;
    padding: 10px 15px;
    font-size: 13px;
    border-radius: 8px;
    width: 100%;
    outline: none;
}

.form-container{
    position: absolute;
    top: 0;
    height: 600px;
    transition: all 0.6s ease-in-out;
}

.sign-in{
    left: 0;
    width: 50%;
    z-index: 2;
}
    </style>
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
                    <button>Sign In</button>
                </form>
            </div>
</body>
</html>
