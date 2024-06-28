<?php
session_start();

if (isset($_SESSION["name"])) {
    header("Location: index.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "patient_database";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $email = $password = "";
$name_err = $email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($name_err) && empty($email_err) && empty($password_err)) {
        $sql_check = "SELECT AccountID FROM PatientAccount WHERE Email = ?";
        
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();
            
            if ($stmt_check->num_rows == 1) {
                $email_err = "This email is already taken.";
            } else {
                $sql_insert = "INSERT INTO PatientAccount (Name, Email, Password) VALUES (?, ?, ?)";
                
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt_insert->bind_param("sss", $name, $email, $hashed_password);
                    
                    if ($stmt_insert->execute()) {
                        header("location: login.php");
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }

                    $stmt_insert->close();
                }
            }

            $stmt_check->close();
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
    <title>Registration Page</title>
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
        <div class="form-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Register</h1>
                <div <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                    <input class="input" type="text" name="name" placeholder="Your Full Name" value="<?php echo $name; ?>" required>
                    <span class="help-block"><?php echo $name_err; ?></span>
                </div>
                <div <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <input class="input" type="email" name="email" placeholder="youremail@domain.com" value="<?php echo $email; ?>" required>
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <input class="input" type="password" name="password" placeholder="Password (minimum 6 characters)" required>
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <button class="submit" type="submit">Register</button>
                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </div>
</body>
</html>
