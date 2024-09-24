<?php
session_start();

if (file_exists(__DIR__ . "/config.php")) {
    include(__DIR__ . "/config.php");
} else {
    die("Error: config.php not found in " . __DIR__ . "/php/");
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $result = mysqli_query($con, "SELECT * FROM admin_users WHERE email='$email' AND password='$password'") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if (is_array($row) && !empty($row)) {
        $_SESSION['valid'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['id'] = $row['ID'];
        header("Location: home.php");
        exit();
    } else {
        echo "<div class='message'>
            <p>Wrong Email or Password</p>
        </div><br>";
        echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
    }
}

if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
    echo "<div class='message'>
            <p>Registration successful! Please log in.</p>
          </div><br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .form-box {
            padding: 20px;
        }
        .form-box header {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field label {
            display: block;
            margin-bottom: 5px;
        }
        .field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .links {
            text-align: center;
            margin-top: 10px;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="" method="post">
                <div class="field">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
